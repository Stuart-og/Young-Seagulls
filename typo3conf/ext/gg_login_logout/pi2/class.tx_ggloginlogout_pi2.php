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
 * Plugin 'GG Login Logut Footer' for the 'gg_login_logout' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggloginlogout
 */
class tx_ggloginlogout_pi2 extends tslib_pibase {
	var $prefixId      = 'tx_ggloginlogout_pi2';		// Same as class name
	var $scriptRelPath = 'pi2/class.tx_ggloginlogout_pi2.php';	// Path to this script relative to the extension dir.
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
			$content='<li id="gg-join-gang"><a href="gullys-gang/join/">Joing the Gang</a></li>
        			  <li id="gg-login"><a href="gullys-gang/login/">Login</a></li>
        			  
           <script type="text/javascript">

        	 $(document).ready( function(){
        	   
        	   temp = " ' . $GLOBALS['TSFE']->fe_user->user['ses_id'] .  ' ";
        	   
        	   var form = document.createElement("form");
        	   form.setAttribute("name", "a5e4ad5528acfa84b3b8594199c05d61a");
        	   form.setAttribute("enctype", "multipart/form-data");
        	   form.setAttribute("action", "gullys-gang/login/");
        	   form.setAttribute("method", "POST");

        	   var userLabel = document.createElement("label");
        	   userLabel.setAttribute("for", "user");
            
        	   var text = document.createTextNode("User Name");
        	   userLabel.appendChild(text);
            
        	   var userInput = document.createElement("input");
        	   userInput.setAttribute("id", "user");
        	   userInput.setAttribute("name", "user");
        	   userInput.setAttribute("type", "text");
        	   userInput.setAttribute("size", "30");
            
        	   var userDiv = document.createElement("div");
        	   userDiv.appendChild(userLabel);
        	   userDiv.appendChild(userInput);
                        
        	   var passLabel = document.createElement("label");
        	   passLabel.setAttribute("for", "pass");
            
        	   text = document.createTextNode("Password");
        	   passLabel.appendChild(text);
            
        	   var passInput = document.createElement("input");
        	   passInput.setAttribute("id", "pass");
        	   passInput.setAttribute("name", "pass");
        	   passInput.setAttribute("type", "password");
        	   passInput.setAttribute("size", "30");
            
        	   var passDiv = document.createElement("div");
        	   passDiv.appendChild(passLabel);
        	   passDiv.appendChild(passInput);
            
        	   var loginTypeInput = document.createElement("input");
        	   loginTypeInput.setAttribute("type", "hidden");
        	   loginTypeInput.setAttribute("name", "logintype");
        	   loginTypeInput.setAttribute("value", "login");
            
        	   var pidInput = document.createElement("input");
        	   pidInput.setAttribute("type", "hidden");
        	   pidInput.setAttribute("name", "pid");
        	   pidInput.setAttribute("value", "28");
            
        	   var submit = document.createElement("input");
        	   submit.setAttribute("type", "submit");
        	   submit.setAttribute("value", "Login");
        	   submit.setAttribute("name", "submit");
        	   
        	   var heading = document.createElement("h2");
        	   heading.setAttribute("id", "overlay-heading");
        	   var headingText = document.createTextNode("Please Log In");
        	   heading.appendChild(headingText);
        	           	   
        	   var paragraphOne = document.createElement("p");  	   
        	   var paragraphText = document.createTextNode("You must be logged in to view any content this site");
        	   paragraphOne.appendChild(paragraphText);
        	   
        	   var paragraphTwo = document.createElement("p");

        	   paragraphText = document.createTextNode("please click ");
        	   paragraphTwo.appendChild(paragraphText);
        	   
        	   var link = document.createElement("a");
        	   link.setAttribute("href", "http://www.youngseagulls.co.uk/user/register.php");
        	   var linkText = document.createTextNode("here");
        	   
        	   link.appendChild(linkText);
        	   paragraphTwo.appendChild(link);
        	   
        	   paragraphText = document.createTextNode(" to register");
        	   paragraphTwo.appendChild(paragraphText);

        	   form.appendChild(heading);
        	   form.appendChild(paragraphOne);    
        	   form.appendChild(userDiv);
        	   form.appendChild(passDiv);
        	   form.appendChild(loginTypeInput);
        	   form.appendChild(pidInput);
        	   form.appendChild(submit);
        	   form.appendChild(paragraphTwo);
        	   
        	   var overlay = document.createElement("div");
        	   overlay.setAttribute("id", "login-overlay");

        	   overlay.appendChild(form);
            
        	   var div = document.getElementById("gg-top-login");
        	   div.appendChild(overlay);

          });

        	</script>
        			  
        			  ';       			 
        			  
        } else {        
        	$content = '<form action="gullys-gang/login/" id="a68260b27561e45c5b84b527f006fc908" name="a68260b27561e45c5b84b527f006fc908" enctype="multipart/form-data" method="POST" target="_self">
							<div style="display:none;">
								<input type="hidden" name="logintype" value="logout" />
								<input type="hidden" name="pid" value="28" />
							</div>
							<input type="image" src="/fileadmin/templates/img/logout.png" name="submit" value="Logout" class="submit" />
						</form>';
        }
	
		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_login_logout/pi2/class.tx_ggloginlogout_pi2.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_login_logout/pi2/class.tx_ggloginlogout_pi2.php']);
}

?>