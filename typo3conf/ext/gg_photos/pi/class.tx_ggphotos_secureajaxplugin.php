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

require_once(dirname(__FILE__).'/class.tx_ggphotos_ajaxplugin.php');


/**
 * Plugin 'GG Photos' for the 'gg_photos' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggphotos
 */
abstract class tx_ggphotos_secureajaxplugin extends tx_ggphotos_ajaxplugin {
	function doAjax($pathParts){
		$this->handleAuthToken($_GET['token']);
		parent::doAjax($pathParts);
	}

	function makeAjaxLink($action,$params=array()){
		$params['token'] = $this->makeAuthToken();
		return parent::makeAjaxLink($action,$params);
	}

	function makeAuthToken(){
		return $GLOBALS['TSFE']->fe_user->user['uid'];
	}

	function handleAuthToken($token){
		$db = $GLOBALS['TYPO3_DB'];
		$GLOBALS['TSFE']->fe_user->user = $db->sql_fetch_assoc($db->sql_query("SELECT * FROM fe_users WHERE uid='$token'"));
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_photos/pi1/class.tx_ggphotos_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_photos/pi1/class.tx_ggphotos_pi1.php']);
}

?>
