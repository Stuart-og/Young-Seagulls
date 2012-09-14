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

require_once(dirname(__FILE__).'/class.tx_seregistration_viewplugin.php');


/**
 * Plugin 'Seagulls Profile' for the 'se_registration' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_seregistration
 */
class tx_seregistration_formplugin extends tx_seregistration_viewplugin {
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf) {
	$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		$this->pi_USER_INT_obj = 1;	// Configuring so caching is not expected. This value means that no cHash params are ever set. We do this, because it's a USER_INT object!

		$page_id = $GLOBALS['TSFE']->id;

		$this->headerStuff($page_id);
		if($_POST['submit'] && ! $errors = $this->validationErrors($_POST)){
			$content = $this->processData($_POST);
		} else {
			$content = $this->view('form',array(
				'fields'=>$this->getFields(),
				'errors'=>$errors,
				'values'=>$this->getFormData(),
			));
		}
	
		return $this->pi_wrapInBaseClass($content);
	}
	
	
	function headerStuff($page_id){
		if ($page_id == '81') { // If it's Team Stripes' registration
			$GLOBALS['TSFE']->additionalHeaderData['registration.css'] = '<link rel="stylesheet" href="/fileadmin/ts-templates/css/ts-registration.css"></link>';
		} else {
			$GLOBALS['TSFE']->additionalHeaderData['registration.css'] = '<link rel="stylesheet" href="/fileadmin/templates/css/registration.css"></link>';
		}
		$GLOBALS['TSFE']->additionalHeaderData['jquery.validation'] = '<script type="text/javascript" src="/fileadmin/templates/js/jquery.validationEngine.js"></script>
					 <script type="text/javascript" src="/fileadmin/templates/js/jquery.validationEngine-en.js"></script>';
$GLOBALS['TSFE']->additionalHeaderData['se_registration.validation'] = '<script type="text/javascript">
$(document).ready(function() {
	$("#gg-reg-form input, #gg-reg-form select").each(function(){
		$input = $(this);
		if(!$input.attr("id"))$input.attr("id",$input.attr("name"));
	});
	$("#gg-reg-form").validationEngine();
	$("input.click-clear").focus(function(){
		$(this).val("");
		$(this).removeClass("click-clear");
		$(this).unbind("focus");
	});
	$("form").submit(function(){
		$("input.click-clear").val("");
	});
});
</script>
	';
	}
	function getFormData(){
		return $_POST;
	}

	function getFields(){
		foreach($this->getConfigDirs() as $dir){
			if(file_exists($file = "$dir/fields.php")){
				include($file);
				return $fields;
			}
		}
		throw new Exception("Could not find fields");
	}
	function processData($post){
		throw new Exception("PROCESS DATA IS NOT IMPLEMENTED");
	}
	function validationErrors($post){
		return false;
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/se_registration/pi/class.tx_seregistration_formplugin.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/se_registration/pi/class.tx_seregistration_formplugin.php']);
}

?>
