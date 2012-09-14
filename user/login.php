<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=7" />
	<title>Please Confirm</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

	<form id="login-form" action="edit-details.php" method="post">
	
		<?php if( $err ){ echo $err; } ?>
	
		<p>
		Please confirm your login details below:
		</p>
	
		<div class="form-item">
			<label for="customer-no">Customer Number</label>
			<input id="customer-no" type="text" name="customer-no" />
		</div>	
		
		<div class="form-item">
			<label for="password">Password</label>
			<input id="passsword" type="password" name="password" />
		</div>
		
		<input id="submit" type="image" src="images/login-btn.png" />	
	
	</form>

</body>
</html>