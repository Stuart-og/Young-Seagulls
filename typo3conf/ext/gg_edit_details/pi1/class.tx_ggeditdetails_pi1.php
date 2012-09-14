<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2012  <>
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
 * Plugin 'GG Edit Details' for the 'gg_edit_details' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggeditdetails
 */
class tx_ggeditdetails_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_ggeditdetails_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_ggeditdetails_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gg_edit_details';	// The extension key.
	var $pi_checkCHash = true;
	
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
		
		if ($GLOBALS['TSFE']->fe_user->user['ses_id']) {
			$logged_in = true;
		} else {
			$logged_in = false;
		}
		
		if($logged_in == true){
		
			$content='
				<a id="edit-dets-btn">Edit Details</a>
			';
		
			return $this->pi_wrapInBaseClass($content);
		
		}
	
		
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_edit_details/pi1/class.tx_ggeditdetails_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_edit_details/pi1/class.tx_ggeditdetails_pi1.php']);
}

?>