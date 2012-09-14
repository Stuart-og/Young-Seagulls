<?php

	$customerNo = $xml->CustomerAddDetails->Sites->Site->Contacts->Contact->CustomerNo;
	
	$to      = $email;
	$subject = 'Congratulations! Young Seagulls Registration';
	$message = "Dear $firstName $lastName\r\nYou have successfully registered with the Young Seagulls\r\nYour registration number is $customerNo";
	
	$headers = 'From: youngseagulls@bhafc.co.uk' . "\r\n" .
	    'Reply-To: youngseagulls@bhafc.co.uk' . "\r\n" .
	    'X-Mailer: PHP/' . phpversion();
	
	mail($to, $subject, $message, $headers);
	
	
	$to      = 'Jo.Wilson@bhafc.co.uk';
	$subject = 'New Young Seagulls Registration';
	$message = "A new Young Seagull has been registered.\r\n";
	
	$message .= "Name: $firstName $lastName\r\n";
	$message .= "Registration No: $customerNo\r\n";
	$message .= "Password: $selectPassword\r\n\r\n";
	$message .= "Email: $email\r\n";
	$message .= "Telephone number: $telephoneNumber\r\n";
	$message .= "DOB: $dob\r\n";
	$message .= "Address:$addr1\r\n$addr2\r\n$addr3\r\n$addr4\r\n$addr5\r\n$postcode\r\n";

  $message = wordwrap($message, 70);
	
	$headers = 'From: youngseagulls@bhafc.co.uk' . "\r\n" .
	    'Reply-To: youngseagulls@bhafc.co.uk' . "\r\n" .
	    'Cc: brian.hicks@bhafc.co.uk' . "\r\n" .
	    'X-Mailer: PHP/' . phpversion();
	
	mail($to, $subject, $message, $headers);
	
	
	$db = new mysqli('localhost', 'root', '', 'bhafc2');
	
	if( $db->connect_error ){
		echo "Error: ".$db->connect_error;
		}
		
	$db->query("INSERT INTO fe_users (pid, username, password, usergroup, name, address, email, zip) VALUES ('28', '$customerNo', '$selectPassword', '1', '$firstName $lastName', '$addr1 $addr2', '$email', '$postcode')");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title>Brighton &amp; Hove Albion Football Club | Young Seagulls | Gully's Gang</title>
<link rel="stylesheet" type="text/css" href="files/stylesheet_4361ce6074.css" media="screen">
<link rel="stylesheet" type="text/css" href="style.css" />
<link media="screen" href="files/layout.css" type="text/css" rel="stylesheet">
<link media="screen" href="files/gg-layout.css" type="text/css" rel="stylesheet">
<link media="screen" href="files/home.css" type="text/css" rel="stylesheet">
<link media="screen" href="files/hub2.css" type="text/css" rel="stylesheet">
</head>
<body>



  <div class="container container_4 hub" id="home">
    
    <div id="gg-header-wrapper">

      
      <div id="gg-logo">  <a href="http://www.youngseagulls.co.uk/gullys-gang/">Welcome to Gully's Gang</a>
</div>
      
      <div id="gg-top-login"><ul>
						<!--<li id="gg-re-register"><a href="http://www.youngseagulls.co.uk/Re-register/re-register.php">re-register</a></li>-->
	        			<li id="gg-join-gang"><a href="http://www.youngseagulls.co.uk/gullys-gang/join/">Joing the Gang</a></li>
    	    			<li id="gg-login"><a href="http://www.youngseagulls.co.uk/gullys-gang/login/">Login</a></li>
    	    			<li id="gg-team-stripes"><a href="http://www.youngseagulls.co.uk/team-stripes">re-register</a></li>
    	    			<li id="gg-login-top-end">&nbsp;</li>
    	    	  	  </ul>
    	    	  	  <div class="clearer"></div></div>
      
      <ul id="gg-global-nav">        <li id="gg-global-nav-fun-stuff"><a href="http://www.youngseagulls.co.uk/gullys-gang/fun-stuff/">Fun Stuff</a></li>
        <li id="gg-global-nav-game-on"><a href="http://www.youngseagulls.co.uk/gullys-gang/game-on/">Game On</a></li>
        <li id="gg-global-nav-fan-zone"><a href="http://www.youngseagulls.co.uk/gullys-gang/fan-zone/">Fan Zone</a></li>
        <li id="gg-global-nav-skills"><a href="http://www.youngseagulls.co.uk/gullys-gang/skills/">Skills</a></li>
        <li id="gg-global-nav-the-score"><a href="http://www.youngseagulls.co.uk/gullys-gang/the-score/">The Score</a></li>
        <li id="gg-global-nav-news"><a href="http://www.youngseagulls.co.uk/gullys-gang/news/">News</a></li>
        <li id="gg-global-nav-meet-the-team"><a href="http://www.youngseagulls.co.uk/gullys-gang/meet-the-team/">Meet the Team</a></li>
        <li id="gg-global-nav-stadium"><a href="http://www.youngseagulls.co.uk/gullys-gang/win/">Stadium</a></li>
</ul>

      <div class="clearer"></div>
      
<!-- /#gg-ticker-wrapper -->
      
    </div> <!-- /#gg-header-wrapper -->
    
    <div id="gg-content-top">
    
    </div>
    
    <div id="gg-content-middle">

	<div id="confirmation">
		<p>Congratulations, you are now registered with the Young Seagulls.</p>
		<p id="registration-no">Your registration number is <?php echo $customerNo ?>
		<p style="margin-left:200px; padding-top:50px;">
		<a style="color:white;" href="http://www.youngseagulls.co.uk/gullys-gang/login/">Login»</a>
		</p> 
	</div>

<div class="clearer"></div>

<!-- //////////////////////////////////////////END/OF/CONTENT//////////////////////////////////////////////////// -->      
      
      </div> <!-- /#gg-middle-top -->
      <div id="gg-content-bottom"></div> <!-- /#gg-content-bottom -->
       
    <div id="gg-footer-wrapper">
      <ul id="gg-footer-nav-left">


	<!--

		BEGIN: Content of extension "gg_login_logout", plugin "tx_ggloginlogout_pi2"

	-->
	<div class="tx-ggloginlogout-pi2">
		<li id="gg-join-gang"><a href="http://www.youngseagulls.co.uk/gullys-gang/join/">Joing the Gang</a></li>
        			  <li id="gg-login"><a href="http://www.youngseagulls.co.uk/gullys-gang/login/">Login</a></li>
	</div>
	
	<!-- END: Content of extension "gg_login_logout", plugin "tx_ggloginlogout_pi2" -->

	</ul>
      
      <ul id="gg-footer-nav-right"><li><a href="http://www.youngseagulls.co.uk/gullys-gang/footer-toolkit/official-site/" target="new" onfocus="blurLink(this);">Official Site</a></li><li><a href="http://www.youngseagulls.co.uk/gullys-gang/footer-toolkit/tickets/" target="new" onfocus="blurLink(this);">Tickets</a></li><li><a href="http://www.youngseagulls.co.uk/gullys-gang/footer-toolkit/online-store/" target="new" onfocus="blurLink(this);">Online Store</a></li><li><a href="http://www.youngseagulls.co.uk/gullys-gang/footer-toolkit/sitemap/" onfocus="blurLink(this);">Sitemap</a></li><li><a href="http://www.youngseagulls.co.uk/gullys-gang/footer-toolkit/credits/" onfocus="blurLink(this);">Credits</a></li><li class="gg-footer-nav-right-blue"><a href="http://www.youngseagulls.co.uk/gullys-gang/footer-toolkit/safe-online/" onfocus="blurLink(this);">Safe Online</a></li><li class="gg-footer-nav-right-blue"> 2010 Brighton &amp; Hove Albion</li></ul>
      
      <div class="clearer"></div>
    </div>     
     
    
  </div>






</body></html>