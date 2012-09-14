<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

	<link rel="stylesheet" href="style.css" />

</head>


<body>

<div id="wrapper">

	<div id="gully">
		<img src="images/gully.png" alt="gully" />
	</div>
	
	

	<div id="form">
	
	<div id="header">
		<img src="images/hello.png" alt="hello" />
	</div>
	
	<div id="blurb">
	Due to the high demand the deadline for re-registering has been extended until 14th OCT
	</div>
	
	
	
	<form id="re-register-form" action="process.php" method="POST">
	
		<div class="item-wrapper item-fan-no">
			<label class="re-register-label" for="field-fan-number">Fan Number</label>
			<input type="text" name="fan-number" id="field-fan-number" class="field-input" maxlength="20" /><div id="eightdigs">(8 Digits)</div>
			<div id="no-fan-no">If can't remember your fan number,<br /> please email: <a href="mailto:youngseagulls@bhafc.co.uk">youngseagulls@bhafc.co.uk</a>.</div>
		</div>
				
		<div class="item-wrapper">
			<label class="re-register-label" for="field-first-name">First Name</label>
			<input type="text" name="first-name" id="field-first-name" class="field-input" maxlength="20" />
		</div>
		
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-last-name">Last Name</label>
			<input type="text" name="last-name" id="field-last-name" class="field-input" maxlength="20" />
		</div>
		
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-email">Email</label>
			<input type="text" name="email" id="field-email" class="field-input" maxlength="70" />
		</div>
		
		
		<div class="item-wrapper">
			<label class="dob-label" for="dob-number">Date of Birth <br /> <span id="dob-label">dd/mm/yyyy</span></label>
			<input type="text" name="dob" id="field-dob" class="field-input" maxlength="10" />
		</div>
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-phone">Phone Number</label>
			<input type="text" name="phone" id="field-phone" class="field-input" maxlength="70" />
		</div>
		
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-house-number">House Number</label>
			<input type="text" name="house-number" id="field-house-number" class="field-input" maxlength="10" />
		</div>
		
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-addr-1">Addr 1</label>
			<input type="text" name="addr-1" id="field-addr-1" class="field-input" maxlength="20" />
		</div>
		
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-addr-2">Addr 2</label>
			<input type="text" name="addr-2" id="field-addr-2" class="field-input" maxlength="20" />
		</div>
		
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-addr-3">Addr 3</label>
			<input type="text" name="addr-3" id="field-addr-3" class="field-input" maxlength="20" />
		</div>
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-city">City</label>
			<input type="text" name="city" id="field-city" class="field-input" maxlength="20" />
		</div>
		
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-county">County</label>
			<input type="text" name="county" id="field-county" class="field-input" maxlength="20" />
		</div>
		
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-postcode">Postcode</label>
			<input type="text" name="postcode" id="field-postcode" class="field-input" maxlength="10" />
		</div>
		
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-favoyrite-player">Favourite Player</label>
			<input type="text" name="favourite-player" id="field-favoyrite-player" class="field-input" maxlength="20" />
		</div>
		
		<input type="submit" id="submit" value="submit" />
	
	</form>
	</div>
	
</div>

</body>
</html>