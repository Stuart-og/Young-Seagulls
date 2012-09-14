<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010  <>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Seagulls Profile' for the 'se_registration' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_seregistration
 */
class tx_seregistration_viewplugin extends tslib_pibase {
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf) {
		$content = $this->view('index');
		return $this->pi_wrapInBaseClass($content);
	}
	function getConfigDirs(){
		$extPath = t3lib_extMgm::extPath($this->extKey);
		$dirs = array();
		$dirs[] = $extPath.'/'.dirname($this->scriptRelPath);
		$dirs[] = $extPath;
		return $dirs;
	}
	function view($fname,$values=array()){
		$defaults = array(
			"user"=>$GLOBALS['TSFE']->fe_user->user,
			"pid"=>$this->cObj->parentRecord['data']['uid'],
		);
		$values = array_merge($defaults,$values);
		foreach($this->getConfigDirs() as $dir){
			if(file_exists($fullPath = "$dir/views/$fname.php")){
				extract($values);
				ob_start();
				include($fullPath);
				$content = ob_get_contents();
				ob_end_clean();
				return $content;
			}
		}
	}

	function findPageByTitle($id){
		$db = $GLOBALS['TYPO3_DB'];
		$r = $db->sql_fetch_row($db->sql_query("SELECT uid FROM pages WHERE title='$id'"));
		return $r[0];
	}
	function makeLink($id,$params=array()){
		if(!is_numeric($id)){
			$id = $this->findPageByTitle($id);
		}
		$q='';
		foreach($params as $k=>$v){
			$q.="&".urlencode($k)."=".urlencode($v);
		}
		return '/'.$this->cObj->typoLink('',array(
			'parameter'=>$id,
			'useCacheHash'=>true,
			'additionalParams'=>$q,
			'returnLast'=>'url'
		));
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/se_registration/pi/class.tx_seregistration_formplugin.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/se_registration/pi/class.tx_seregistration_formplugin.php']);
}

?>
