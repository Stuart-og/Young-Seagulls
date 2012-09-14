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
 * Plugin 'GG Cheerleaders Fun Stuff' for the 'gg_cheerleaders' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggcheerleaders
 */
class tx_ggcheerleaders_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_ggcheerleaders_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_ggcheerleaders_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gg_cheerleaders';	// The extension key.
	
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
	
		$content='
		<div id="gg-cheerleader-panel">
		  <div id="gg-cheerleader-panel-top">
		    <h2 class="spacer">Try it for<br><strong>yourself!</strong></h2>
		  </div>
		  <div class="bottom-panel-bg">
			<div class="bottom-panel">
			  <p>Want to Dance?</p><a class="button" href="/gullys-gang/cheerleaders-corner/dance-with-gullys-girls/">Email Us</a>
			</div>
		  </div>
		</div>';
	
		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_cheerleaders/pi1/class.tx_ggcheerleaders_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_cheerleaders/pi1/class.tx_ggcheerleaders_pi1.php']);
}

?>