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
 * Plugin 'TS The Score Gallery' for the 'ts_the_score' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_tsthescore
 */
class tx_tsthescore_pi2 extends tslib_pibase {
	var $prefixId      = 'tx_tsthescore_pi2';		// Same as class name
	var $scriptRelPath = 'pi2/class.tx_tsthescore_pi2.php';	// Path to this script relative to the extension dir.
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
			$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT uid,opposition,datetime,brightongoals,oppositiongoals,report,media,venue,homeaway FROM tx_ggthescore_match WHERE uid = '.$uid);
		} else {
			$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT media FROM tx_ggthescore_match WHERE datetime < '.$now.' AND deleted != 1 ORDER BY datetime DESC LIMIT 1');
		}
		
		if (mysql_num_rows($res) > 0) {
			while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
				$media = $row['media'];
			}
		
			if ($media) {
				$media = explode(',', $media);
				$number_media = count($media);
				$media_list = '';
				for($i = 0; $i < $number_media; $i++) {
	
				$media_list .= '<li>
			                        <a class="thumb" name="'.$media[$i].'" href="/typo3conf/thumb.php?src=uploads/tx_ggthescore/'.$media[$i].'&w=364&h=294&zc=1" title="'.$media[$i].'">
			                            <img src="/typo3conf/thumb.php?src=uploads/tx_ggthescore/'.$media[$i].'&w=65&h=49&zc=1" alt="'.$media[$i].'" />
			                        </a>
			                    </li>';


				}
		
				$content = '
						<!-- Start Advanced Gallery Html Containers -->				
		                <div class="slideshow-container carbonbox h2" style="margin-bottom: 20px;">
						  
						  <h2>Match <span class="white">Gallery</span></h2>
						  
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
		                </div> <!-- /#slideshow-container -->
						<!-- End Gallery Html Containers -->
				';
			} else {
				$content = '
						<!-- Start Advanced Gallery Html Containers -->				
		                <div class="slideshow-container carbonbox h2" style="margin-bottom: 10px;">
						  
						  <h2>Match <span class="white">Gallery</span></h2>
						  <p class="intro">Gallery Coming Soon</p>
						</div>
				';
			}
		}
		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ts_the_score/pi2/class.tx_tsthescore_pi2.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ts_the_score/pi2/class.tx_tsthescore_pi2.php']);
}

?>