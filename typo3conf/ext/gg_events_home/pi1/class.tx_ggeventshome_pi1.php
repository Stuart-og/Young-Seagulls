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
 * Plugin 'GG Events Home' for the 'gg_events_home' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggeventshome
 */
class tx_ggeventshome_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_ggeventshome_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_ggeventshome_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gg_events_home';	// The extension key.
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
		
	
		$content='
		<div id="gg-events-panel">
			<div id="gg-events-panel-top"></div>
			<div class="events-photo"></div>
			<div class="bottom-panel-bg">
				<div class="bottom-panel">
					<p class="events"><strong>Book Now</strong></p><a class="button" href="http://www.youngseagulls.co.uk/gullys-gang/events">Read More</a>
				</div>
			</div>
		</div>
		';
	
		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_events_home/pi1/class.tx_ggeventshome_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_events_home/pi1/class.tx_ggeventshome_pi1.php']);
}

?>