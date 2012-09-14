<?php

$db = new mysqli("localhost", "root", "", "re-register");
	if (!$db){
	die("Could not connect to mysql");
	}
	

	

$firstname = trim($_POST['first-name']);
$lastname = trim($_POST['last-name']);
$email = trim($_POST['email']);
$houseno = trim($_POST['house-number']);
$addr1 = trim($_POST['addr-1']);
$addr2 = trim($_POST['addr-2']);
$addr3 = trim($_POST['addr-3']);
$city = trim($_POST['city']);
$county = trim($_POST['county']);
$postcode = trim($_POST['postcode']);
$favoriteplayer = trim($_POST['favourite-player']);
$fanno = trim($_POST['fan-number']);
$dob = trim($_POST['dob']);
$phone = trim($_POST['phone']);


$custemail = $email;

$custname = $firstname;


if($favoriteplayer == ""){
		$favplayer_err = '*Please tell us your favourite player';
		$errmsg = "true";
		}

if($firstname == ""){
		$firstname_err = '*Please enter your first name';	
		$errmsg = "true";	
		}
		
		
if($lastname == ""){
		$lastname_err = '*Please enter your last name';
		$errmsg = "true";
		}
	
	
if($email == ""){
		$email_err = '*Please enter your email';
		$errmsg = "true";
		}
		
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$email_err = '*Invalid email';
		$errmsg = "true";
		}	
	
if($houseno == ""){
		$houseno_err = '*Please enter your house number';
		$errmsg = "true";
		}
	
	
if($addr1 == ""){
		$addr1_err = '*Please enter your address';
		$errmsg = "true";
		}
	
	
if($city == ""){
		$city_err = '*Please enter your city';
		$errmsg = "true";
		}
	
	
if($county == ""){
		$county_err = '*Please enter your county';
		$errmsg = "true";
		}
	
if($postcode == ""){
		$postcode_err = '*Please enter your postcode';
		$errmsg = "true";
		}
		
if($fanno == ""){
		$fanno_err = '*Please enter your fan number';
		$errmsg = "true";
		}
		
if($fanno !== "" && strlen($fanno) !== 8){
		$fanno_err = '*Fan should be 8 Digits';
		$errmsg = "true";
		}
		
$pattern2 = '/^[5-7]/';
		
if(!preg_match($pattern2, $fanno)){
		$fanno_err = '*Fan no must start with a 5,6,7';
		$errmsg = "true";
		}
		
$pattern1 = '/[^0-9]/';
		
if(preg_match($pattern1, $fanno)){
		$fanno_err = '*Fan no can only contain numbers 0-9';
		$errmsg = "true";
		}
		
if($dob == ""){
		$dob_err = '*Please enter you date of birth';
		$errmsg = "true";
		}
		
if($phone == ""){
		$phone_err = '*Please enter you phone number';
		$errmsg = "true";
		}
	
	
if(!$errmsg){

$firstname =  addslashes($firstname);
$lastname = addslashes($lastname);
$email = addslashes($email);
$houseno = addslashes($houseno);
$addr1 = addslashes($addr1);
$addr2 = addslashes($addr2);
$addr3 = addslashes($addr3);
$city = addslashes($city);
$county = addslashes($county);
$postcode = addslashes($postcode);
$favoriteplayer = addslashes($favoriteplayer);
$fanno = addslashes($fanno);
$dob = addslashes($dob);
$phone = addslashes($phone);
	
	
	$put_into_db = $db->query("INSERT INTO applicants (fanno, FirstName, LastName, email, HouseNumber, addr1, addr2, addr3, City, County, Postcode, Favorite_player, dob, phoneno) VALUES ('$fanno', '$firstname', '$lastname', '$email', '$houseno', '$addr1', '$addr2', '$addr3', '$city', '$county', '$postcode', '$favoriteplayer', '$dob', '$phone')");
	
	if(!$put_into_db){
		echo 'error saving your details<br /> Please contact us';
		exit();
		}
	}
	

if (!$errmsg){	
	header('Location: thankyou.php');
	}

		
?>


<html>
<head>

	<link rel="stylesheet" href="style.css" />

</head>

<body>

<?php 


$to = $custemail;

$subject = "Young Seagulls re-registration";

$headers = "From: Young Seagulls <noreply@dlx36097.fm.netbenefit.co.uk>\r\n";

$headers .= "Organization: Young Seagulls\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "X-Mailer: PHP". phpversion() ."\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


$message = "Dear ".$custname."\r\n"."\r\n";
 
$message .= "Thank you for re-registering as a Young Seagulls member, I'm so excited you have decided to continue to be part of Brighton & Hove Albion football club."."\r\n"."\r\n";
 
$message .= 'The Young Seagulls team will now start the process of registering you as a member and your goody pack will be with you shortly.'."\r\n"."\r\n";
 
$message .= 'I hope to see you at the Amex Stadium soon,'."\r\n"."\r\n";
 
$message .= 'Best wishes'."\r\n"."\r\n";
 
$message .= 'Gully';

$message2 = '

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<head>
<title>Thank you from Young Seagulls</title>
</head>
<body bgcolor="#c9eff8">
<table width="661" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
		<td width="153">
			<img style="display:block;" src="http://demo.oandg.co.uk/baha/young-seagulls-email/images/young-seagulls-logo-top.jpg" alt="Thank you from young seagulls" />
		</td>
		<td style="font-family:arial, helvetica, sans-serif; font-size:10px; text-align:left; vertical-align:bottom; background-color:#c9eff8;">	
			<p style="margin:0px;"><a style="color:#003e7f;" href="http://demo.oandg.co.uk/baha/young-seagulls-email/">If this email has not displayed correctly, please click here to view web version</a></p>

		</td>
	<tr>
	<tr>
		<td colspan="2">
		<img src="http://demo.oandg.co.uk/baha/young-seagulls-email/images/young-seagulls-header.jpg" alt="Thank you from young seagulls" usemap="#navmap" />
		</td>
	</tr>
<table width="661" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>

		<td width="41">
		<img height="274" width="41" src="http://demo.oandg.co.uk/baha/young-seagulls-email/images/young-seagulls-left-spacer.jpg" alt="spacer" />
		</td>
		
		<td width="420">
		
			<table width="420" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td height="243" style="background-color:#006fb7; color:white; font-family:arial, helvetica, sans-serif; font-size:12px;">
					
						<p style="margin-top:0px;">
						Dear '.$firstname.'
						</p>

					
						<p>
						Thank you for re-registering as a Young Seagulls member, I\'m so excited you have decided to continue to be part of Brighton 						& Hove Albion football club.
 						</p>
						
						<p>
						The Young Seagulls team will now start the process of registering you as a member and your goody pack will be with you 								shortly.
						</p>
						
						<p>
						I hope to see you at the Amex Stadium soon,
						</p>
						
						<p style="vertical-align:top" >

						<div>Best Wishes,</div> <img style="display:inline-block; margin-left:70px;" align="righjt" src="http://demo.oandg.co.uk/baha/young-seagulls-email/images/gully.jpg" alt="gully signature" />
						</p>
						
						
						
					</td>			
				</tr>
				<tr>
					<td>
						<img height="31" width="420" src="http://demo.oandg.co.uk/baha/young-seagulls-email/images/young-seagulls-bottom.jpg" alt="spacer" />
					</td>

				</tr>
			</table>
		
		</td>
		
		<td width="200">
		<img height="274" width="200" src="http://demo.oandg.co.uk/baha/young-seagulls-email/images/young-seagulls-right-spacer.jpg" alt="spacer" />
		</td>
	</tr>	
</table>

<map name="navmap">

	<area shape="rect" coords="160,16,210,56" href="http://www.youngseagulls.co.uk/gullys-gang/fun-stuff/" alt="Fun Stuff" />
	<area shape="rect" coords="215,16,265,56" href="http://www.youngseagulls.co.uk/gullys-gang/game-on/" alt="Game On" />
	<area shape="rect" coords="272,16,323,56" href="http://www.youngseagulls.co.uk/gullys-gang/fan-zone/" alt="Fan Zone" />
	<area shape="rect" coords="326,16,380,56" href="http://www.youngseagulls.co.uk/gullys-gang/skills/" alt="Skillz" />
	<area shape="rect" coords="390,16,437,56" href="http://www.youngseagulls.co.uk/gullys-gang/the-score/" alt="The Score" />
	<area shape="rect" coords="440,16,495,56" href="http://www.youngseagulls.co.uk/gullys-gang/news/" alt="News" />
	<area shape="rect" coords="500,16,570,56" href="http://www.youngseagulls.co.uk/gullys-gang/meet-the-team/" alt="Meet the Team" />
	<area shape="rect" coords="573,16,650,56" href="http://www.youngseagulls.co.uk/gullys-gang/stadium/" alt="Stadium" />
</map>




';


wordwrap($message, 70, "\r\n");

	if ($errmsg){
	 include 'errform.php';
	 }
	 else{
	 echo "Your Details have been submitted";
	 mail($to, $subject, $message2, $headers);
	 }





 ?>




</body>
</html>