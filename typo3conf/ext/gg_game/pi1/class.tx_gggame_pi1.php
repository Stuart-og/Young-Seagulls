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
 * Plugin 'GG Game' for the 'gg_game' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_gggame
 */
class tx_gggame_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_gggame_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_gggame_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gg_game';	// The extension key.
	
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
		session_start();
		
		$player_name = $GLOBALS['TSFE']->fe_user->user['name'];

		$_SESSION['player_name'] = $player_name;
		
		if ($GLOBALS['TSFE']->fe_user->user['ses_id']) {
			$logged_in = true;
		} else {
			$logged_in = false;
		}
	
	
	
		if ($logged_in) {
			$GLOBALS['TSFE']->additionalHeaderData['script.skills'] = '<script type="text/javascript" src="fileadmin/templates/js/game.js"></script>';
			//$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tx_gggame_scores WHERE deleted != 1 ORDER BY score DESC');
			$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tx_gggame_scores WHERE deleted != 1 ORDER BY score DESC');

			if (mysql_num_rows($res) > 0) {
				$high_scorers = '';
				$scores = '';
				$i = 0;
				while ($row = mysql_fetch_assoc($res)) {
					if ($i < 7) {
						$name = $row['username'];
						$name = trim($name);
						$firstname = explode(" ", $name);
						$name = $firstname[0];
						$high_scorers .= 'name'.($i+1).'='.$name.'&';
						$scores .= 'score'.($i+1).'='.$row['score'].'&';
						$i++;
					}
				}
			} else { // No scores yet
				$high_scorers = '';
				$scored = '';
			}
			
			//print_r($high_scorers.$scores);
			//die();
		
			$content='
			<iframe name="scores" style="display:none;"></iframe>
			<div class="gg-game-wrapper">
			<script language="JavaScript" type="text/javascript">
				AC_FL_RunContent(
					\'codebase\', \'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0\',
					\'width\', \'960\',
					\'height\', \'690\',
					\'src\', \'/fileadmin/templates/swf/gully_game\',
					\'quality\', \'high\',
					\'pluginspage\', \'http://www.adobe.com/go/getflashplayer\',
					\'align\', \'middle\',
					\'play\', \'true\',
					\'loop\', \'true\',
					\'scale\', \'showall\',
					\'wmode\', \'transparent\',
					\'devicefont\', \'false\',
					\'id\', \'gully_game\',
					\'bgcolor\', \'#ffffff\',
					\'name\', \'gully_game\',
					\'menu\', \'true\',
					\'allowFullScreen\', \'false\',
					\'allowScriptAccess\',\'sameDomain\',
					\'base\',\'/fileadmin/templates/swf/\',
					\'movie\', \'/fileadmin/templates/swf/gully_game\',
					\'salign\', \'\',
					\'flashvars\', \''.$high_scorers.$scores.'\'
					); //end AC code
			</script>
			<noscript>
				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="960" height="690" id="gully_game" align="middle">
				  <param name="allowScriptAccess" value="sameDomain" />
				  <param name="allowFullScreen" value="false" />
				  <param name="movie" value="/fileadmin/templates/swf/gully_game.swf" />
				  <param name="quality" value="high" />
				  <param name="bgcolor" value="#ffffff" />
				  <embed src="/fileadmin/templates/swf/gully_game.swf" quality="high" bgcolor="#ffffff" width="960" height="690" name="gully_game" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer" />
				</object>
			</noscript>
			</div>';
	} else {
		$content = '<div id="gg-content-wrapper">
					  <div id="gg-content-top"></div>
					  <div id="gg-content-middle">
					    <img src="/fileadmin/templates/img/gameon/game-login.jpg" id="gg-game-holding" />
					  </div>
					<div id="gg-content-bottom"></div>';
	}



		return $content;
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_game/pi1/class.tx_gggame_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_game/pi1/class.tx_gggame_pi1.php']);
}

?>