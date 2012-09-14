<?
class tx_ggphotos_image_display {
	function show_preview($context, $tceForms){
		$fileName = $context['itemFormElValue'];
		$dir = $context['fieldConf']['config']['base_dir'];

		return "<img src='/uploads/$dir/$fileName'/>";
	}
	function show_username($context,$tceForms){
		return $this->getUserName($context['itemFormElValue'],"%s - %s");
	}
	function getUserName($uid,$format = "%s"){
		static $users = array();
		if(!$users[$uid]){
			$db = $GLOBALS['TYPO3_DB'];
			$users[$uid] = $db->sql_fetch_assoc($db->sql_query("SELECT name,username FROM fe_users WHERE uid='$uid'"),0);
		}
		return sprintf($format,$users[$uid]['name'],$users[$uid]['username']);
	}
	function getImageFile($table,$uid){
		$db = $GLOBALS['TYPO3_DB'];
		$image = $db->sql_fetch_assoc($db->sql_query("SELECT file_name FROM $table WHERE uid='$uid'"),0);
		return preg_replace("/^[0-9]*-/","",$image['file_name']);
	}
	function get_image_title(&$data){
		$data['title'] = $this->getUserName($data['row']['user_uid'])." - ".$this->getImageFile($data['table'],$data['row']['uid']);
	}
}
?>
