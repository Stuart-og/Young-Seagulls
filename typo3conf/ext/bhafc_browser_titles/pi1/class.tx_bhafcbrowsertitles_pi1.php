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
 * Plugin 'BHAFC Browser Titles' for the 'bhafc_browser_titles' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_bhafcbrowsertitles
 */
class tx_bhafcbrowsertitles_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_bhafcbrowsertitles_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_bhafcbrowsertitles_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'bhafc_browser_titles';	// The extension key.
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf) {
		$arr = array();
		$pageContent = $GLOBALS['TSFE']->content;
		preg_match("/<title>(.*?)<\/title>/", $pageContent, $arr);
		$titleTag = $arr[0];
		
		$rootLine = array_reverse($GLOBALS['TSFE']->rootLine);
		//debug ($rootLine);
		
		foreach ($rootLine as $page) {
			$pageTitles[] = ($page['title']);
		}
		
		$implodedTitles = implode(" | ", $pageTitles);
		
		$newTitle = '<title>Brighton & Hove Albion Football Club | '.$implodedTitles.'</title>';
		$GLOBALS['TSFE']->content = str_replace($titleTag, $newTitle, $GLOBALS['TSFE']->content);
		
		return false;
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/bhafc_browser_titles/pi1/class.tx_bhafcbrowsertitles_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/bhafc_browser_titles/pi1/class.tx_bhafcbrowsertitles_pi1.php']);
}

?>