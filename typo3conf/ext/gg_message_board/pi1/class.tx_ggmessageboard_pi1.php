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

require_once(t3lib_extMgm::extPath('gg_photos').'/pi/class.tx_ggphotos_secureajaxplugin.php');


/**
 * Plugin 'GG Message Board' for the 'gg_message_board' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggmessageboard
 */
class tx_ggmessageboard_pi1 extends tx_ggphotos_secureajaxplugin {
	var $prefixId      = 'tx_ggmessageboard_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_ggmessageboard_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gg_message_board';	// The extension key.
	
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
	
		$content = $this->view('index');
		$GLOBALS['TSFE']->additionalHeaderData['jquery.gully'] = '<script type="text/javascript" src="/fileadmin/templates/js/jquery.common.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData['jquery.form'] = '<script type="text/javascript" src="/fileadmin/templates/js/jquery.form.js"></script>';
		
		return $this->pi_wrapInBaseClass($content);
	}

	function ajax_post(){
		$db = $GLOBALS['TYPO3_DB'];
		$user = $GLOBALS['TSFE']->fe_user->user;
		if ($user && $_POST) {
			$q = $db->exec_insertQuery("tx_ggmessageboard_message",array(
				"user_uid"=>$user['uid'],'message'=>$_POST['message'],
				'hidden'=>1,'pid'=>$this->getStoragePid(),
				'response_to'=>$_POST['response_to'],
				'crtime'=>time(),
			));
			/* THIS VERSION IS COMMENTED OUT AS IT REMOVES THE MODERATION 
			$q = $db->exec_insertQuery("tx_ggmessageboard_message",array(
				"user_uid"=>$user['uid'],'message'=>$_POST['message'],
				'hidden'=>0,'pid'=>$this->getStoragePid(),
				'response_to'=>$_POST['response_to'],
				'crtime'=>time(),
			));*/
			echo $this->ajaxWrap($this->view('post-confirmation'));
		} else {
			echo $this->ajaxWrap($this->view('error'));
		}
	}
	function ajax_hide(){
		echo $this->ajaxWrap('');
	}
	function ajax_reportconfirm(){
		echo $this->ajaxWrap($this->view('report-confirm',array('uid'=>$_REQUEST['uid'])));
	}
	function ajax_like(){
		$db = $GLOBALS['TYPO3_DB'];
		$user = $GLOBALS['TSFE']->fe_user->user;
		if(!$user){
			echo $this->ajaxWrap($this->view('like-login'));
			return;
		}
		$q = $db->sql_query("SELECT * FROM tx_ggmessageboard_message_liked_by_mm WHERE uid_local='".mysql_escape_string($_REQUEST['uid'])."' AND uid_foreign='$user[uid]'");
		if($db->sql_num_rows($q)) {
			echo $this->ajaxWrap($this->view('like-duplicate'));
			return;
		}

		$q = $db->exec_insertQuery("tx_ggmessageboard_message_liked_by_mm",array(
			"uid_local"=>$_REQUEST['uid'],
			"uid_foreign"=>$user['uid'],
		));
		$db->sql_query("UPDATE tx_ggmessageboard_message SET liked_by=liked_by+1 WHERE uid='".mysql_escape_string($_REQUEST['uid'])."'");
		echo $this->ajaxWrap($this->view('like-done'));
	}
	function ajax_report(){
		$db = $GLOBALS['TYPO3_DB'];
		$user = $GLOBALS['TSFE']->fe_user->user;
		$q = $db->exec_insertQuery("tx_ggmessageboard_message_reported_by_mm",array(
			"uid_local"=>$_REQUEST['uid'],
			"uid_foreign"=>$user['uid'],
		));
		$db->sql_query("UPDATE tx_ggmessageboard_message SET reported_by=reported_by+1 WHERE uid='".mysql_escape_string($_REQUEST['uid'])."'");
		require_once(t3lib_extMgm::extPath('se_registration').'/lib/phpmailer/class.phpmailer.php');
		$data = array(
			"uid"=>$_REQUEST['uid'],
			"user"=>$GLOBALS['TSFE']->fe_user->user,
		);
		$html = $this->view('report-html',$data);
		$text = $this->view('report-text',$data);
		if(!$text) $text = html_entity_decode(strip_tags($html));
		$mail = new phpmailer();
		$mail->From = "complaints@seagulls.co.uk";
		$mail->FromName="Gully's Gang Complaints";
		$mail->Subject = "Gully's Gang Comment Reported Abusive";
		if($html){
			$mail->IsHtml(true);
			$mail->Body=$html;
			$mail->AltBody=$text;
		} else {
			$mail->Body=$text;
		}
		$mail->AddAddress("danny@specialegg.com");
		$mail->AddBCC("db@brightenup.me");
		$mail->AddBCC("don@don-laptop");
		$mail->Send();

		echo $this->ajaxWrap($this->view('report-done',$data));
	}
	function getStoragePid(){
		return 68;
	}
	var $table = 'tx_ggmessageboard_message';
	function query($count,$extraWhere='( response_to=0 OR response_to IS NULL)'){
		$db = $GLOBALS['TYPO3_DB'];
		$table = $this->table;
		$db->sql_query($sql = "SELECT $table.*,u.name user_name FROM $table JOIN fe_users u ON $table.user_uid=u.uid WHERE $table.pid='".$this->getStoragePid()."' ".$this->cObj->enableFields("tx_ggmessageboard_message")." AND $extraWhere ORDER BY uid DESC LIMIT $count");
		return $db->sql_query($sql = "SELECT $table.*,u.name user_name FROM $table JOIN fe_users u ON $table.user_uid=u.uid WHERE $table.pid='".$this->getStoragePid()."' ".$this->cObj->enableFields("tx_ggmessageboard_message")." AND $extraWhere ORDER BY uid DESC LIMIT $count");
	}
	function fetch($count=3){
		if(!$this->q){
			$this->q = $this->query($count);
		}
		$r = $this->read($this->q);
		if(!$r) $this->q=false;
		return $this->current = $r;
	}

	function read($q){
		$db = $GLOBALS['TYPO3_DB'];

		$r = $db->sql_fetch_assoc($q);
		if(!$r) return false;

		return array('message'=>"<p>".str_replace("\n","</p><p>",htmlspecialchars($r['message']))."</p>",'user'=>$r['user_name'],'uid'=>$r['uid'],'at'=>$this->formatTime($r['crtime']),'r'=>$r,'liked'=>$r['liked_by']);
	}
	function formatTime($time){
		$diff = time()-$time;
		$measures = array(
			"second"=>60,
			"minute"=>60,
			"hour"=>24,
			"day"=>7,
			"week"=>52,
			"year"=>100,
			"century"=>10,
			"millenium"=>99999999999
		);
		foreach($measures as $name=>$count){
			if($diff<$count){
				return "$diff $name".($diff==1?'':'s')." ago";
			}
			$diff=floor($diff/$count);
		}
	}

	function query_responses($uid=false,$count=3){
		if(!$uid) $uid = $this->current['uid'];
		return $this->query($count,"response_to=$uid");
	}

}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_message_board/pi1/class.tx_ggmessageboard_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_message_board/pi1/class.tx_ggmessageboard_pi1.php']);
}

?>
