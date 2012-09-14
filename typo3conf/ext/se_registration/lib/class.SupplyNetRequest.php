<?
	require_once(dirname(__FILE__).'/class.CurlRequest.php');

class SupplyNetRequest extends CurlRequest {
	function __construct($url,$func,$args){
		parent::__construct($abs = "$url?op={$func}Request");
		error_log("SOAP: $abs");
		$this->constructor_url = $url;
		$this->function = $func;
		$this->args = $args;
		$this->setMethod(HTTP_REQUEST_METHOD_POST);
	}
	function getPostDataString(){
		$output="<?xml version='1.0' encoding='UTF-8'?>\n";
		//$output.='<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
		$output.='<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://localhost/TradingPortal"><SOAP-ENV:Body>';
		$output.="<ns1:".$this->function."Request>";
		foreach($this->args as $k=>$v){
			//$output .= "<$k><![CDATA[$v]]></$k>\n";
			$output .= "<ns1:$k>".str_replace(array("<",">"),array("&lt;","&gt;"),$v)."</ns1:$k>";
		}
		$output.="</ns1:".$this->function."Request>";
		$output.="</SOAP-ENV:Body>";
		$output.="</SOAP-ENV:Envelope>\n";
		error_log("POST: $output");
		return utf8_encode($output);
	}
	function curlOptions($h){
		parent::curlOptions($h);
		curl_setopt($h,CURLOPT_HTTPHEADER,array("SOAPAction: \"http://localhost/TradingPortal/".$this->function."Request\"","Content-Type: text/xml; charset=utf-8"));
	}
	function getResponseXML(){
		error_log("RESPONSE: ".parent::getResponseBody());
		$xml = parent::getResponseXML();
		if($xml !== false){
			$xml = simplexml_load_string(str_replace(array("<SOAP-ENV:","</SOAP-ENV:"),array("<","</"),$xml->asXML()));
		}
		return $xml;
	}
}

class SupplyNetClient {
	function __construct($url= false){
		if(!$url) $url = "http://".SUPPLYNET_DOMAIN."/Supplynet/Customer.asmx";
		$this->url = $url;
	}
	function __call($func,$args){
		$req = new SupplyNetRequest($this->url,$func,$args[0]);
		$xml = $req->getResponseXML();
		if($xml!==false){
			if($fault = $xml->Body->Fault){
				throw new Exception("SOAP Fault '$fault->faultcode' - '$fault->faultstring'");
			}
			return $xml->Body;
		} else {
			throw new Exception("Could not parse SOAP response '".$req->getResponseBody()."'");
		}
	}
}
?>
