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

require_once(t3lib_extMgm::extPath('se_registration').'/pi/class.tx_seregistration_viewplugin.php');


/**
 * Plugin 'GG Photos' for the 'gg_photos' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggphotos
 */
abstract class tx_ggphotos_ajaxplugin extends tx_seregistration_viewplugin {
	function doAjax($pathParts){
		$action = array_shift($pathParts);
		$func = "ajax_$action";
		$this->$func($pathParts);
	}

	function makeAjaxLink($action,$params=array()){
		$piShort = dirname($this->scriptRelPath);
		if($this->pid) $pid = $this->pid;
		else $pid = $this->cObj->parentRecord['data']['uid'];
		foreach($params as $k=>$v){
			$params[$k] = "$k=$v";
		}
		if($params){
			$params = "?".join("&",$params);
		} else {
			$params = '';
		}
		return "/pi_ajax/$this->extKey/$piShort/$pid/$action$params";
	}

	function makeAjaxHiddenInputs($action,$params){
		echo "<input type='hidden' name='ajax-action' value='$action'/>";
		echo "<input type='hidden' name='ajax-target' value='".$this->makeAjaxLink($action,$params)."'/>";
	}
	function ajaxWrap($html){
		return $html."
			<script>
			$(function(){
				$('body').trigger('ajax');
			});
			</script>";
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_photos/pi1/class.tx_ggphotos_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_photos/pi1/class.tx_ggphotos_pi1.php']);
}

?>
