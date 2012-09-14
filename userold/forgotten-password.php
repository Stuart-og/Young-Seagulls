<?php

	if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
	
		$customerNo = $_POST['customer-no'];
	
		if( strlen($customerNo) < 1 ){
			$err = "<div class='err'>Please enter a customer number</div>";
			}
		else{	

			$db = new mysqli('localhost', 'root', '', 'bhafc2');
			
			if( $db->connect_error ){
				echo "Error: ".$db->connect_error;
				}
				
			$result = $db->query("SELECT password, email FROM fe_users WHERE username = '$customerNo' ");
			
			if( $result->num_rows != 0 ){
									
				$user =  $result->fetch_object();
					
				$headers = 'From: youngseagulls@bhafc.co.uk' . "\r\n" .
				   'Reply-To: youngseagulls@bhafc.co.uk' . "\r\n" .
				   'X-Mailer: PHP/' . phpversion();
				   
				    $message = "Your Young Seagulls password is $user->password";
					
					mail( $user->email, 'Young Seagulls Password', $message, $headers );
					
					include "pass-email-conf.php";
					exit();
					
				}
			else{
				$err = "<div class='err'>Customer number not found</div>";
				}

			}

		}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=7" />
	<title>Forgotten your password for the Young Seagulls</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

	<form id="password-reminder-form" action="forgotten-password.php" method="post">
	
		<p>
		Please enter your customer number:
		</p>
	
		<div class="form-item">
			<label for="customer-no">Customer Number</label>
			<input id="customer-no" type="text" name="customer-no" />
			<?php if( $err ){ echo $err; } ?>
		</div>	
				
		<input id="login-btn" type="image" src="images/Submit-btn.png" />	
	
	</form>

</body>
</html>