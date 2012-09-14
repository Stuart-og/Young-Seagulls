<?

class CURLRequest {
	function __construct($url){
		$this->url=$url;
	}
	function setUrl($url){
		$this->url = $url;
	}

	function sendRequest(){
		$h = $this->ch = curl_init();
		$this->curlOptions($h);
		$this->exec($h);
	}
	function curlOptions($h){
		curl_setopt($h,CURLOPT_URL,$this->url);
		curl_setopt ($h, CURLOPT_RETURNTRANSFER, 1) ;
		if($this->isPost){
			curl_setopt($h,CURLOPT_POST,1);
			curl_setopt($h,CURLOPT_POSTFIELDS,$this->getPostDataString());
		}
	}
	function getPostDataString(){
		return join("&",$this->post);
	}

	function exec($h){
		$this->res = curl_exec($h);
		if(!$this->res){
			foreach(curl_getinfo($h) as $k=>$v){
				echo "<$k>$v</$k>";
			}
		}
		if(!$this->res) $this->res = curl_error($h);
		if(!$this->res) $this->res = "Unknown Error";
	}

	function getResponseBody(){
		if(!$this->isReady()) $this->sendRequest($this->ch);
		return $this->res;
	}
	function getResponseXML(){
		if($this->xml) return $this->xml;
		if($body = $this->getResponseBody()) return $this->xml = simplexml_load_string($body);
		return false;
	}
	function getResponseHeader($k){
		return false;
	}
	function setMethod($method){
		$this->isPost = ($method==HTTP_REQUEST_METHOD_POST);
	}
	function isReady(){
		return $this->res;
	}
	function addPostData($k,$v){
		$this->post[$k] = "$k=$v";
	}
	function cleanUp(){
		curl_close($this->ch);
	}
}

class MultiCURLRequest extends CURLRequest {
	static $mh;
	static $maxRequests = 15;
	static $outRequests = 0;
	static $running = array();
	static $index = 1;
	var $timeout=20;
	function __construct($url,$multi=false){
		parent::__construct($url);
		$this->multi = $multi;
	}
	function getResponseBody($block=true){
		if(!$this->isReady()) {
			$this->exec($this->ch);
			if($this->multi && $block)
			       while(!$this->isReady()) {
					$this->block();
				}
		}
		return $this->res;
	}

	function exec($h){
		if($this->exec) return;
		$this->exec = time();
		if($this->multi){
			if((self::$maxRequests>0)&&(count(self::$running)>=self::$maxRequests)) $this->block(self::$maxRequests);
			self::$outRequests++;
			if(!self::$mh) self::$mh = curl_multi_init();
			curl_multi_add_handle(self::$mh,$h);
			curl_multi_exec(self::$mh,$running);
			$this->register();
		} else {
			parent::exec($h);
		}
	}

	function isReady(){
		if(parent::isReady()) return true;
		if($this->multi){
			$content = curl_multi_getcontent($this->ch);
			if($this->xml = @simplexml_load_string($content)){
				$this->res = $content;
				$this->cleanUp();
//				echo "Received $this->url\n";
				return true;
			}
		}
		return false;
	}
	static $displayEvery = 1;
	function register(){
		static $count;
		if($count++%self::$displayEvery==0) echo "+";
		self::$running[$this->index = ++self::$index] = $this;
	}
	function cleanUp($success=true){
		static $count;
		$success = $success ? 1:0;
		if($count[$success]++%self::$displayEvery==0) echo $success?"-":"x";

		curl_multi_remove_handle(self::$mh,$this->ch);
		unset(self::$running[$this->index]);
		$this->exec=false;
		parent::cleanUp();
	}
	function checkTimedOut($restart = true){
		if((!$this->isReady()) && (time()>$this->exec+$this->timeout)){
			$this->cleanUp(false);
			$this->sendRequest();
		}
	}

	function block($max = 0){
		$running = count(self::$running);
		$lastChange = time();
		while(($running>$max) && $lastChange>time()-10){
			foreach(self::$running as $request){
				$request->checkTimedOut();
			}
			$lastRunning = $running;
			$running = count(self::$running);
			curl_multi_exec(self::$mh,$actRunning);
			if($lastRunning!=$running){
				$lastChange=time();
			}
			self::$outRequests = $running;
			if($running) curl_multi_select(self::$mh);

			//NO GLOBAL TIMEOUT
			$lastChange=time();
		}
	}
}

	class AccuWebRequest extends MultiCURLRequest {
		function __construct($uri,$params = array(),$request_config=array()){
			parent::__construct($url = $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ev_chateau_importer']['api-address'].$uri,$params['multi']);
//			if(preg_match("_(^http://[^/]+)(/.*$)_",$url,$match)) {
//				$hostName=$match[1];
//				$uri = $match[2];
//			}
			$params['securitycode'] = $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ev_chateau_importer']['api-key'];

			
			foreach($params as $k=>$v){
				if((strpos($k,'date')!==false) && is_numeric($v)){
					$v = date("d/m/Y",$v);
				}
				if($k=='propertylist'){
					$v = utf8_encode(html_entity_decode($v));
				}
				$params[$k]=$v;
				$this->addPostData($k,$v);
			}
			$this->postParams = $params;


			$config_defaults = array(
				'uri_append'=>'',
				'http_method'=>HTTP_REQUEST_METHOD_GET
			);
			$request_config = array_merge($config_defaults,$request_config);
			// We should not have to do this but it copes with the poor configuration of Kelworth's server.
			$uri.=$request_config['uri_append'];

			$this->setMethod($request_config['http_method']);

			$hostName = "http://acumen.webapplicationsuk.com/";
			$baseUrl = $hostName."SimplyChateau/API/";
			$redirect = $uri;
			do {
//				echo "Requesting $baseUrl$redirect\n";
				$this->setUrl($this->requestedUrl = $baseUrl.$redirect);
				if(PEAR::isError($this->sendRequest())) //throw new Exception("Connection Failure");
				    return false;
			} while($redirect = $this->getResponseHeader('Location'));

//echo $this->getResponseBody();
			if($body = $this->getResponseBody(false)){
				$this->xml = @simplexml_load_string($body);
			}
			if($this->xml===false) {
				//ob_start();
				//echo "URL: $url\n";
				//print_r($this->postParams);
				//$request = ob_get_contents();
				//ob_end_clean();
				//throw new Exception("Could not parse web service response\n\n".$this->getResponseBody()."\n\n".$request);
			}
		}
		function parseDate($string){
			list($d,$m,$y) = explode("/",$string);
			return mktime(0,0,0,$m,$d,$y);
		}
	}
?>
