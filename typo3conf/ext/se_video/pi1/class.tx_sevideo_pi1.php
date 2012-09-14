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
 * Plugin 'Videos' for the 'se_video' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_sevideo
 */
class tx_sevideo_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_sevideo_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_sevideo_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'se_video';	// The extension key.
	
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
		
		$content='';
		
		if ($GLOBALS['TSFE']->rootLine['2']['pid'] == 3) {
			$site = 'gg'; // Gully's Gang
			$storageID = 32;
		} else {
			$site = 'ts'; // Team Stripes
			$storageID = 34;
		}
		
		$res = mysql_query('SELECT * FROM tx_sevideo_video WHERE pid = '.$storageID);
		if (mysql_num_rows($res) > 0) {
			while($row = mysql_fetch_assoc($res))  {
	        	$vidName = $row['name'];
				$vidDesc = $row['description'];
				$vidFile = 'uploads/tx_sevideo/'.$row['video'];
				$content .= $this->renderVideo($vidName, $vidDesc, $vidFile);
			}
		}

		return $content;
		//return $this->pi_wrapInBaseClass($content);
	}
	
	
	function renderVideo($name, $desc, $file) {
		$vidHTML = '<embed src="'.$file.'" width="650" height="500" autoplay="true"><br /><br />';
		return $vidHTML;
	}
	
	
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/se_video/pi1/class.tx_sevideo_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/se_video/pi1/class.tx_sevideo_pi1.php']);
}

?>