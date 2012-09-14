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
 * Plugin 'GG Fun Stuff Desktops Slider' for the 'gg_fun_stuff' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggfunstuff
 */
class tx_ggfunstuff_pi2 extends tslib_pibase {
	var $prefixId      = 'tx_ggfunstuff_pi2';		// Same as class name
	var $scriptRelPath = 'pi2/class.tx_ggfunstuff_pi2.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gg_fun_stuff';	// The extension key.
	
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
	
		if ($GLOBALS['TSFE']->fe_user->user['ses_id']) {
			$logged_in = true;
		} else {
			$logged_in = false;
		}
	
		$page_id = $GLOBALS['TSFE']->id;



		if ($logged_in) {
			switch ($page_id) {
				case 5: // Fun Stuff page
					$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM  tx_ggfunstuff_funstuff WHERE deleted != 1 AND desktop = 1 AND cheerleaders != 1 ORDER BY uid ASC');
				break;
				case 70: // Cheerleaders Fun Stuff page
					$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM  tx_ggfunstuff_funstuff WHERE deleted != 1 AND desktop = 1 AND cheerleaders = 1 ORDER BY uid ASC');
				break;
			}
			
			if (mysql_num_rows($res) > 0) {
				$thumbs = '';
				$i = 1;
				while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
					#print_r($row);
					$name = $row['name'];
					$desc = $row['description'];
					$file = $row['file'];
					$thumb = $row['thumbnail'];
					$thumbs .= '<a href="uploads/tx_ggfunstuff/'.$file.'" class="gg-fun-stuff-thumb" title="'.$name.'"><img src="uploads/tx_ggfunstuff/'.$row['thumbnail'].'" alt="'.$name.'" title="'.$name.'" width="115" height="99px" /></a>';
					if ($i %4 ==0 ) {
						$thumbs .= '</li><li>';
					}
					$i++;
				}
		
				$content .= '
				<div  id="gg-desktops-slider" class="gg-fun-stuff-slider">
				  <ul>
					<li>
					'.$thumbs.'
					</li>
				  </ul>
				</div>';
			} else {
				$content .= '';
			}
		} else { // Not logged in
			$content = '<h1>Log in to see Fun Stuff</h1>';
		}
	
		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_fun_stuff/pi2/class.tx_ggfunstuff_pi2.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_fun_stuff/pi2/class.tx_ggfunstuff_pi2.php']);
}

?>