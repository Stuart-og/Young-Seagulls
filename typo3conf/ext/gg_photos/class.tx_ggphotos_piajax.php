<?
	class tx_ggphotos_dummysyspage {
		function getPage_noCheck($uid){
			return $this->getPage($uid);
		}
		function getPage(){
			return 1;
		}
		function getMountPointInfo(){
			return false;
		}
		function linkData(){
		}
	}
	class tx_ggphotos_piajax {
		static $url = null;
		function ajaxFromRealUrl($params,$realurl){
			$url = $params['params']['pObj']->siteScript;
			if($parts = $this->parseUrl($url)){
				$params['URL']="?id=$parts[pid]";
				$realurl->pObj->id=$parts['pid'];
			}
		}
		function ajaxIdMethods($params){
			if($parts = $this->parseUrl()){
				$GLOBALS['TSFE']->id=$parts['pid'];
			}
		}

		function resolveId($url){
			$parts = $this->parseUrl($url);
			return $parts['pid'];
		}
		function parseUrl($url){
			if($url){
				self::$url = $url;
			} else {
				$url = self::$url;
			}
			if(strpos($url,"pi_ajax/")===0){
				list($script,$qstring) = explode("?",$url);
				$parts = explode("/",$script);
				$plugin = array_slice($parts,1,2);
				$leftOver = array_slice($parts,3);
				$pid = array_shift($leftOver);

				return array('plugin'=>$plugin,'pid'=>$pid,'args'=>$leftOver);
			}
		}
		function doAjax($params){
			die("HMMMM ".__FUNCTION__);
			$pObj = $params['pObj'];
			$tsfe = $params['tslib_fe'];
			if(strpos($pObj->siteScript,"pi_ajax/")===0){
				//require_once(dirname(__FILE__).'/../../../typo3/sysext/cms/tslib/class.tslib_content.php');
//				require_once(PATH_t3lib.'/class.t3lib_tstemplate.php');
				$tmpl = t3lib_div::makeInstance('t3lib_tstemplate');
				$tmpl->init();
				$tsfe->sys_page = t3lib_div::makeInstance('tx_ggphotos_dummysyspage');
				$tsfe->sys_page = t3lib_div::makeInstance('t3lib_pageSelect');
				$tsfe->sys_page->init();
				$tsfe->getPageAndRootline();
				$tsfe->initTemplate();
				$tsfe->getFromCache();
				$tsfe->getConfigArray();
				$tsfe->tmpl = $tmpl;

				$plugin = $this->getPlugin($plugin);


				$plugin->doAjax($leftOver);
				exit(0);
			}

		}
		function getPlugin($ids){
			list($module,$piName) = $ids;
			$modShort = str_replace("_","",$module);
			$className = "tx_{$modShort}_$piName";
//			$GLOBALS['TSFE']->config['config']['language'] = false;
			require_once(t3lib_extMgm::extPath($module)."/$piName/class.$className.php");
			$plugin = new $className();
			$cobj = t3lib_div::makeInstance('tslib_cObj');
			$plugin->cObj=$cobj;
			$parts = $this->parseUrl();
			$plugin->pid = $parts['pid'];
			return $plugin;
		}

		function checkDataSubmission(){
			$tsfe = $GLOBALS['TSFE'];
			$parts = $this->parseUrl();
			if($parts){
				$plugin = $this->getPlugin($parts['plugin']);
				$plugin->doAjax($parts['args']);
				exit();
			}
		}
	}
?>
