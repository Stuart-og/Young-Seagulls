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
 * Plugin 'GG Fanzone Photo Panel' for the 'gg_fanzone_photos' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggfanzonephotos
 */
class tx_ggfanzonephotos_pi2 extends tslib_pibase {
	var $prefixId      = 'tx_ggfanzonephotos_pi2';		// Same as class name
	var $scriptRelPath = 'pi2/class.tx_ggfanzonephotos_pi2.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gg_fanzone_photos';	// The extension key.
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
			<div id="gg-photo-panel-bg">
				<div id="gg-photo-panel-top"><h2 class="spacer">Send in<br><strong>your photos</strong></h2></div>
				<div class="content">
					<img width="85" height="79" src="/fileadmin/templates/img/fanzone/upload-pic.jpg"><p>Send us your cool Albion pictures and get them featured on this site!</p>
				</div>
				<div class="bottom-panel-bg">
					<div class="bottom-panel">
						<p><a href="/gullys-gang/fan-zone/rules/">Rules</a></p><a class="button nyroModal" href="/gullys-gang/fan-zone/upload-photo/">Enter</a>
					</div>
				</div> <!-- /#gg-photo-panel-bg -->
			</div>';
	
		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_fanzone_photos/pi2/class.tx_ggfanzonephotos_pi2.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_fanzone_photos/pi2/class.tx_ggfanzonephotos_pi2.php']);
}

?>