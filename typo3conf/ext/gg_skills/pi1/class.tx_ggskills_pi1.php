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
 * Plugin 'GG Skills' for the 'gg_skills' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggskills
 */
class tx_ggskills_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_ggskills_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_ggskills_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gg_skills';	// The extension key.
	
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
		
		$GLOBALS['TSFE']->additionalHeaderData['script.skills'] = '<script type="text/javascript" src="typo3conf/ext/gg_skills/skills.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData['script.easyslider'] = '<script type="text/javascript" src="fileadmin/ts-templates/scr/easySlider1.7.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData['css.skills'] = '<link rel="stylesheet" href="fileadmin/templates/css/skills.css" type="text/css" media="screen" />';
		$GLOBALS['TSFE']->additionalHeaderData['css.ie6'] = '<!--[if lte IE 6]><link rel="stylesheet" href="fileadmin/templates/css/ie6.css" type="text/css" media="screen" /><![endif]-->';
	
		$page_id = $GLOBALS['TSFE']->id;
		switch ($page_id) {
			case 40: // Skill level 1
				$skill_level = 1;
			break;
			case 41: // Skill level 2
				$skill_level = 2;
			break;
			case 42: // Skill level 3
				$skill_level = 3;
			break;
			case 43: // Skill level 4
				$skill_level = 4;
			break;
			default:
				$skill_level = 1;
			break;
		}
		
		if ($GLOBALS['TSFE']->fe_user->user['ses_id']) {
			$logged_in = true;
		} else {
			$logged_in = false;
		}
		
		if ($logged_in) {
			$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tx_ggskills_videos WHERE skill_level = '.$skill_level.' AND deleted != 1');
		} else {
			$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tx_ggskills_videos WHERE skill_level = '.$skill_level .' AND deleted != 1 LIMIT 2');
		}
		
		if ($skill_level == 4) {
			$skill_level = 1;
		}

		$i = 1;
		$vid_thumbs = '<li>';
		while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			$uid = $row['uid'];
			$title = $row['title'];
			$thumb = $row['thumbnail'];

			$vid_thumbs .= '<div class="gg-skills-vid-thumb">
			  				  <div class="gg-skills-vid-star-rating"><span class="smallrating'.$skill_level.'">'.$skill_level.' star</span></div>
							  <div class="gg-skills-vid-meta"><p>'.$title.'</p></div>
			                <a href="#" onclick="loadVideo(\''.$uid.'\'); return false;" title="'.$title.'">';
							if ($thumb) {
							  $vid_thumbs .= '<img src="uploads/tx_ggskills/'.$thumb.'"  width="174" height="100" alt="'.$title.'" />';
							} else {
							  $vid_thumbs .= '<img src="fileadmin/ts-templates/img/placeholder.png"  width="174" height="100" alt="'.$title.'" />';
							}
			$vid_thumbs .= '</a>
						  </div>';
			if (($i % 4) == 0) {
				$vid_thumbs .= '<div class="clearer"></div></li><li>';
			}
			$i++;
		}
		$vid_thumbs .= '<div class="clearer"></div></li>';
	
		$content = '
		<div id="gg-skills-bg">
		  <h1>Skills</h1>
		  
		  <!-- gg-skills-video-panel -->
		  <div id="gg-skills-video-panel">
		    <p id="gg-skills-pick">Choose a Star rating from the menu on the left, then click a thumbnail below to watch the video!</p>
		  </div>
		  <!-- /gg-skills-video-panel -->';
	
		$content .= '
		<!-- Gallery -->
		    <div id="gg-video-thumbs-container">
		      <ul>
			    '.$vid_thumbs.'
		      </ul>
		    </div>
		<!-- End Gallery -->';
		
		$content .= '</div>';

		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_skills/pi1/class.tx_ggskills_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_skills/pi1/class.tx_ggskills_pi1.php']);
}

?>