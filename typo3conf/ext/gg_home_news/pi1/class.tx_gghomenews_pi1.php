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
 * Plugin 'GG Home News' for the 'gg_home_news' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_gghomenews
 */
class tx_gghomenews_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_gghomenews_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_gghomenews_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gg_home_news';	// The extension key.
	
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

	
		$page_id = $GLOBALS['TSFE']->id;
		//print_r($page_id);
		switch($page_id) {
			case 3: // Home page
			
			
			
				$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tt_news WHERE deleted != 1 AND hidden != 1 ORDER BY uid ASC');
				while ($row = mysql_fetch_assoc($res)) {
					//print_r($row);
					$cat_res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tt_news_cat_mm WHERE uid_local = '.$row['uid']);
					while ($cat_row = mysql_fetch_assoc($cat_res)) {
						//print_r($cat_row);
						if ($cat_row['uid_foreign'] == 3) {
							$uid = $cat_row['uid_local'];
							break;
						}
					}
				}
				$more_link = 'gullys-gang/news/';
			break;
			
			case 61: // Stadium hub page
				$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tt_news WHERE deleted != 1 AND hidden != 1 ORDER BY uid DESC');
				while ($row = mysql_fetch_assoc($res)) {
					//print_r($row);
					$cat_res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tt_news_cat_mm WHERE uid_local = '.$row['uid']);
					while ($cat_row = mysql_fetch_assoc($cat_res)) {
						//print_r($cat_row);
						if ($cat_row['uid_foreign'] == 4) {
							$uid = $cat_row['uid_local'];
							break;
						}
					}
				}
				$more_link = 'gullys-gang/stadium/stadium-news/';
			break;

			default: // Home page
				$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tt_news WHERE deleted != 1 AND hidden != 1 ORDER BY uid DESC LIMIT 1');
				$more_link = 'gullys-gang/stadium/stadium-news/';
			break;
		}
		
function getPost($uid){	

$more_link = '/gullys-gang/news';

		if ($uid) {
			#print_r('1');
			$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tt_news WHERE deleted != 1 AND hidden != 1 AND uid = '.$uid.' ORDER BY crdate DESC LIMIT 1');
		} else {
			#print_r('1');
			$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tt_news WHERE deleted != 1 AND hidden != 1 ORDER BY crdate DESC LIMIT 1');
		}
				
				
		while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			
		    // News title
			$title = $row['title'];
			// News image
			if ($row['image']) {
				$image = 'uploads/pics/'.$row['image'].'';
			} else {
				$image = 'fileadmin/templates/img/home/news-placeholder.jpg';
			}
			// Date
			$date = date('d/m/Y', $row['datetime']); 
			// Content
			$content = $row['bodytext'];
			$content = explode(' ', $content);
			$newsContent = '';
			for ($i = 0; $i <= 12; $i++) {
				$newsContent .= $content[$i]." ";
			}
		}
	
		/*$content='
		<div id="gg-news-panel">
		  <div id="gg-news-panel-top">
		    <h2 class="spacer">The Latest news<br/> from <strong>Gully\'s Gang</strong></h2>
	      </div>
		  
		  <div class="content">
		    <div class="right" style="width: 209px; height: 143px; border: 1px solid #7cdbff; background: url('.$image.') top;"></div>
		    <h3><a href="gullys-gang/news/">'.$title.'</a></h3>
		    <p>'.$newsContent.'...</p>
		  </div>
		  
		  <div class="bottom-panel-bg">
		    <div class="bottom-panel">
		      <p>Posted: <strong>'.$date.'</strong></p>
			  <a class="button" href="'.$more_link.'">Read more</a>
		    </div>
		  </div>
		</div>';*/
		
		$content='
		<div id="gg-news-panel">
		  <div id="gg-news-panel-top">
		    <h2 class="spacer">The Latest news<br/> from <strong>Gully\'s Gang</strong></h2>
	      </div>
		  
		  <div class="content">
		    <div class="right" style="width: 146px; height: 100px; border: 1px solid #7cdbff; background: url(/typo3conf/thumb.php?src='.$image.'&w=209&h=143&zc=1) top;"></div>		   
		    <h3><a href="'.$more_link.'">'.$title.'</a></h3>
		    <p>'.$newsContent.'...</p>
		  </div>
		  
		  <div class="bottom-panel-bg">
		    <div class="bottom-panel">
		      <p>Posted: <strong>'.$date.'</strong></p>
			  <a class="button" href="'.$more_link.'">Read more</a>
		    </div>
		  </div>
		</div>
		'		
		;
		
		return $content;
		
}

function getPost2($uid){

$more_link = '/gullys-gang/news';	

		if ($uid) {
			#print_r('1');
			$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tt_news WHERE deleted != 1 AND hidden != 1 AND uid = '.$uid.' ORDER BY crdate DESC LIMIT 1');
		} else {
			#print_r('1');
			$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tt_news WHERE deleted != 1 AND hidden != 1 ORDER BY crdate DESC LIMIT 1');
		}
				
				
		while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			
		    // News title
			$title = $row['title'];
			// News image
			if ($row['image']) {
				$image = 'uploads/pics/'.$row['image'].'';
			} else {
				$image = 'fileadmin/templates/img/home/news-placeholder.jpg';
			}
			// Date
			$date = date('d/m/Y', $row['datetime']); 
			// Content
			$content = $row['bodytext'];
			$content = explode(' ', $content);
			$newsContent = '';
			for ($i = 0; $i <= 12; $i++) {
				$newsContent .= $content[$i]." ";
			}
		}
			
		$content='
		<div class="gg-news-panel">
		 
		 <div class="block"> </div>
		  
		  <div class="content">
		    <div class="right" style="width: 146px; height: 100px; border: 1px solid #7cdbff; background: url(/typo3conf/thumb.php?src='.$image.'&w=209&h=143&zc=1) top;"></div>		   
		    <h3><a href="'.$more_link.'">'.$title.'</a></h3>
		    <p>'.$newsContent.'...</p>
		  </div>
		  
		  <div class="bottom-panel-bg">
		    <div class="bottom-panel">
		      <p>Posted: <strong>'.$date.'</strong></p>
			  <a class="button" href="'.$more_link.'">Read more</a>
		    </div>
		  </div>
		</div>
		'		
		;
		
		return $content;
		
}

$content = getPost($uid);
$content .= getPost2($uid - 1);
$content .= getPost2($uid - 2);
		
		//PATH_site.'/typo3conf/thumb.php'
	
		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_home_news/pi1/class.tx_gghomenews_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_home_news/pi1/class.tx_gghomenews_pi1.php']);
}

?>