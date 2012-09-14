<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009  <>
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
 * Plugin 'GG Fan Zone Panel' for the 'gg_panels' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggpanels
 */
class tx_ggpanels_pi3 extends tslib_pibase {
	var $prefixId      = 'tx_ggpanels_pi3';		// Same as class name
	var $scriptRelPath = 'pi3/class.tx_ggpanels_pi3.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gg_panels';	// The extension key.
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	 
	// FAN ZONE PANEL
	function main($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		$this->pi_USER_INT_obj = 1;	// Configuring so caching is not expected. This value means that no cHash params are ever set. We do this, because it's a USER_INT object!
	
		#print_r($GLOBALS['TSFE']->fe_user->user);
		
		if ($GLOBALS['TSFE']->fe_user->user['ses_id']) {
			$content='
			  <div id="gg-fan-panel-top"><h2 class="spacer">Welcome back<br/> <strong>'.$GLOBALS['TSFE']->fe_user->user['name'].'</strong></h2></div>
			  <div class="bottom-panel-bg">
				<div class="bottom-panel">
				  <p><a href="gullys-gang/footer-toolkit/safeonline/">Safeonline</a></p><a class="button" href="gullys-gang/fan-zone/">Fan Zone</a>
				</div>
			  </div>';
		} else {
			$content='
			  <div id="gg-fan-panel-top"><h2 class="spacer">Not in the gang?<br/> <strong><a href="gullys-gang/join/">Click here to join</a></strong></h2></div>
			  <div class="bottom-panel-bg">
				<div class="bottom-panel">
				  <p><a href="gullys-gang/footer-toolkit/safeonline/">Safe Online</a></p><a class="button" href="gullys-gang/login/">Login</a>
				</div>
			  </div>';

		}
		
		$content = '<div id="gg-fan-panel">'.$content.'</div>';
	
		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_panels/pi3/class.tx_ggpanels_pi3.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_panels/pi3/class.tx_ggpanels_pi3.php']);
}

?>