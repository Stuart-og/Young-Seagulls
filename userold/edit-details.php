<?php 

	require('header.php');
	
	$loginCustomerNo = $_POST['customer-no'];
	$loginPassword = $_POST['password'];
		
	if( verify($loginCustomerNo, $loginPassword) != "True" && $_SERVER['REQUEST_METHOD'] == "POST" ){
		$err = "<div id='conf-err'>Invalid Username or Password</div>";
		include "login.php";
		}
	else if( verify($loginCustomerNo, $loginPassword) == "True" ){
		include "retrive.php";
	}
	else{
		include "login.php";
		}