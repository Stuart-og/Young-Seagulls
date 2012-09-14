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
 * Plugin 'GG Login Logout' for the 'gg_login_logout' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggloginlogout
 */
class tx_ggloginlogout_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_ggloginlogout_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_ggloginlogout_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gg_login_logout';	// The extension key.
	
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
		
		if ($GLOBALS['TSFE']->fe_user->user['ses_id']) {
			$logged_in = true;
		} else {
			$logged_in = false;
		}
	
		if (!$logged_in) {
			$content='<ul>
						<!--<li id="gg-re-register"><a href="http://www.youngseagulls.co.uk/Re-register/re-register.php">re-register</a></li>-->
	        			<li id="gg-join-gang"><a href="http://www.youngseagulls.co.uk/gullys-gang/join">Joing the Gang</a></li>
    	    			<li id="gg-login"><a href="gullys-gang/login/">Login</a></li>
    	    			<li id="gg-team-stripes"><a href="http://www.youngseagulls.co.uk/team-stripes">Team Stripes</a></li>
    	    			<li id="gg-login-top-end">&nbsp;</li>
    	    	  	  </ul>
    	    	  	  <div class="clearer"></div>';
    	} else {
        	$content = '<div id="edit-logout"><div id="edit-dets"><a href="user/edit-details.php"><img src="/fileadmin/templates/img/global/edit.png" /></a></div><form action="gullys-gang/login/" id="a68260b27561e45c5b84b527f006fc908" name="a68260b27561e45c5b84b527f006fc908" enctype="multipart/form-data" method="POST" target="_self">
							<div style="display:none;">
								<input type="hidden" name="logintype" value="logout" />
								<input type="hidden" name="pid" value="28" />
							</div>
							<a id="edit-dets-btn" href="http://www.youngseagulls.co.uk/user/login.php">Edit Details</a>
							<input type="image" src="/fileadmin/templates/img/logout.png" name="submit" value="Logout" class="submit" />
						</form></div>';
        }
	
		return $content;
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_login_logout/pi1/class.tx_ggloginlogout_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_login_logout/pi1/class.tx_ggloginlogout_pi1.php']);
}

?>