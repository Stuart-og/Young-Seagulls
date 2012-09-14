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
 * Plugin 'TS The Score Report' for the 'ts_the_score' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_tsthescore
 */
class tx_tsthescore_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_tsthescore_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_tsthescore_pi1.php';	// Path to this script relative to the extension dir.
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
		$uid = $_GET['report_id'];
		if ($uid) {
			$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT uid,opposition,datetime,brightongoals,oppositiongoals,report,media,venue,homeaway,link FROM tx_ggthescore_match WHERE uid = '.$uid);
		} else {
			$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT uid,opposition,datetime,brightongoals,oppositiongoals,report,venue,homeaway,link FROM tx_ggthescore_match WHERE datetime < '.$now.' AND deleted != 1 ORDER BY datetime DESC LIMIT 1');
		}
		
		while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			$id = $row['uid'];
			$date_time = date('D jS M. H:i',$row['datetime']);
			$venue = $row['venue'];
			$opposition = $row['opposition'];
			$opposition_goals = $row['oppositiongoals'];
			$brighton_goals = $row['brightongoals'];
			$report = $row['report'];
			$link = $row['link'];
		}

		$report = explode("\n", $report);
		$number_paragraphs = count($report);
		$report_paragraphs = '';
		for ($i = 0; $i < $number_paragraphs; $i++) {
			if ($i == 0) {
				$report_paragraphs .= '<p class="intro">'.$report[$i].'</p>';
			} else {
				$report_paragraphs .= '<p>'.$report[$i].'</p>';
			}
		}
		
		if (!$_GET['report_id']) { // If there is no report_id this is the score landing page so limit the number of words displayed
			$report_paragraphs = explode(' ', $report_paragraphs);
			$match_report = '';
			for ($i = 0; $i <= 160; $i++) {
				$match_report .= $report_paragraphs[$i]." ";
			}
		} else { // Show all the report
			$match_report = $report_paragraphs;
		}
	
		if ($row['homeaway'] = 0) { // Home game
		  $fixture .= 'Brighton '.$brighton_goals.'-'.$opposition_goals.' '.$opposition;
		} else { // Away game
		  $fixture .= $opposition.' '.$opposition_goals.'-'.$brighton_goals.' Brighton';
		}

		$content='<h1 class="smallmargin white">'.$fixture.'</h1><h3>'.$date_time.' '.$venue.'</h3>'.$match_report.'...';
		
		/*
		if (!$_GET['report_id']) {
			$content .= '<a href="#" class="button blue_buttons bottom" targe="new">Official Match Report &#8250;</a>';
		}
		*/
		
		if ($link) {
			$content .= '<a href="'.$link.'" class="button blue_buttons bottom" target="new">Official Match Report &#8250;</a>';
		}
		
		$content .= '<div class="clearer"></div>';
	
		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ts_the_score/pi1/class.tx_tsthescore_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ts_the_score/pi1/class.tx_tsthescore_pi1.php']);
}

?>