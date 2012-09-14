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
 * Plugin 'GG About Gully' for the 'gg_about_gully' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggaboutgully
 */
class tx_ggaboutgully_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_ggaboutgully_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_ggaboutgully_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gg_about_gully';	// The extension key.
	
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

		include('wp-config.php');
		include('wp-open-db.php');
		
		$res = mysql_query("SELECT id,post_title,post_content FROM gg_posts WHERE post_status = 'publish' and post_type = 'post' ORDER BY post_date DESC LIMIT 1;");
		if (mysql_num_rows($res) >= 1) {
			while ($row = mysql_fetch_assoc($res)) {
				$id = $row['id'];
				$title = $row['post_title'];
				$content = $row['post_content'];
				$content = preg_replace("/\[caption.*caption\]/","",$content);
			}
		}

		$contentShort = explode(" ", $content);
		$shortContent = '';
		for ($j = 0; $j <= 31; $j++) {
			$shortContent .= $contentShort[$j].' ';
		}

		$content='
		<div id="gg-about-panel">
		  <div id="gg-about-panel-top"><h2 class="spacer">Keep up with all Gully\'s news on his blog</h2></div>
		  <div class="content">
		    <h3><a href="gullys-gang/about-gully/">'.$title.'</a></h3>
		    <p>'.$shortContent.'...</p>
		  </div>
		  <div id="gg-about-gully"></div>
		</div>
		<div id="gg-about-panel-bottom">
		  <div class="bottom-panel">
		    <a class="button" href="gullys-gang/about-gully/">Read More</a>
		  </div>
		</div>
		';
		
		include('wp-close-db.php');
	
		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_about_gully/pi1/class.tx_ggaboutgully_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_about_gully/pi1/class.tx_ggaboutgully_pi1.php']);
}

?>