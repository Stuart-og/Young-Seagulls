<?php

$db = new mysqli("localhost", "root", "", "re-register");
	if (!$db){
	die("Could not connect to mysql");
	}
		
		
foreach($_POST as $key => $value){

	$put = $db->query("UPDATE applicants SET added  = '$value' WHERE id = '$key' "); 

	echo ($key)."<br />";
	echo ($value)."<br />";
	
	}

?>