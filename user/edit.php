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
        <li id="gg-global-nav-skills"><a href="http://www.youngseagulls.co.uk/gullys-gang/gullys-gang/parties/">Skills</a></li>
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

<form action="update.php" method="post">

	<?php if($updated){ echo $updated; } ?>
	
	<div class="form-item">
		<label for="first-name">First Name</label>
		<input id="first-name" type="text" name="first-name" <?php if ($firstName){ echo "value='".$firstName."'"; } ?> />
		<?php if( $firstName_err ){ echo $firstName_err; } ?>
	</div>
	
	<div class="form-item">
		<label for="last-name">Last Name</label>
		<input id="last-name" class="readonly" type="text" name="last-name" <?php if ($lastName){ echo "value='".$lastName."'"; } ?> readonly />
		<?php if( $lastName_err ){ echo $lastName_err; } ?>
	</div>
	
	<div class="form-item">
		<label for="email">Email</label>
		<input id="email" type="text" name="email" <?php if ($email){ echo "value='".$email."'"; } ?> />
		<?php if( $email_err ){ echo $email_err; } ?>
	</div>
	
	<div class="form-item">
		<label for="dob-day">Date of Birth</label>
		<input type="text" id="dob-day" class="readonly" type="text" name="dob-day" <?php echo "value='".$dobDay."'"; ?>  readonly />-
		<input type="text" id="dob-month" class="readonly" type="text" name="dob-month" <?php echo "value='".$dobMonth."'"; ?>  readonly />-
		<input type="text" id="dob-year" class="readonly" type="text" name="dob-year" <?php echo "value='".$dobYear."'"; ?>  readonly />
	</div>

	<div class="form-item">
		<label for="addr-line-1">House Name/Number</label>
		<input id="addr-line-1" type="text" name="addr-line-1" <?php if( $addr1 ){ echo "value='".$addr1."'"; } ?> />
		<?php if( $addr1_err ){ echo $addr1_err; } ?>
	</div>	
	
	<div class="form-item">
		<label for="addr-line-2">Address Line 1</label>
		<input id="addr-line-2" type="text" name="addr-line-2" <?php if( $addr2 ){ echo "value='".$addr2."'"; } ?> />
		<?php if( $addr2_err ){ echo $addr2_err; } ?>
	</div>	
	
	<div class="form-item">
		<label for="addr-line-3">Address Line 2</label>
		<input id="addr-line-3" type="text" name="addr-line-3" <?php if( $addr3 ){ echo "value='".$addr3."'"; } ?> />
		<?php if( $addr3_err ){ echo $addr3_err; } ?>
	</div>	
	
	<div class="form-item">
		<label for="addr-line-4">City</label>
		<input id="addr-line-4" type="text" name="addr-line-4" <?php if( $addr4 ){ echo "value='".$addr4."'"; } ?> />
		<?php if( $addr4_err ){ echo $addr4_err; } ?>
	</div>
	
	<div class="form-item">
		<label for="addr-line-5">County</label>
		<input id="addr-line-5" type="text" name="addr-line-5" <?php if( $addr5 ){ echo "value='".$addr5."'"; } ?> />
		<?php if( $addr5_err ){ echo $addr5_err; } ?>
	</div>
	
	<div class="form-item">
		<label for="postcode">Postcode</label>
		<input id="postcode" type="text" name="postcode" <?php if( $postcode ){ echo "value='".$postcode."'"; } ?> />
		<?php if( $postcode_err ){ echo $postcode_err; } ?>
	</div>
	
	<div class="form-item">
		<label for="newpass">New password</label>
		<input id="newpass" type="password" name="newpass" />
		<?php if( $newpass_err ){ echo $newpass_err; } ?>
	</div>
	
	<div class="form-item">
		<label for="newpassconf">Confirm new password</label>
		<input id="newpassconf" type="password" name="newpassconf" />
	</div>
	
	<div class="form-item">
		<label for="current-pass">Current Password</label>
		<input id="current-pass" type="password" name="current-pass" />
		<?php if( $currentPass_err ){ echo $currentPass_err; } ?>
	</div>
		
	<div class="form-item">
		<input id="submit" type="image" src="images/Update-btn.png" />
	</div>

</form>

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
      
      <ul id="gg-footer-nav-right"><li><a href="http://www.youngseagulls.co.uk/gullys-gang/footer-toolkit/official-site/" target="new" onfocus="blurLink(this);">Official Site</a></li><li><a href="http://www.youngseagulls.co.uk/gullys-gang/footer-toolkit/tickets/" target="new" onfocus="blurLink(this);">Tickets</a></li><li><a href="http://www.youngseagulls.co.uk/gullys-gang/footer-toolkit/online-store/" target="new" onfocus="blurLink(this);">Online Store</a></li><li><a href="http://www.youngseagulls.co.uk/gullys-gang/footer-toolkit/sitemap/" onfocus="blurLink(this);">Sitemap</a></li><li><a href="http://www.youngseagulls.co.uk/gullys-gang/footer-toolkit/credits/" onfocus="blurLink(this);">Credits</a></li><li class="gg-footer-nav-right-blue"><a href="http://www.youngseagulls.co.uk/gullys-gang/footer-toolkit/safe-online/" onfocus="blurLink(this);">Safe Online</a></li><li class="gg-footer-nav-right-blue">� 2010 Brighton &amp; Hove Albion</li></ul>
      
      <div class="clearer"></div>
    </div> <!-- /#gg-footer-wrapper -->
    
     
    
  </div> <!-- /.container -->






</body></html>