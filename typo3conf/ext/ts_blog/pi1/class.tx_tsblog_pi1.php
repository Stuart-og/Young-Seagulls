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
 * Plugin 'TS Blog' for the 'ts_blog' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_tsblog
 */
class tx_tsblog_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_tsblog_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_tsblog_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'ts_blog';	// The extension key.
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
		
		include('wp-config.php');
		include('wp-open-db.php');

		$res = mysql_query("SELECT id,post_title,post_content FROM gg_posts WHERE post_status = 'publish' and post_type = 'post' ORDER BY post_date DESC LIMIT 1;");
		if (mysql_num_rows($res) >= 1) {
			while ($row = mysql_fetch_assoc($res)) {
				$id = $row['id'];
				$title = $row['post_title'];
				$content = strip_tags($row['post_content']);
			}
		}

		$contentShort = explode(" ", $content);
		$shortContent = '';
		for ($j = 0; $j <= 60; $j++) {
			$shortContent .= $contentShort[$j].' ';
		}
	
		$content='
		  <div class="">
			<a href="/gullys-blog/" class="button">Read more</a>
			<h2>Gully\'s <span class="white">Blog</span></h2>
			<h4>'.$title.'</h4>
			<p>'.$shortContent.'...</p>
			<div class="clearer"></div>
		  </div>';
		
		include('wp-close-db.php');
	
		return $content;
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ts_blog/pi1/class.tx_tsblog_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ts_blog/pi1/class.tx_tsblog_pi1.php']);
}

?>