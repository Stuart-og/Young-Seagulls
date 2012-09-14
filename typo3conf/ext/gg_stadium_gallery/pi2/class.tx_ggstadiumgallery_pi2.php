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
 * Plugin 'GG Stadium Gallery' for the 'gg_stadium_gallery' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggstadiumgallery
 */
class tx_ggstadiumgallery_pi2 extends tslib_pibase {
	var $prefixId      = 'tx_ggstadiumgallery_pi2';		// Same as class name
	var $scriptRelPath = 'pi2/class.tx_ggstadiumgallery_pi2.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gg_stadium_gallery';	// The extension key.
	
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
	
		$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tx_ggstadiumgallery_pictures WHERE deleted !=1 ORDER BY uid DESC');
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

		$content = '
			<div id="gg-stadium-gallery-container">
				<!-- Start Advanced Gallery Html Containers -->				
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
				
				
				<div class="navigation-container">
					<div id="thumbs" class="navigation">
						<a class="pageLink prev" style="visibility: hidden;" href="#" title="Previous Page"></a>
						<ul class="thumbs noscript">
						'.$media_list.'
						</ul>
						<a class="pageLink next" style="visibility: hidden;" href="#" title="Next Page"></a>
					</div>
				</div>
				<!-- End Gallery Html Containers -->
				
				<div class="bottom-panel-bg">
					<div class="bottom-panel">
						<p>Update: 27/1/2010</p><a class="button" href="gullys-gang/stadium/gallery/">See More</a>
					</div>
				</div>

			</div>
			<div class="clearer"></div>';

/*			
$content = '
<div id="gg-stadium-gallery-container">
<div id="gg-stadium-gallery-big-img"><img width="367" height="295" alt="Placeholder" src="fileadmin/templates/img/global/placeholder.png"></div>
<div class="content">
<h2 class="imgtitle">Image Title</h2>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque tempus, orci quis commodo placerat, tellus enim iaculis ante, vitae tincidunt justo lacus in purus. Aenean ornare massa justo. Nullam quis turpis dui, quis varius elit. Proin tincidunt est in nisl laoreet interdum.</p>
</div>
<!-- gg-drawing-img -->
<!-- /gg-drawing-img -->

<!-- gg-stadium-gallery-thumbs -->
<div id="gg-stadium-gallery-thumbs">
<a class="leftarrow" href="#">Left</a>
<a href="#"><img width="65" height="49" alt="Placeholder" src="fileadmin/templates/img/global/placeholder.png"></a>
<a href="#"><img width="65" height="49" alt="Placeholder" src="fileadmin/templates/img/global/placeholder.png"></a>
<a href="#"><img width="65" height="49" alt="Placeholder" src="fileadmin/templates/img/global/placeholder.png"></a>
<a href="#"><img width="65" height="49" alt="Placeholder" src="fileadmin/templates/img/global/placeholder.png"></a>
<a class="rightarrow" href="#">Right</a>            </div>
<!-- /gg-stadium-gallery-thumbs -->      
<div class="bottom-panel-bg">
<div class="bottom-panel">
<p class="football">Update: 27/1/2010</p></div>
</div>
</div>';*/
			
		return $content;
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_stadium_gallery/pi2/class.tx_ggstadiumgallery_pi2.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_stadium_gallery/pi2/class.tx_ggstadiumgallery_pi2.php']);
}

?>