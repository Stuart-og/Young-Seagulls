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
 * Plugin 'GG Fanzone Photos' for the 'gg_fanzone_photos' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggfanzonephotos
 */
class tx_ggfanzonephotos_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_ggfanzonephotos_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_ggfanzonephotos_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gg_fanzone_photos';	// The extension key.
	
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
	
		$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tx_ggfanzonephotos_photos WHERE deleted != 1 ORDER BY uid DESC');

		$GLOBALS['TSFE']->additionalHeaderData['script.jqueryHistory'] = '<script type="text/javascript" src="fileadmin/templates/scr/jquery.history.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData['script.jqueryGalleriffic'] = '<script type="text/javascript" src="fileadmin/templates/scr/jquery.galleriffic.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData['script.jqueryOpacity'] = '<script type="text/javascript" src="fileadmin/templates/scr/jquery.opacityrollover.js"></script>';

		$GLOBALS['TSFE']->additionalHeaderData['script.fanzone'] = '<script type="text/javascript" src="fileadmin/templates/js/fanzone.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData['script.fanzoneInLine'] = '<script type="text/javascript"> document.write(\'<style>.noscript { display: none; }</style>\'); </script>';
		

		if (mysql_num_rows($res) > 0) {
			$thumbs = '';
			$i = 1;
			while ($row = mysql_fetch_assoc($res)) {
				#print_r($row);
				$image = '/uploads/tx_ggfanzonephotos/'.$row['image'];
				$caption = $row['caption'];
				
				$thumbs .= '
				<li>
					<a class="thumb" name="leaf" href="'.$image.'" title="'.$caption.'">
						<img src="/typo3conf/thumb.php?src='.$image.'&w=65&h=49&zc=1" alt="'.$caption.'" title="'.$caption.'" />
					</a>
					<div class="caption">
						<h3>Submitted by: <span>'.$caption.'</span></h3>
					</div>
				</li>';
				$i ++;
			}
		}
	
		$content='
		<div id="gg-drawings">
			<div id="gg-drawings-top"><h2 class="spacer">Send us <strong>your own brilliant</strong> pictures!</h2></div>
			<!-- gg-drawings-container -->
			<div id="gg-drawings-container">
				<!-- Gallery -->
				<div id="caption"></div>
				<div class="carbonbox h4 slideshow-container">
					<!-- Start Advanced Gallery Html Containers -->				
					<div class="controls" id="controls"></div>
					<div class="loader" id="loading"></div>
					<div class="slideshow" id="slideshow"></div>
					
					<div id="gg-team-info-stats">    
						<div class="navigation" id="thumbs">
							<a title="Previous Page" href="#" style="visibility: hidden; opacity: 0.67;" class="pageLink prev"></a>
							<ul class="thumbs noscript">
							  '.$thumbs.'
							</ul>
							<a title="Next Page" href="#" style="visibility: hidden; opacity: 0.67;" class="pageLink next"></a>
						<div>
						
						<div>
					</div>
				</div>
			</div> <!-- /#thumbs -->
			</div>
				<!-- End Gallery Html Containers -->
			</div>
			<!-- End Gallery -->
			</div><!-- /gg-drawings-container -->
		</div>';

	
		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_fanzone_photos/pi1/class.tx_ggfanzonephotos_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_fanzone_photos/pi1/class.tx_ggfanzonephotos_pi1.php']);
}

?>