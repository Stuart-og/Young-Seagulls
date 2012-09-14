<?
	include(dirname(__FILE__).'/../pi1/fields.php');
	$uneditable = array('gg-reg-email','gg-reg-dob','gg-reg-gender');
	foreach($uneditable as $field) unset($fields[$field]);
?>
