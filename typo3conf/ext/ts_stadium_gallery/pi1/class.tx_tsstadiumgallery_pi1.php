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
 * Plugin 'TS Stadium Gallery' for the 'ts_stadium_gallery' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_tsstadiumgallery
 */
class tx_tsstadiumgallery_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_tsstadiumgallery_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_tsstadiumgallery_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'ts_stadium_gallery';	// The extension key.
	
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
	
		$GLOBALS['TSFE']->additionalHeaderData['script.ts-stadium'] = '<script type="text/javascript" src="typo3conf/ext/ts_stadium_gallery/ts-stadium.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData['script.history'] = '<script type="text/javascript" src="fileadmin/ts-templates/scr/jquery.history.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData['script.galleriffic'] = '<script type="text/javascript" src="fileadmin/ts-templates/scr/jquery.galleriffic.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData['script.opacity'] = '<script type="text/javascript" src="fileadmin/ts-templates/scr/jquery.opacityrollover.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData['script.noscript'] = '<!-- We only want the thunbnails to display when javascript is disabled -->
																	 <script type="text/javascript">
															   			document.write(\'<style>.noscript { display: none; }</style>\');
															 		 </script>';
		$GLOBALS['TSFE']->additionalHeaderData['css.gallery'] = '<link rel="stylesheet" href="fileadmin/ts-templates/css/ts-gallery.css" type="text/css" media="screen" />';


/*
		$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tx_tsaboutgallery_images WHERE 1');
		
		while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			$media = $row['files'];
		}
		
		$media = explode(',', $media);
		$number_media = count($media);
		$media_list = '';
		for($i = 0; $i < $number_media; $i++) {
			$media_list  .= '
				<li>
					<a class="thumb" name="'.$media[$i].'" href="uploads/tx_tsaboutgallery/'.$media[$i].'" title="'.$media[$i].'">
						<img src="uploads/tx_tsaboutgallery/'.$media[$i].'" alt="'.$media[$i].'" width="65" height="49" />
					</a>
				</li>';
		}
*/


		$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tx_ggstadiumgallery_pictures WHERE deleted != 1 AND hidden != 1 ORDER BY uid DESC');
		while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			$id = $row['uid'];
			$picture = $row['pictures'];
			$name = $row['name'];
			$desc = $row['description'];
			
			$media_list .= '
					<li>
					  <a class="thumb" name="'.$name.'" href="uploads/tx_ggstadiumgallery/'.$picture.'" title="'.$name.'">
						<img width="65" height="49" alt="Placeholder" src="uploads/tx_ggstadiumgallery/'.$picture.'" alt="'.$name.'" />
					  </a>
					  <div class="caption">
						<div class="image-title">'.$name.'</div>
						<div class="image-desc">'.$desc.'</div>
					  </div>
					</li>';
		}


		$content='
		<!-- Start Advanced Gallery Html Containers -->
		<div class="slideshow-container carbonbox h25" style="margin-bottom: 20px;">

			<h2>Team Stripes <span class="white">Gallery</span></h2>

			<div id="controls" class="controls"></div>
			<div id="loading" class="loader"></div>
			<div id="slideshow" class="slideshow"></div>
		   
			<div id="thumbs" class="navigation">
				<a class="pageLink prev" style="visibility: hidden;" href="#" title="Previous Page"></a>
			
				<ul class="thumbs noscript">
					'.$media_list.'
				</ul>

				<a class="pageLink next" style="visibility: hidden;" href="#" title="Next Page"></a>
			</div> <!-- /#thumbs -->

			<!--<img width="79" height="124" style="top: 2px; right: -12px;" class="topright imgalpha" alt="Gully" src="fileadmin/ts-templates/img/stadium/Stadium_gully.png">-->
			
		</div> <!-- /#slideshow-container -->
		<!-- End Gallery Html Containers -->';	
	
		return $content;
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ts_stadium_gallery/pi1/class.tx_tsstadiumgallery_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ts_stadium_gallery/pi1/class.tx_tsstadiumgallery_pi1.php']);
}

?>