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
 * Plugin 'GG The Score Full Report' for the 'gg_the_score' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggthescore
 */
class tx_ggthescore_pi5 extends tslib_pibase {
	var $prefixId      = 'tx_ggthescore_pi5';		// Same as class name
	var $scriptRelPath = 'pi5/class.tx_ggthescore_pi5.php';	// Path to this script relative to the extension dir.
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
	
		$uid = $_GET['report_id'];
		if ($uid) {
			$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT uid,opposition,datetime,brightongoals,oppositiongoals,report,media,venue,homeaway FROM tx_ggthescore_match WHERE uid = '.$uid);
			if (mysql_num_rows($res) > 0) {
				while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
					$id = $row['uid'];
					$date_time = date('D jS M. H:i',$row['datetime']);
					$venue = $row['venue'];
					$opposition = $row['opposition'];
					$opposition_goals = $row['oppositiongoals'];
					$brighton_goals = $row['brightongoals'];
					$report = $row['report'];
					$media = $row['media'];
					if ($row['homeaway'] == 0) {
						$home = true;
					}
				}
		
				$report = explode("\n", $report);
				$number_paragraphs = count($report);
				$report_paragraphs = '';
				for ($i = 0; $i < $number_paragraphs; $i++) {
					$report_paragraphs .= '<p>'.$report[$i].'</p>';
				}
			
				$content='
				<h1 id="gg-thescore-title">The Score</h1>
				<div id="gg-match-info">';
				
				if ($home) { // Home game
				  $content .= '<h2 class="nomargin">Brighton '.$brighton_goals.'-'.$opposition_goals.' '.$opposition.'</h2>';
				} else { // Away game
				  $content .= '<h2 class="nomargin">'.$opposition.' '.$opposition_goals.'-'.$brighton_goals.' Brighton</h2>';
				}
				  
				  
				$content .= '
				  <p class="matchinfo"><strong>'.$date_time.'</strong> '.$venue.' </p>
				  <p>'.$report_paragraphs.'</p>
				  
				  <a class="button" href="gullys-gang/the-score/">Back</a>
				  <div class="clearer"></div>
				</div>';
	
				$media = explode(',', $media);
				
				$media_count = count($media);
				
				if ($media_count > 1) {
					$number_media = count($media);
					$media_list = '';
					for($i = 0; $i < $number_media; $i++) {
						$media_list .= '
							<li>
							  <a class="thumb" name="'.$media[$i].'" href="uploads/tx_ggthescore/'.$media[$i].'" title="Brighton v '.$opposition.'">
								<img width="65" height="49" alt="Placeholder" src="uploads/tx_ggthescore/'.$media[$i].'" alt="'.$media[$i].'" />
							  </a>
							  <div class="caption">
								<div class="image-title">Title #1</div>
								<div class="image-desc">Description 1</div>
							  </div>
							</li>';
					}
				} else {
					$media_list = '';
				}
		
				$content .= '
				<div id="gg-score-media">
				
				  <!-- Start Advanced Gallery Html Containers -->				
				  <div class="navigation-container">
					<div id="thumbs" class="navigation">
					  <a class="pageLink prev" style="visibility: hidden;" href="#" title="Previous Page"></a>
				
						<ul class="thumbs noscript">
						
						  '.$media_list.'
						
						</ul>
				
						<a class="pageLink next" style="visibility: hidden;" href="#" title="Next Page"></a>
					  </div>
					</div>
					
					<div class="content">
					  <div class="slideshow-container">
						<div id="controls" class="controls"></div>
						<div id="loading" class="loader"></div>
						<div id="slideshow" class="slideshow"></div>
					  </div>
					  <div id="caption" class="caption-container">
						<div class="photo-index"></div>
					  </div>
					</div>
					<!-- End Gallery Html Containers -->
				  <div style="clear: both;"></div>
				</div>
		
				<div class="clearer"></div>';

			} else {
				$content = '<div id="gg-the-score-error-message"><h1>Ooops - something went wrong!</h1><p>We\'re sorry but we couldn\'t find the match report you are looking for. <a href="gullys-gang/the-score/">Please click here to try again</a></p></div>';
			}
		}	 else {
			$content .= '<div id="gg-the-score-error-message"><h1>Ooops - something went wrong!</h1><p>We\'re sorry but we couldn\'t find the match report you are looking for. <a href="gullys-gang/the-score/">Please click here to try again</a></p></div>';
		}
		
		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_the_score/pi5/class.tx_ggthescore_pi5.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_the_score/pi5/class.tx_ggthescore_pi5.php']);
}

?>