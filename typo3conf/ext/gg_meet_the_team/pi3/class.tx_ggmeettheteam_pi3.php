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
 * Plugin 'GG Meet the Team Player Page' for the 'gg_meet_the_team' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggmeettheteam
 */
class tx_ggmeettheteam_pi3 extends tslib_pibase {
	var $prefixId      = 'tx_ggmeettheteam_pi3';		// Same as class name
	var $scriptRelPath = 'pi3/class.tx_ggmeettheteam_pi3.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gg_meet_the_team';	// The extension key.
	
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
		$this->pi_USER_INT_obj = 1;	// Configuring so caching is not expected. This value means that no cHash params are ever set. We do this, because it's a USER_INT object!;
		

		
		$GLOBALS['TSFE']->additionalHeaderData['css.mtt-gallery'] = '<link rel="stylesheet" href="fileadmin/templates/css/gg-gallery.css" type="text/css" media="screen" />';
		
		$GLOBALS['TSFE']->additionalHeaderData['css.ie6'] = '<!--[if lte IE 6]><link rel="stylesheet" href="fileadmin/templates/css/ie6.css" type="text/css" media="screen" /><![endif]-->';
		$GLOBALS['TSFE']->additionalHeaderData['css.ie7'] = '<!--[if IE 7]><link rel="stylesheet" href="fileadmin/templates/css/ie7.css" type="text/css" media="screen"><![endif]-->';

		$GLOBALS['TSFE']->additionalHeaderData['script.jqueryHistory'] = '<script type="text/javascript" src="fileadmin/templates/scr/jquery.history.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData['script.jqueryGalleriffic'] = '<script type="text/javascript" src="fileadmin/templates/scr/jquery.galleriffic.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData['script.jqueryOpacity'] = '<script type="text/javascript" src="fileadmin/templates/scr/jquery.opacityrollover.js"></script>';

		$GLOBALS['TSFE']->additionalHeaderData['script.mtt'] = '<script type="text/javascript" src="fileadmin/templates/scr/mtt.js"></script>';

		$GLOBALS['TSFE']->additionalHeaderData['script.mttInLine'] = '<script type="text/javascript"> document.write(\'<style>.noscript { display: none; }</style>\'); </script>';
		
		
		$GLOBALS['TSFE']->additionalHeaderData['script.mttSlider'] = '<script type="text/javascript" src="fileadmin/ts-templates/scr/easySlider1.7.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData['script.mttSliderCall'] = '<script type="text/javascript">$(document).ready(function(){ $("#ts-mtt-slider").easySlider({ auto: false, continuous: true }); });</script>';

		/* Goalkeepers */
		$gkRes = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT uid,firstname,lastname,number,biog,email,pics,rating FROM tx_ggmeettheteam_players WHERE deleted != 1 AND hidden != 1 AND player_type = 0 ORDER BY lastname ASC');
		$goalkeepers = '<li><h3>Goalkeepers</h3>';
		$i =0;
		$numGk = mysql_num_rows($gkRes);
		while($gkRow = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($gkRes)) {
			$gkUid = $gkRow['uid'];
			$gkPics = explode(',',$gkRow['pics']);
			$gkThumb = '/uploads/tx_ggmeettheteam/'.$gkPics[0];
			$gkName = $gkRow['firstname'].' '.$gkRow['lastname'];
			$goalkeepers .= '<div class="gg-player-card"><a href="gullys-gang/meet-the-team/?player_id='.$gkUid.'"><img alt="" src="'.$gkThumb.'" /></a><p>'.$gkName.'</p></div>';
			$i++;
			if ($i % 2 == 0) {
				$goalkeepers .= '<div class="clearer"></div>';
			}
			if ($i % 6 == 0 && $i < $numGk) {
				$goalkeepers .= '<div class="clearer"></div></li><li><h3>Goalkeepers</h3>';
			}
		}
		$goalkeepers .= '<div class="clearer"></div></li>';
		
		/* Defenders */
		$dfRes = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT uid,firstname,lastname,number,biog,email,pics,rating FROM tx_ggmeettheteam_players WHERE deleted != 1 AND hidden != 1 AND player_type = 1 ORDER BY lastname ASC');
		$defenders = '<li><h3>Defenders</h3>';
		$i =0;
		$numDf = mysql_num_rows($dfRes);
		while($dfRow = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($dfRes)) {
			print_r($dfRow);
			$dfUid = $dfRow['uid'];
			$dfPics = explode(',',$dfRow['pics']);
			$dfThumb = '/uploads/tx_ggmeettheteam/'.$dfPics[0];
			$dfName = $dfRow['firstname'].' '.$dfRow['lastname'];
			$defenders .= '<div class="gg-player-card"><a href="gullys-gang/meet-the-team/?player_id='.$dfUid.'"><img alt="" src="'.$dfThumb.'" /></a><p>'.$dfName.'</p></div>';
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
		$mfRes = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT uid,firstname,lastname,number,biog,email,pics,rating FROM tx_ggmeettheteam_players WHERE deleted != 1 AND hidden != 1 AND player_type = 2 ORDER BY lastname ASC');
		$midfielders = '<li><h3>Midfielders</h3>';
		$i =0;
		$numMf = mysql_num_rows($mfRes);
		while($mfRow = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($mfRes)) {
			$mfUid = $mfRow['uid'];
			$mfPics = explode(',',$mfRow['pics']);
			$mfThumb = '/uploads/tx_ggmeettheteam/'.$mfPics[0];
			$mfName = $mfRow['firstname'].' '.$mfRow['lastname'];
			$midfielders .= '<div class="gg-player-card"><a href="gullys-gang/meet-the-team/?player_id='.$mfUid.'"><img alt="" src="'.$mfThumb.'" /></a><p>'.$mfName.'</p></div>';
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
		$stRes = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT uid,firstname,lastname,number,biog,email,pics,rating FROM tx_ggmeettheteam_players WHERE deleted != 1 AND hidden != 1 AND player_type = 3 ORDER BY lastname ASC');
		$strikers = '<li><h3>Strikers</h3>';
		$i =0;
		$numSt = mysql_num_rows($stRes);
		while($stRow = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($stRes)) {
			$stUid = $stRow['uid'];
			$stPics = explode(',',$stRow['pics']);
			$stThumb = '/uploads/tx_ggmeettheteam/'.$stPics[0];
			$stName = $stRow['firstname'].' '.$stRow['lastname'];
			$strikers .= '<div class="gg-player-card"><a href="gullys-gang/meet-the-team/?player_id='.$stUid.'"><img alt="" src="'.$stThumb.'" /></a><p>'.$stName.'</p></div>';
			$i++;
			if ($i % 2 == 0) {
				$strikers .= '<div class="clearer"></div>';
			}
			if ($i % 6 == 0 && $i < $numSt) {
				$strikers .= '<div class="clearer"></div></li><li><h3>Strikers</h3>';
			}
		}
		$strikers .= '<div class="clearer"></div></li>';
		
		$content .= '
		<div id="gulls">
          <div class="seagull01"></div>
          <div class="seagull02"></div>
          <div class="seagull03"></div>
          <div class="seagull04"></div>
        </div>
        <!-- Left Column -->
        <div class="grid_2">
          <!-- gg-team-players-bg -->
          <div id="gg-team-players-bg">
            <div id="gg-team-players-top">
              <h2 class="spacer">Say a big \'hello\' to the <strong>Seagulls</strong></h2>
            </div>
            <!-- gg-team-players-cards -->
            <div id="gg-team-players-cards">

				<div id="ts-mtt-slider">
					<ul>
						'.$goalkeepers.'
						'.$defenders.'
				  	    '.$midfielders.'
						'.$strikers.'
						<div class="clearer"></div>
					</ul>
				</div>

            </div>
            <!-- /gg-team-players-cards -->
          </div>
          <!-- /gg-team-players-bg -->
        </div>
        <!-- /Left Column -->';
		
		
		
		
		if ($_GET['player_id']) { // Player has been chosen
			$player_id = $_GET['player_id'];
			$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT uid,firstname,lastname,number,position,biog,email,pics,rating FROM tx_ggmeettheteam_players WHERE deleted != 1 AND uid = '.$player_id.' ORDER BY number ASC');
		} else { // Display player with lowest squad number
			$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT uid,firstname,lastname,number,position,biog,email,pics,rating FROM tx_ggmeettheteam_players WHERE deleted != 1 ORDER BY number ASC LIMIT 1');
		}
		while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			#print_r($row);
			$fname = $row['firstname'];
			$lname = $row['lastname'];
			$email = $row['email'];
			$pics = $row['pics'];
			$position = $row['position'];
			$biog = $row['biog'];
			$uid = $row['uid'];
		}
		
		$thumbs = explode(',', $pics);
		$thumb_images = '';
		foreach($thumbs as $thumb) {
			$thumb_images .= '<li><a class="thumb" name="'.$fname.' '.$lname.'" href="uploads/tx_ggmeettheteam/'.$thumb.'" title="'.$fname.' '.$lname.'"><img src="uploads/tx_ggmeettheteam/'.$thumb.'" alt="'.$fname.' '.$lname.'" width="65" height="49" /></a></li>';
		}
		
		$content .= '
		<!-- Right Column -->
        <div class="grid_2">
          <div id="gg-team-info-bg">
            <!-- Gallery -->
            <div class="carbonbox h4 slideshow-container">
              <!-- Start Advanced Gallery Html Containers -->
              <div id="controls" class="controls"></div>
              <div id="loading" class="loader"></div>
              <div id="slideshow" class="slideshow"></div>
              <div id="gg-team-info-stats">
                <div id="thumbs" class="navigation"> <a class="pageLink prev" style="visibility: hidden;" href="#" title="Previous Page"></a>
                  <ul class="thumbs noscript">
                    '.$thumb_images.'
                  </ul>
                  <a class="pageLink next" style="visibility: hidden;" href="#" title="Next Page"></a>
                  <div>
                    <div>
                      <div id="gg-team-info">
                        <h2>'.$fname .' '.$lname.'</h2>
                        <h3><img alt="Star" src="fileadmin/templates/img/meettheteam/star.png">'.$position.'<img alt="Star" src="fileadmin/templates/img/meettheteam/star.png"></h3>
                        <p>'.$biog.'</p>
                      </div>
                      <div class="bottom-panel-bg">
                        <div class="bottom-panel">
                          <p class="football"><strong>New Images!</strong></p>
                          <a class="button" href="/gullys-gang/meet-the-team/player-detail/?uid='.$uid.'">Full Profile</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /#thumbs -->
              </div>
              <!-- End Gallery Html Containers -->
            </div>
            <!-- End Gallery -->
          </div>
        </div>
        <!-- /Right Column -->
        <div class="clearer"></div>';

		return $this->pi_wrapInBaseClass($content);

	

	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_meet_the_team/pi3/class.tx_ggmeettheteam_pi3.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_meet_the_team/pi3/class.tx_ggmeettheteam_pi3.php']);
}

?>