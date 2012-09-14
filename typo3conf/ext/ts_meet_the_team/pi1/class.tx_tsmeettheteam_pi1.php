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
 * Plugin 'TS Meet the Team' for the 'ts_meet_the_team' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_tsmeettheteam
 */
class tx_tsmeettheteam_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_tsmeettheteam_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_tsmeettheteam_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'ts_meet_the_team';	// The extension key.
	
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

		$GLOBALS['TSFE']->additionalHeaderData['script.mtt'] = '<script type="text/javascript" src="typo3conf/ext/ts_meet_the_team/mtt.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData['css.mtt'] = '<link rel="stylesheet" href="fileadmin/ts-templates/css/ts-mtt.css" type="text/css" media="screen" />';

		/* Goalkeepers */
		$gkRes = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tx_ggmeettheteam_players WHERE deleted != 1 AND hidden != 1 AND player_type = 0 ORDER BY lastname ASC');
		$goalkeepers = '<li><h3>Goalkeepers</h3>';
		$i =0;
		$numGk = mysql_num_rows($gkRes);
		while($gkRow = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($gkRes)) {
			#print_r($gkRow);
			$gkUid = $gkRow['uid'];
			$gkPics = explode(',',$gkRow['pics']);
			$gkThumb = '/uploads/tx_ggmeettheteam/'.$gkPics[0];
			$gkName = $gkRow['firstname'].' '.$gkRow['lastname'];
			$goalkeepers .= '<div class="gg-player-card"><a href="#" onclick="loadPlayer('.$gkUid.'); return false;"><img alt="" src="'.$gkThumb.'" /></a><p>'.$gkName.'</p></div>';
			$i++;
			if ($i % 2 == 0) {
				$goalkeepers .= '<div class="clearer"></div>';
			}
			if ($i % 6 == 0 && $i < $numGk) {
				$goalkeepers .= '<div class="clearer"></div></li><li><h3>Gooooalkeepers</h3>';
			}
		}
		$goalkeepers .= '<div class="clearer"></div></li>';
		
		/* Defenders */
		$dfRes = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tx_ggmeettheteam_players WHERE deleted != 1 AND hidden != 1 AND player_type = 1 ORDER BY lastname ASC');
		$defenders = '<li><h3>Defenders</h3>';
		$i =0;
		$numDf = mysql_num_rows($dfRes);
		while($dfRow = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($dfRes)) {
			$dfUid = $dfRow['uid'];
			$dfPics = explode(',',$dfRow['pics']);
			$dfThumb = '/uploads/tx_ggmeettheteam/'.$dfPics[0];
			$dfName = $dfRow['firstname'].' '.$dfRow['lastname'];
			$defenders .= '<div class="gg-player-card"><a href="#" onclick="loadPlayer('.$dfUid.'); return false;"><img alt="" src="'.$dfThumb.'" /></a><p>'.$dfName.'</p></div>';
			$i++;
			if ($i % 2 == 0) {
				$defenders .= '<div class="clearer"></div>';
			}
			if ($i % 6 == 0 && $i < $numDf) {
				$defenders .= '<div class="clearer"></div></li><li><h3>Defenders</h3>';
			}
		}
		$defenders .= '<div class="clearer"></div></li>';
		
		/* Midfielders */
		$mfRes = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tx_ggmeettheteam_players WHERE deleted != 1 AND hidden != 1 AND player_type = 2 ORDER BY lastname ASC');
		$midfielders = '<li><h3>Midfielders</h3>';
		$i =0;
		$numMf = mysql_num_rows($mfRes);
		while($mfRow = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($mfRes)) {
			$mfUid = $mfRow['uid'];
			$mfPics = explode(',',$mfRow['pics']);
			$mfThumb = '/uploads/tx_ggmeettheteam/'.$mfPics[0];
			$mfName = $mfRow['firstname'].' '.$mfRow['lastname'];
			$midfielders .= '<div class="gg-player-card"><a href="#" onclick="loadPlayer('.$mfUid.'); return false;"><img alt="" src="'.$mfThumb.'" /></a><p>'.$mfName.'</p></div>';
			$i++;
			if ($i % 2 == 0) {
				$midfielders .= '<div class="clearer"></div>';
			}
			if ($i % 6 == 0 && $i < $numMf) {
				$midfielders .= '<div class="clearer"></div></li><li><h3>Midfielders</h3>';
			}
		}
		$midfielders .= '<div class="clearer"></div></li>';
		
		/* Strikers */
		$stRes = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tx_ggmeettheteam_players WHERE deleted != 1 AND hidden != 1 AND player_type = 3 ORDER BY lastname ASC');
		$strikers = '<li><h3>Strikers</h3>';
		$i =0;
		$numSt = mysql_num_rows($stRes);
		while($stRow = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($stRes)) {
			$stUid = $stRow['uid'];
			$stPics = explode(',',$stRow['pics']);
			$stThumb = '/uploads/tx_ggmeettheteam/'.$stPics[0];
			$stName = $stRow['firstname'].' '.$stRow['lastname'];
			$strikers .= '<div class="gg-player-card"><a href="#" onclick="loadPlayer('.$stUid.'); return false;"><img alt="" src="'.$stThumb.'" /></a><p>'.$stName.'</p></div>';
			$i++;
			if ($i % 2 == 0) {
				$strikers .= '<div class="clearer"></div>';
			}
			if ($i % 6 == 0 && $i < $numSt) {
				$strikers .= '<div class="clearer"></div></li><li><h3>Strikers</h3>';
			}
		}
		$strikers .= '<div class="clearer"></div></li>';
		
		/* Management */
		$stRes = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tx_ggmeettheteam_players WHERE deleted != 1 AND hidden != 1 AND player_type = 4 ORDER BY lastname ASC');
		$Management = '<li><h3>Management</h3>';
		$i =0;
		$numSt = mysql_num_rows($stRes);
		while($stRow = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($stRes)) {
			$stUid = $stRow['uid'];
			$stPics = explode(',',$stRow['pics']);
			$stThumb = '/uploads/tx_ggmeettheteam/'.$stPics[0];
			$stName = $stRow['firstname'].' '.$stRow['lastname'];
			$Management .= '<div class="gg-player-card"><a href="#" onclick="loadPlayer('.$stUid.'); return false;"><img alt="" src="'.$stThumb.'" /></a><p>'.$stName.'</p></div>';
			$i++;
			if ($i % 2 == 0) {
				$Management .= '<div class="clearer"></div>';
			}
			if ($i % 6 == 0 && $i < $numSt) {
				$Management .= '<div class="clearer"></div></li><li><h3>Management</h3>';
			}
		}
		$Management .= '<div class="clearer"></div></li>';

		

		/*
		$player_cards = '<li>';
		$i = 0;
		while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			#print_r($row);
			$id = $row['uid'];
			$name = $row['firstname'].' '.$row['lastname'];
			$position = $row['position'];
			$nationality = $row['nationality'];
			$nickname = $row['nickname'];
			$dob = date('d/m/Y',$row['dob']);
			$pics = explode(',',$row['pics']);
			$thumb = 'uploads/tx_ggmeettheteam/'.$pics[0];
			
			// Make up player cards
			$player_cards .= '<div class="ts-mtt-player-card"><a href="#" onclick="loadPlayer('.$id.'); return false;"><img src="'.$thumb.'" alt="Placeholder" width="110" height="120" /></a><p><a href="#">'.$name.'</a></p></div>';
			$i ++;
			if ($i %9 == 0) {
				$player_cards .= '</li><li>';
			}
		}
		$player_cards .= '</li>';
		*/

		$content='
		<div class="grid_2">
		<!-- Intro -->
			<div class="carbonbox h4">
				<h1>Meet <span class="white">The Team</span></h1>
				<p class="intro">Everything you need to know about the Albion players, including their special skills, favourite music and football idols!</p>  

				<div id="ts-mtt-slider">
					<ul>
						'.$goalkeepers.'
						'.$defenders.'
				  	    '.$midfielders.'
						'.$strikers.'
						'.$Management.'
						<div class="clearer"></div>
					</ul>
				</div>
			</div>
			<!-- End Intro -->
		</div>
		
		<div class="grid_2">
			<!-- Gallery -->
			<div class="carbonbox h4 slideshow-container">
			</div>
		<!-- End Gallery -->
		</div>';
	
		
		$first_res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tx_ggmeettheteam_players WHERE deleted != 1 AND hidden != 1 AND player_type = 0 ORDER BY lastname ASC');
		if (mysql_num_rows($first_res) > 0) {
			$first_row = mysql_fetch_assoc($first_res);
			#print_r($first_row['file']);
			#die();
			$first_player = $first_row['uid'];
			$content .= '<script type="text/javascript">jQuery(document).ready(function($) { loadPlayer("'.$first_player.'"); });</script>';
		}
		
	
		return $content;
	}
	
	
	function getPlayers ($player_type) {
		$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tx_ggmeettheteam_players WHERE deleted != 1 AND hidden != 1 AND player_type = '.$player_type);
		if (mysql_num_rows($res) > 0) {
			return $res;
		}
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ts_meet_the_team/pi1/class.tx_tsmeettheteam_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ts_meet_the_team/pi1/class.tx_tsmeettheteam_pi1.php']);
}

?>