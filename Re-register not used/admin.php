<?php

$username = $_POST['username'];
$pass = $_POST['pass'];



$db = new mysqli("localhost", "root", "", "login");
	if (!$db){
	die("Could not connect to mysql");
	}
	
$records = $db->query("SELECT * FROM users WHERE user = '$username' AND pass = '$pass' ");

$exist = $records->num_rows;

$db->close;

unset($records);
unset($db);

if ($exist == 1){
	setcookie("auth", "yes");
	header('Location: applicants.php');
	}
	else{
	setcookie("auth", null);
	header('Location: login.php');
	}

?>