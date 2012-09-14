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
 * Plugin 'GG About Gully Detail' for the 'gg_about_gully' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggaboutgully
 */
class tx_ggaboutgully_pi2 extends tslib_pibase {
	var $prefixId      = 'tx_ggaboutgully_pi2';		// Same as class name
	var $scriptRelPath = 'pi2/class.tx_ggaboutgully_pi2.php';	// Path to this script relative to the extension dir.
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
	
		include ('wp-config.php');
		include ('wp-open-db.php');

		$res = mysql_query("SELECT ID,post_title,post_content,post_date,guid FROM gg_posts WHERE post_status = 'publish' ORDER BY post_date DESC LIMIT 1;");
		if (mysql_num_rows($res) >= 1) {
			$row = mysql_fetch_assoc($res);
			$id = $row['ID'];
			$title = $row['post_title'];
			$date = $row['post_date'];
			$date_expl = explode("-", $date, 3);
			$month = $date_expl[1]; 
			switch ($month) {
				case '01':
					$month = "January";
				break;
				case '02':
					$month = "February";
				break;
				case '03':
					$month = "March";
				break;
				case '04':
					$month = "April";
				break;
				case '05':
					$month = "May";
				break;
				case '06':
					$month = "June";
				break;
				case '07':
					$month = "July";
				break;
				case '08':
					$month = "August";
				break;
				case '09':
					$month = "September";
				break;
				case '10':
					$month = "October";
				break;
				case '11':
					$month = "November";
				break;
				case '12':
					$month = "December";
				break;
				
			}
			$day = substr($date_expl[2], 0, 2); 
			$content = strip_tags($row['post_content']);
			if ($row['guid']) {
				$image = $row['guid'];
			}
		}

		$contentShort = explode(" ", $content);
		$shortContent = '';
		for ($j = 0; $j <= 70; $j++) {
			$shortContent .= $contentShort[$j].' ';
		}
		
		$shortContent = preg_replace("/\[caption.*caption\]/","",$shortContent);
		
		$content='
				<div id="gg-common-top"></div> <!-- /#gg-common-top -->
				  <div class="entry" id="gg-common-middle">
				    <div class="date">
				      <span class="day">'.$day.'</span>
				      <span class="month">'.$month.'</span>
				    </div>
				    <h1><a title="'.$title.'" rel="bookmark" href="gullys-blog/?p='.$id.'">'.$title.'</a></h1>
				    <div class="entry">
				      '.@$guid.'
					  <p>'.$shortContent.'... <a title="'.$title.'" rel="bookmark" href="gullys-blog/?p='.$id.'">Read more</a></p>
				    </div>
				    <div class="clearer"></div>
				  </div> <!-- /#gg-common-niddle -->
				  <div id="gg-common-bottom">
				    <div class="bottom-panel-bg">
				      <div class="bottom-panel">
				        <p class="player">New Updates!</p><a class="button" href="gullys-blog">Visit Blog</a>
				      </div>
				    </div>
				</div> <!-- /#gg-common-bottom -->';
		
		include('wp-close-db.php');
	
		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_about_gully/pi2/class.tx_ggaboutgully_pi2.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_about_gully/pi2/class.tx_ggaboutgully_pi2.php']);
}

?>