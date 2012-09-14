<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link rel="stylesheet" href="style.css" />
</head>
<body>

<div id="login-wrap">

<form id="login-form" action="admin.php" method="POST">
	
		<div class="login-field">
			<label class="username" for="field-username">User:</label>
			<input type="text" name="username" id="field-username" maxlength="20" />
		</div>
		
		<div class="login-field">
			<label class="pass" for="field-pass">Pass:</label>
			<input type="password" name="pass" id="field-pass" maxlength="20" />
		</div>
		
		<div id="login-btn">
		<input type="submit" id="Login" value="Login" />
		</div>

</form>

</div>

</body>
</html>