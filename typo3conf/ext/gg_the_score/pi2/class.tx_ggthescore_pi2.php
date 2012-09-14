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
 * Plugin 'GG The Score Prev Results' for the 'gg_the_score' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggthescore
 */
class tx_ggthescore_pi2 extends tslib_pibase {
	var $prefixId      = 'tx_ggthescore_pi2';		// Same as class name
	var $scriptRelPath = 'pi2/class.tx_ggthescore_pi2.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gg_the_score';	// The extension key.
	
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
	
		//$now = time();

		//$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT uid, opposition, datetime, brightongoals, oppositiongoals FROM tx_ggthescore_match WHERE datetime < '.$now.' AND deleted != 1 ORDER BY datetime DESC LIMIT 5');
		$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT uid, opposition, datetime, brightongoals, oppositiongoals FROM tx_ggthescore_match WHERE preview != 1 AND deleted != 1 ORDER BY datetime DESC LIMIT 5');

		$match = '';
		$i = 1;
		while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    //if ($row['oppositiongoals'] && $row['brightongoals']) {
				if ($i%2 == 0) {
					$match .= '<tr>';
				} else {
					$match .= '<tr class="odd">';
				}
				$match .= '  <td><a href="/gullys-gang/the-score/match-report/?report_id='.$row['uid'].'">'.$row['opposition'].'</a></td>';
				//$match .= '  <td>'.$row['oppositiongoals'].' - '.$row['brightongoals'].'</td>';
				$match .= '  <td>'.$row['brightongoals'].' - '.$row['oppositiongoals'].'</td>';
				$match .= '  <td> </td>';
				$match .= '</tr>';
				$i++;
			//}
		}
	
		$content='
		<div id="gg-scores-panel">
		  <div id="gg-scores-panel-top">
		    <h2 class="spacer">Previous Match Scores</h2>
		  </div>
		
		  <div class="content">
		    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		      <tbody>
			    '.$match.'
			  </tbody>
			</table>
		  </div>
		  
		  <div class="bottom-panel-bg">
			<div class="bottom-panel">
			  <p class="football"><strong>New Results!</strong></p>
			</div>
		  </div>
		</div>
		';
	
		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_the_score/pi2/class.tx_ggthescore_pi2.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_the_score/pi2/class.tx_ggthescore_pi2.php']);
}

?>