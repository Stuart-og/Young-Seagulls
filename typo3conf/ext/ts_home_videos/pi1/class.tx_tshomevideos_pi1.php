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
 * Plugin 'TS Home Videos' for the 'ts_home_videos' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_tshomevideos
 */
class tx_tshomevideos_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_tshomevideos_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_tshomevideos_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'ts_home_videos';	// The extension key.
	
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
		
		$GLOBALS['TSFE']->additionalHeaderData['script.home'] = '<script type="text/javascript" src="typo3conf/ext/ts_home_videos/ts-home.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData['script.easyslider'] = '<script type="text/javascript" src="fileadmin/ts-templates/scr/easySlider1.7.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData['css.home'] = '<link rel="stylesheet" href="fileadmin/ts-templates/css/ts-home.css" type="text/css" media="screen" />';
	
		if ($GLOBALS['TSFE']->fe_user->user['ses_id']) {
			$logged_in = true;
			$user_uid = $GLOBALS['TSFE']->fe_user->user['uid'];
		} else {
			$logged_in = false;
		}

		$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tx_tshomevideos_videos WHERE deleted != 1 AND hidden != 1 ORDER BY uid DESC');
		
		$i = 1;
		$home_vid_thumbs = '<li>';
		while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			$file = $row['file'];
			if ($row['thumbnail']) {
				$thumb = 'uploads/tx_tshomevideos/'.$row['thumbnail'];
			} else {
				$thumb = 'fileadmin/ts-templates/img/placeholder.png';
			}
			$title = $row['title'];
			$home_vid_thumbs .= '<a href="#" onclick="loadVideo(\''.$file.'\'); return false;" title="'.$title.'"><img src="/typo3conf/thumb.php?src='.$thumb.'&w=65&h=49&zc=1" alt="'.$title.'" /></a>';
			//thumb.php?src=myimage.jpg&w=400&h=400&zc=1
			if (($i%5) == 0) {
				$home_vid_thumbs .= '</li><li>';
			}
			$i++;
		}
		$home_vid_thumbs .= '</li>';
	
		$content='
			<h2>Team Stripes <span class="white">Videos</span></h2>
			<div id="ts-home-video"></div>
			<!-- Gallery Thumbs -->
			<div class="gallery-thumbs">
				<div id="ts-home-slider">
					<ul>
						'.$home_vid_thumbs.'
					</ul>
				</div>
			</div>';
		
		$first_res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tx_tshomevideos_videos WHERE deleted != 1 AND hidden != 1 ORDER BY uid DESC LIMIT 1');
		if (mysql_num_rows($first_res) > 0) {
			$first_row = mysql_fetch_assoc($first_res);
			#print_r($first_row['file']);
			#die();
			$first_vid = $first_row['file'];
			$content .= '<script type="text/javascript">jQuery(document).ready(function($) { loadVideo("'.$first_vid.'"); });</script>';
		}
		
		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ts_home_videos/pi1/class.tx_tshomevideos_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ts_home_videos/pi1/class.tx_tshomevideos_pi1.php']);
}

?>