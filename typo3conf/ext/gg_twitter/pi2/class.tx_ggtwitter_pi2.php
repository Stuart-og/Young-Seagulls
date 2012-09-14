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
 * Plugin 'GG Twitter Panel' for the 'gg_twitter' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggtwitter
 */
class tx_ggtwitter_pi2 extends tslib_pibase {
	var $prefixId      = 'tx_ggtwitter_pi2';		// Same as class name
	var $scriptRelPath = 'pi2/class.tx_ggtwitter_pi2.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gg_twitter';	// The extension key.
	
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

		$GLOBALS['TSFE']->additionalHeaderData['script.marquee'] = '<script type="text/javascript" src="fileadmin/templates/js/marquee.js"></script>';
        $GLOBALS['TSFE']->additionalHeaderData['script.start_marquee'] = '<script type="text/javascript"> $(document).ready(function (){ $("#marquee").marquee(); });</script>';

		$my_username = 'youngseagulls';
		$tweet = $this->get_latest_tweet($my_username);

		$content .= '
		<ul id="marquee" class="marquee">
			<li>
				<a href="http://twitter.com/youngseagulls" target="new">
					'.$tweet.'
				</a>
			</li>
		</ul>';

		return $content;
	}
	
	function get_latest_tweet($username) {
		$url = "http://search.twitter.com/search.atom?q=from:$username&rpp=1";
		$content = file_get_contents($url);
		$content = explode('<content type="html">', $content);
		$content = explode('</content>', $content[1]);
		return str_replace(array("&apos;"),array("'"),html_entity_decode($content[0]));
	}
	
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_twitter/pi2/class.tx_ggtwitter_pi2.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_twitter/pi2/class.tx_ggtwitter_pi2.php']);
}

?>