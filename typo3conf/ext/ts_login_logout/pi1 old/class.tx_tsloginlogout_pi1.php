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
 * Plugin 'TS Login Logout' for the 'ts_login_logout' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_tsloginlogout
 */
class tx_tsloginlogout_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_tsloginlogout_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_tsloginlogout_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'ts_login_logout';	// The extension key.
	var $pi_checkCHash = true;
	
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
		
	
		if ($GLOBALS['TSFE']->fe_user->user['ses_id']) {
			$logged_in = true;
		} else {
			$logged_in = false;
		}
	
		if (!$logged_in) {
			$content='
					<div id="ts-login-logout-wrapper">
					  <ul>
    	    			<li id="ts-login"><a href="team-stripes/login/">Login</a></li>
    	    			<li id="ts-join-today"><a href="team-stripes/join/">Joing Today</a></li>
    	    	  	  </ul>
    	    	  	  <div class="clearer"></div>
    	    	  	</div>';
    	} else {
        	$content = '
        			  <div id="ts-login-logout-wrapper">
        				<form action="team-stripes/login/" id="a68260b27561e45c5b84b527f006fc908" name="a68260b27561e45c5b84b527f006fc908" enctype="multipart/form-data" method="POST" target="_self">
							<div style="display:none;">
								<input type="hidden" name="logintype" value="logout" />
								<input type="hidden" name="pid" value="29" />
							</div>
							<input type="image" src="/fileadmin/ts-templates/img/logout.png" name="submit" value="Logout" class="submit" />
						</form>
				      </div>';
        }
	
		return $content;
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ts_login_logout/pi1/class.tx_tsloginlogout_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ts_login_logout/pi1/class.tx_tsloginlogout_pi1.php']);
}

?>