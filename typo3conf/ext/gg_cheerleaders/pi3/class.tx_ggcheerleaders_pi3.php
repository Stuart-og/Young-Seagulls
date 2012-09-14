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
 * Plugin 'GG Cheerleaders Landing Gallery' for the 'gg_cheerleaders' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggcheerleaders
 */
class tx_ggcheerleaders_pi3 extends tslib_pibase {
	var $prefixId      = 'tx_ggcheerleaders_pi3';		// Same as class name
	var $scriptRelPath = 'pi3/class.tx_ggcheerleaders_pi3.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gg_cheerleaders';	// The extension key.
	
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
		
		$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tx_ggcheerleaders_gallery WHERE deleted != 1 ORDER BY uid DESC');
		while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			$id = $row['uid'];
			$picture = $row['image'];
			$name = $row['name'];
			$desc = $row['description'];
			
			$media_list .= '
					<li>
					  <a class="thumb" name="'.$name.'" href="/uploads/tx_ggcheerleaders/'.$picture.'" title="'.$name.'">
						<img width="65" height="49" alt="Placeholder" src="/uploads/tx_ggcheerleaders/'.$picture.'" alt="'.$name.'" />
					  </a>
					  <div class="caption">
						<div class="image-title">'.$name.'</div>
						<div class="image-desc">'.$desc.'</div>
					  </div>
					</li>';
		}

		$content = '<div id="gg-cheerleaders-gallery">
				      <div id="gg-cheerleaders-gallery-top"><h2 class="spacer">Check out <strong>Gully\'s Girls</strong><br />in action!</h2></div>
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
					
					  <!--
					  <div class="bottom-panel-bg">
						<div class="bottom-panel">
						  <p>Update: 27/1/2010</p><a class="button" href="gullys-gang/stadium/gallery/">See More</a>
						</div>
					  </div>
					  -->
					</div>
					<div class="clearer"></div>';

	
		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_cheerleaders/pi3/class.tx_ggcheerleaders_pi3.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_cheerleaders/pi3/class.tx_ggcheerleaders_pi3.php']);
}

?>