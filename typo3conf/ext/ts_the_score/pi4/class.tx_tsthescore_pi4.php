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
 * Plugin 'TS The Score Next Fixture' for the 'ts_the_score' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_tsthescore
 */
class tx_tsthescore_pi4 extends tslib_pibase {
	var $prefixId      = 'tx_tsthescore_pi4';		// Same as class name
	var $scriptRelPath = 'pi4/class.tx_tsthescore_pi4.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'ts_the_score';	// The extension key.
	
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
		
		$now = time();

		$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT uid,opposition,datetime,homeaway,venue FROM tx_ggthescore_match WHERE datetime > '.$now.' AND deleted != 1 ORDER BY datetime ASC LIMIT 1');
		while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			$id = $row['uid'];
		    $date_time = date('D jS M. H:i',$row['datetime']);
			$opposition = $row['opposition'];
			$venue = $row['venue'];
		}
		
		$content='
		<div class="carbonbox h1 nextfixture">
			<h2>Next <span class="white">Fixture</span></h2>
			<div class="above">';
			
		if ($row['homeaway'] = 0) {  // Home game
			$fixture .= '<p class="tie">Brighton vs '.$opposition.'</p>';
		} else { // Away game
			$fixture .= '<p class="tie">'.$opposition.' vs Brighton</p>';
		}
		
		$content .= '
			<p class="tie">'.$fixture.'</p>
			<p class="date"><a href="/team-stripes/the-score/match-report/?report_id='.$id.'">'.$date_time.'</a></p>
			<p><a href="/team-stripes/the-score/match-report/?report_id='.$id.'">'.$venue.'</a></p>
			
			</div>
			<img src="fileadmin/ts-templates/img/news/News_balls2.png" alt="Fire" width="220" height="41" class="bottomleft imgalpha" />
		</div>';
	
		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ts_the_score/pi4/class.tx_tsthescore_pi4.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ts_the_score/pi4/class.tx_tsthescore_pi4.php']);
}

?>