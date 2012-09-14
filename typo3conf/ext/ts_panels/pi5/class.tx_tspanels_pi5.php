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
 * Plugin 'TS Stadium Downloads Panel' for the 'ts_panels' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_tspanels
 */
class tx_tspanels_pi5 extends tslib_pibase {
	var $prefixId      = 'tx_tspanels_pi5';		// Same as class name
	var $scriptRelPath = 'pi5/class.tx_tspanels_pi5.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'ts_panels';	// The extension key.
	
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
		<div class="carbonbox h1">
			<h2>Downloads</h2>
			<img width="83" height="85" style="margin-top: -10px;" class="right imgalpha" alt="Downloads" src="fileadmin/ts-templates/img/stadium/Stadium_arrow.png">
			<p>Ipsum dolor sit amet, consectetur adipiscing elit. Mauris ornare orci non nisi tempus.</p>
			<a class="button bottom" href="team-stripes/stadium/downloads/">More Information ></a>
			<div class="clearer"></div>
		</div>';
			
		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ts_panels/pi5/class.tx_tspanels_pi5.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ts_panels/pi5/class.tx_tspanels_pi5.php']);
}

?>