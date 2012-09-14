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
 * Plugin 'TS Ad Panels' for the 'ts_ad_panels' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_tsadpanels
 */
class tx_tsadpanels_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_tsadpanels_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_tsadpanels_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'ts_ad_panels';	// The extension key.
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

		$rand = rand(1,3);

		switch ($rand) {
			case 1:
				$id = 'ts-ad-tickets';
				$text = 'Get your tickets <span class="white">here!</span>';
				$link = 'http://www.seagulls.talent-sport.co.uk/';
			break;
			case 2:
				$id = 'ts-ad-official';
				$text = 'Visit the Official <span class="white">Site!</span>';
				$link = 'http://www.seagulls.co.uk/';
			break;
			case 3:
				$id = 'ts-ad-shop';
				$text = 'Official Albion <span class="white">gear!</span>';
				$link = 'http://www.seagullsdirect.co.uk/';
			break;
		}	

		$content='<div id="'.$id.'" class="ts-ad-panel">
		            <a href="'.$link.'" target="new"></a>
			  		<h2 class="spacer">'.$text.'</h2>
				  </div>';

		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ts_ad_panels/pi1/class.tx_tsadpanels_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ts_ad_panels/pi1/class.tx_tsadpanels_pi1.php']);
}

?>