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
 * Plugin 'TS Main Wall' for the 'ts_wall' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_tswall
 */
class tx_tswall_pi2 extends tslib_pibase {
	var $prefixId      = 'tx_tswall_pi2';		// Same as class name
	var $scriptRelPath = 'pi2/class.tx_tswall_pi2.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'ts_wall';	// The extension key.
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
		
		$GLOBALS['TSFE']->additionalHeaderData['script.jqueryform'] = '<script type="text/javascript" src="/fileadmin/templates/js/jquery.form.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData['script.fanzonemessages'] = '<script type="text/javascript" src="/fileadmin/ts-templates/scr/ts-wall-messages.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData['css.wall'] = '<link rel="stylesheet" href="/fileadmin/ts-templates/css/ts-wall.css" type="text/css" media="screen" />';

		if ($GLOBALS['TSFE']->fe_user->user['ses_id']) {
			$logged_in = true;
			$user_uid = $GLOBALS['TSFE']->fe_user->user['uid'];
		} else {
			$logged_in = false;
		}
		
		$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM  tx_tswall_posts WHERE deleted != 1 AND hidden != 1 AND response_to = "" ORDER BY uid DESC');
		
		if (mysql_num_rows($res) > 0) {
			$messages = '';
			$i = 1;
			while ($row = mysql_fetch_assoc($res)) {
				#print_r($row);
				// Get user info
				$user_res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM fe_users WHERE uid = '.$row['user_uid']);
				$user_row = mysql_fetch_assoc($user_res);
				#print_r($user_row);
				// Name
				$user_name = $user_row['name'];
				// UID
				$uid = $row['uid']; 
				// Message
				$message = $row['message'];
				// Interval
				$granularity = 1;
				$interval = $this->getInterval($row['tstamp'], $granularity );
				
				// Check is message has any comments
				$comments_res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM  tx_tswall_posts WHERE deleted != 1 AND hidden != 1 AND response_to = '.$uid.' ORDER BY uid DESC');
				if (mysql_num_rows($comments_res) > 0) {
					$comments = '';
					while ($comments_row = mysql_fetch_assoc($comments_res)) {
						// Get info
						$comments_user_res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM fe_users WHERE uid = '.$comments_row['user_uid']);
						$comments_user_row = mysql_fetch_assoc($comments_user_res);
						// Name
						$comments_user_name = $comments_user_row['name'];
						// Get comment
						$comment = $comments_row['message'];
						// Get comment UID
						$comment_uid = $comments_row['uid'];
						// Interval
						$granularity = 1;
						$comment_interval = $this->getInterval($comments_row['tstamp'], $granularity );
						$comments .= '
						<div class="ts-wall-comment">
						  <div class="ts-wall-comment-from">Comment from: '.$comments_user_name.'</div>
						  <p>'.$comment.'</p>
						  <p class="message-time"><small class="blue">Comment posted '.$comment_interval.' ago</small></p>
						  <p class="tools">
						    <a href="#" onClick="report_message(\''.$comment_uid.';\'); return false;" class="report">Report</a>
						    <div class="clearer"></div>
						  </p>
						</div>';
					}
				}

				
				// Build up messages
				$messages .= '
					  <div class="ts-wall-post">
					    <div class="ts-wall-post-left">
					      <h4>'.$user_name.' says...</h4>
					      <p>'.$message.'</p>
						</div>
						<div class="ts-post-by left">
						  <small class="blue">Posted '.$interval.' ago...</small>
						</div>
						<div class="ts-post-links right">
						  <a href="#" onClick="report_message(\''.$uid.';\'); return false;" class="button">Report</a>';

				if ($logged_in) {
					$messages .= '<a href="#" onClick="$(\'div#gg-message-small-comment-form-'.$uid.'\').slideToggle(); return false;" class="button">Comment</a>';
				}
				
				$messages .= '
					    </div>
						<div class="clearer"></div>
						
						<div id="gg-message-small-comment-form-'.$uid.'" class="gg-comment-form gg-message-form">
						  <form id="gg-message-comment-form-small-'.$uid.'" class="gg-message-comment-form-small" name="gg-message-comment-form-small" action="/typo3conf/ext/ts_wall/submit-comment-form.php" method="post">
							<p>Enter your message below...</p>
							<textarea name="gg-messages-comment-small-message" id="gg-messages-comment-small-message-'.$uid.'"></textarea>
							<input type="submit" value="Post" class="gg-message-form-send" />
							<div class="clearer"></div>
							<input type="hidden" name="gg-messages-small-response-to" id="gg-messages-small-response-to" value="'.$uid.'" />
							<input type="hidden" name="gg-messages-small-user-uid" id="gg-messages-small-user-uid" value="'.$user_uid.'" />
						  </form>
						</div>';
						
					    if ($comments) {
						  $messages .= '<div class="ts-wall-comments"><h4 class="white">Comments on this post:</h4>'.$comments.'</div>';
					    }
						
					  $messages .= '</div>';
				unset($comments);
			}
		}
		
		
		if ($logged_in) {
			$gg_message_form = '
				<div id="gg-message-form" class="gg-message-form">
				  <form id="gg-message-form-small" action="/typo3conf/ext/ts_wall/submit-form.php" method="post">
				    <h3>Post to The Wall</h3>
				  	<p>Enter your message below...</p>
				    <textarea name="gg-messages-comment-small-message" id="gg-messages-small-message"></textarea>
				    <input type="submit" value="Post" class="gg-message-form-send" />
				    <div class="clearer"></div>
				    
				    <input type="hidden" name="gg-messages-small-user-uid" id="gg-messages-small-user-uid" value="'.$user_uid.'" />
				    
				  </form>
				</div>';
		} else {
			$gg_message_form = '<p><a href="/gullys-gang/login/">Log In</a> or <a href="/gullys-gang/join/">Join The Gang</a> to post messages</p>';
		}
		

		$content='
				<div class="above">';
		if (!$logged_in) {
			$content .= '<a href="#" class="button">Login</a>';
		}
		$content .= '
				  <h2>Team Stripes <span class="white">Wall</span></h2>
				  '.$messages.'
				</div>

			    <div class="clearer"></div>

				<div id="gg-message-bottom-panel">
				'.$gg_message_form.'
				</div>';
	
		return $this->pi_wrapInBaseClass($content);
	}
	
	/**
     * Format an interval value with the requested granularity.
     *
     * @param integer $timestamp The length of the interval in seconds.
     * @param integer $granularity How many different units to display in the string.
     * @return string A string representation of the interval.
     */
    public function getInterval($timestamp, $granularity = 2)
    {
        $seconds = time() - $timestamp;
        $units = array(
            '1 year|:count years' => 31536000,
            '1 week|:count weeks' => 604800,
            '1 day|:count days' => 86400,
            '1 hour|:count hours' => 3600,
            '1 min|:count minutes' => 60,
            '1 sec|:count seconds' => 1);
        $output = '';
        foreach ($units as $key => $value) {
            $key = explode('|', $key);
            if ($seconds >= $value) {
                $count = floor($seconds / $value);
                $output .= ($output ? ' ' : '');
                if ($count == 1) {
                    $output .= $key[0];
                } else {
                    $output .= str_replace(':count', $count, $key[1]);
                }
                $seconds %= $value;
                $granularity--;
            }
            if ($granularity == 0) {
                break;
            }
        }

        return $output ? $output : '0 sec';
    }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ts_wall/pi2/class.tx_tswall_pi2.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ts_wall/pi2/class.tx_tswall_pi2.php']);
}

?>