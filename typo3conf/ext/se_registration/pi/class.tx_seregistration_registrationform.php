<?
	require_once(dirname(__FILE__).'/class.tx_seregistration_formplugin.php');
	class tx_seregistration_registrationform extends tx_seregistration_formplugin {
		function getDBAssigns($post){
			$name = mysql_real_escape_string(@$post['gg-reg-fname'].' '.$post['gg-reg-lname']);
			$email = mysql_real_escape_string(@$post['gg-reg-email']);
			$school = mysql_real_escape_string(@$post['gg-reg-school']);
			$parent = mysql_real_escape_string(@$post['gg-reg-parent']);
			$team = mysql_real_escape_string(join(",",@$post['gg-reg-team']));
			$seasonTicket = mysql_real_escape_string('Stand: '.@$post['gg-reg-stand'].' Block: '.@$post['gg-reg-block'].' Row: '.@$post['gg-reg-row'].' Seat: '.@$post['gg-reg-seat']);
			$favPlayer = mysql_real_escape_string(@$post['gg-reg-fav-player']);
			$additionalMaterial = mysql_real_escape_string(@$post['gg-reg-additional']);
			$password = mysql_real_escape_string(@$post['gg-reg-password']);
			$dob = $post['gg-reg-dob-year'].$post['gg-reg-dob-month'].$post['gg-reg-dob-day'];
			
			$userData = compact(array('name','email','school','parent','team','seasonTicket','favPlayer','additionalMaterial','password','customerNumber'));
				// Insert user into TYPO3 DB
			$page_id = $GLOBALS['TSFE']->id;
			
			//list of gullys gang registration pages
			$storage_pages = array(
				14=>28,
				22=>28,
				71=>28,
			);
			
			$pid = $storage_pages[$page_id];
			
			//default to team strips
			//if(!$pid) $pid=29;
			// Override the PID thing
			if(!$pid) $pid=28;
			
			$insertArray = array(
				'pid' => $pid,
				'name' => $name,
				'email' => $email,
				'tx_seregistration_school ' => $school,
				'tx_seregistration_dob ' => $dob,
				'tx_seregistration_parent_name ' => $parent,
				'tx_seregistration_play_for ' => $team,
				'tx_seregistration_season_ticket ' => $seasonTicket,
				'tx_seregistration_fav_player ' => $favPlayer,
				'tx_seregistration_additional_material ' => $additionalMaterial,
				'address'=>mysql_real_escape_string(@$_POST['gg-reg-add1']."\n".@$_POST['gg-reg-add2']."\n".@$_POST['gg-reg-add3']),
				'zip'=>mysql_real_escape_string(@$_POST['gg-reg-pcode']),
				'password' => $password,
				'username' => $post['customerNumber'],
				'disable' => 0,
				'usergroup' => 1
			);
			if(!$password) unset($insertArray['password']);
			return $insertArray;
		}
	}
?>
