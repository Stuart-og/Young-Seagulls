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
 * Plugin 'GG Gully Walk' for the 'gg_gully_walk' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_gggullywalk
 */
class tx_gggullywalk_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_gggullywalk_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_gggullywalk_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gg_gully_walk';	// The extension key.
	
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
	
		// Get the ID of the current page
		$page_id = $GLOBALS['TSFE']->id;
		
		// Query tx_gggullywalk_gw to see if any records are for the page with $page_id
		$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tx_gggullywalk_gw WHERE deleted != 1 AND page = '.$page_id);
		if (mysql_num_rows($res) > 0) {
			$row = mysql_fetch_assoc($res);
			switch($row['walk_type']) {
				case 0: // walk-hi-five
					$walk_type = 'walk-hi-five';
				break;
				case 1: // moonwalk
					$walk_type = 'moonwalk';
				break;
				case 2: // walk-bodypop
					$walk_type = 'walk-bodypop';
				break;
				case 3: // walk-handsoneyes
					$walk_type = 'walk-handsoneyes';
				break;
				case 4: // walk-wave
					$walk_type = 'walk-wave';
				break;
				case 5: // walk-wink
					$walk_type = 'walk-wink';
				break;
			}

			if ($GLOBALS['TSFE']->fe_user->user['ses_id']) {
				$speech = mysql_real_escape_string($row['speech_bubble']);
			} else {
				$speech = mysql_real_escape_string($row['speech_bubble_not_in']);
			}
			
			$content = "
			<script language=\"javascript\">
				if (AC_FL_RunContent == 0) {
					alert('This page requires AC_RunActiveContent.js.');
				} else {
					AC_FL_RunContent(
						'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',
						'width', '550',
						'height', '400',
						'src', 'fileadmin/templates/swf/".$walk_type."',
						'quality', 'high',
						'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
						'align', 'middle',
						'play', 'true',
						'loop', 'true',
						'scale', 'showall',
						'wmode', 'transparent',
						'devicefont', 'false',
						'id', 'hi-five',
						'name', 'swf/".$walk_type."',
						'menu', 'true',
						'flashvars', 'my_flashvar=".$speech."',
						'allowFullScreen', 'false',
						'allowScriptAccess','sameDomain',
						'movie', 'fileadmin/templates/swf/".$walk_type."',
						'salign', ''
						); //end AC code
				}
			</script>
			
			<script type=\"text/javascript\">
				function hideDiv(id) { 
					document.getElementById(id).style.display = 'none'; 
				}
			</script>
			";
			
			return $content;
		}
		
		return;
	
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_gully_walk/pi1/class.tx_gggullywalk_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_gully_walk/pi1/class.tx_gggullywalk_pi1.php']);
}

?>