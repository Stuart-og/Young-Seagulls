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

require_once(dirname(__FILE__).'/../pi/class.tx_ggphotos_secureajaxplugin.php');


/**
 * Plugin 'GG Photos' for the 'gg_photos' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggphotos
 */
class tx_ggphotos_pi1 extends tx_ggphotos_secureajaxplugin {
	var $prefixId      = 'tx_ggphotos_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_ggphotos_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gg_photos';	// The extension key.
	
	var $convert = "convert";

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
		$baseUrl = t3lib_extMgm::siteRelPath('gg_photos').'/pi1/lib/jquery.jquploader';
		$GLOBALS['TSFE']->additionalHeaderData['jquery.nyroModal'] = '<script type="text/javascript" src="/fileadmin/templates/js/jquery.nyroModal-1.5.5.min.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData['js.swfobject'] = '<script type="text/javascript" src="'.$baseUrl.'/jquery.flash.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData['jquery.uploadify'] = '<script type="text/javascript" src="'.$baseUrl.'/jquery.jqUploader.js"></script>';
//		$GLOBALS['TSFE']->additionalHeaderData['css.uploadify'] = "<link rel='stylesheet' type='text/css' href='$baseUrl/style.css'/>";
		$GLOBALS['TSFE']->additionalHeaderData['css.nyroModal'] = '<link rel="stylesheet" type="text/css" href="/fileadmin/templates/css/nyroModal.css"/>';
		$GLOBALS['TSFE']->additionalHeaderData['script.autouploadify'] = "
<script type='text/javascript'>
$(function() {
	var doUploads = function(){
		$('input:file.uploadify').each(function(){
			var f = $(this);
			f.jqUploader({
				allowedExt: '*.jpg;*.png;*.gif;',
				allowedExtDescr: 'Image Files',
				background: '000',
				src: '$baseUrl/jqUploader.swf'
			});
		});
	};
	$('form').live('fileUploaded',function(){
		$('#nyroModalContent').html($(this).closest('form').find('div.confirm').html());	
	});
	doUploads();
	$('body').live('ajax',doUploads);
});
</script>";
	
		$content = $this->view('index');
	
		return $this->pi_wrapInBaseClass($content);
	}

	function getStoragePid(){
		return $this->findPageByTitle('GG Photos');
	}

	function getImageType(){
		return 0;
	}

	function importFile($tempFile,$targetFile){
		$dir = dirname($targetFile);
		$name = basename($targetFile);

		mkdir(str_replace('//','/',"$dir/originals"), 0755, true);
		move_uploaded_file($tempFile,"$dir/originals/$name");

		$this->generateThumb("$dir/originals/$name","$dir/thumbs/$name");
		$this->generateFull("$dir/originals/$name",$targetFile);
		$this->emailAdmin($name);
	}
	function generateFull($original,$processed){
		$this->shrinkImage($original,$processed,267,195,'fit');
	}
	function generateThumb($original,$thumb){
		$this->shrinkImage($original,$thumb,85,79,'crop');
	}
	function getType(){
		return "Photo";
	}
	function emailAdmin($fileName){
		require_once(t3lib_extMgm::extPath('se_registration').'/lib/phpmailer/class.phpmailer.php');
		$data = array(
			"file"=>$fileName,
			"user"=>$GLOBALS['TSFE']->fe_user->user,
		);
		$html = $this->view('html-email',$data);
		$text = $this->view('text-email',$data);
		if(!$text) $text = html_entity_decode(strip_tags($html));

		$mail = new phpmailer();
		$mail->From = "images@seagulls.co.uk";
		$mail->FromName="Gully's Gang Uploads";
		$mail->Subject = "Gully's Gang ".$this->getType()." Uploaded";
		if($html){
			$mail->IsHtml(true);
			$mail->Body=$html;
			$mail->AltBody=$text;
		} else {
			$mail->Body=$text;
		}
		$mail->AddAddress("danny@specialegg.com");
		$mail->AddBCC("db@brightenup.me");
		$mail->Send();
	}
	function shrinkImage($before,$after,$width,$height,$method='fit'){
		$fileName = escapeshellcmd($before);
		$newFile = escapeshellcmd($after);

		$ext = preg_replace("/^.*\./","",$after);

		$extraArgs = '';
		switch(strtolower($ext)){
		case 'jpg': case 'jpeg': case 'jpe':
			$extraArgs = ' -quality  60%';
			break;
		}

		mkdir(str_replace('//','/',dirname($after)), 0755, true);
		switch($method){
		case 'crop':
			passthru($cmd = "$this->convert -resize ".($width*2)."x -resize 'x".($height*2)."<' -resize 50% -gravity center -extent $width"."x$height $extraArgs \"$fileName\" \"$newFile\" 2>&1");
			break;
		case 'fit':
		default:
			passthru($cmd = "$this->convert -resize ".$width."x$height -gravity center -extent $width"."x$height $extraArgs \"$fileName\" \"$newFile\" 2>&1",$return);
		}
		error_log("Ran: $cmd ".($return?"Fail $return":"Succes"));
	}
	function getConfigDirs(){
		$dirs = parent::getConfigDirs();
		$extPath = t3lib_extMgm::extPath("gg_photos");
		$dir = $extPath.'/'.dirname($this->scriptRelPath);
		$dirs = array_merge(array(array_shift($dirs)),array($dir),$dirs);
		return $dirs;
	}
	function ajax_upload($params){
		if(file_exists($abs = "/sw/bin/convert")) $this->convert=$abs;
		$user = $GLOBALS['TSFE']->fe_user->user;
		if ($user && !empty($_FILES)) {
			$db = $GLOBALS['TYPO3_DB'];
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/gg_photos";
			$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
			$ext = strtolower(preg_replace("/^.*\./","",$targetFile));
			switch($ext){
			case 'gif':case 'jpg':case 'jpeg':case 'png':case 'jpe':
				$db->exec_INSERTquery("tx_ggphotos_uploads",array('user_uid'=>$user['uid'],'pid'=>$this->getStoragePid(),'hidden'=>1));
				$uid = $db->sql_insert_id();

				$targetFile = $uid."-".$_FILES['Filedata']['name'];
				$targetFile =  str_replace('//','/',$targetPath.'/') . $targetFile;
				$this->importFile($tempFile,$targetFile);
	
				$db->exec_UPDATEquery("tx_ggphotos_uploads","uid='$uid'",array('user_uid'=>$user['uid'],'file_name'=>basename($targetFile),'pid'=>$this->getStoragePid(),'type'=>$this->getImageType()));
				echo "1";
				return;
				break;
			}
		} else {
			if(!$user){
				header("HTTP/1.1 401 Access Denied");
				return;
			} 
		}
		header("HTTP/1.1 500 Internal Server Error");
	}

	function ajax_form($params){
		echo $this->ajaxWrap($this->view('upload-form'));
	}


	function getFeatured($featureName=false){
		$db = $GLOBALS['TYPO3_DB'];

		$pid = $this->getStoragePid();

		if($featureName) $extraWhere = " AND title='".mysql_escape_string($featureName)."'";
		$q = $db->sql_query($sql = "SELECT * FROM tx_ggphotos_featured WHERE pid='$pid' $extraWhere ".$this->cObj->enableFields("tx_ggphotos_featured")." ORDER BY uid DESC");
		$feat = $db->sql_fetch_assoc($q);
		if(!$feat['selection']) return false;

		foreach(explode(",",$feat['selection']) as $id){
			$r = $db->sql_fetch_assoc($db->sql_query($sql = "SELECT * FROM tx_ggphotos_uploads WHERE uid='$id'".$this->cObj->enableFields("tx_ggphotos_uploads").""));
			$feat['img'][] = $r['file_name'];
		}

		return $feat;
	}

	function fetch(){
		$details = $this->fetchDetails();
		return $details['file'];
	}
	function fetchDetails(){
		$db = $GLOBALS['TYPO3_DB'];

		if(!$this->q){
			$table = 'tx_ggphotos_uploads';
			$this->q = $db->sql_query($sql = "SELECT $table.*,u.name user_name FROM $table JOIN fe_users u ON $table.user_uid=u.uid WHERE $table.pid='".$this->getStoragePid()."' ".$this->cObj->enableFields("tx_ggphotos_uploads")." ORDER BY uid DESC");
		}
		$r = $db->sql_fetch_assoc($this->q);
		if(!$r) return $this->q=false;

		$types = array(0=>'',1=>'winner');
		$data = array('file'=>$r['file_name'],'title'=>$r['special_title'],'special'=>$types[$r['special_type']],'user'=>$r['user_name']);
		return $data;
	}

}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_photos/pi1/class.tx_ggphotos_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_photos/pi1/class.tx_ggphotos_pi1.php']);
}

?>
