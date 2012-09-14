<div id="wrapper">

	<div id="gully">
		<img src="images/gully.png" alt="gully" />
	</div>
	
	<div id="form">
	
	<div id="header">
		<img src="images/hello.png" alt="hello" />
	</div>

	<form id="re-register-form" action="process.php" method="POST">
	
		<div class="item-wrapper">
			<label class="re-register-label" for="field-fan-number">Fan Number</label>
			<input type="text" name="fan-number" id="field-fan-number" class="field-input" maxlength="20" value="<?php echo $fanno; ?>" />
			<div class="err-msg"><?php if($fanno_err){ echo $fanno_err;} ?></div>
		</div>
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-fan-number">First Name</label>
			<input type="text" name="first-name" id="field-first-name" class="field-input" maxlength="20" value="<?php echo $firstname; ?>" />
			<div class="err-msg"><?php if($firstname_err){ echo $firstname_err;} ?></div>
		</div>
		
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-last-name">Last Name</label>
			<input type="text" name="last-name" id="field-last-name" class="field-input" maxlength="20" value="<?php echo $lastname; ?>" />
			<div class="err-msg"><?php if($lastname_err){ echo $lastname_err;} ?></div>
		</div>
		
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-email">Email</label>
			<input type="text" name="email" id="field-email" class="field-input" maxlength="70" value="<?php echo $email; ?>"/>
			<div class="err-msg"><?php if($email_err){ echo $email_err;} ?></div>
		</div>
		
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-dob">Date of Birth <br /> <span id="dob-label">dd/mm/yyyy</span></label>
			<input type="text" name="dob" id="field-dob" class="field-input" maxlength="70" value="<?php echo $dob; ?>"/>
			<div class="err-msg"><?php if($dob_err){ echo $dob_err;} ?></div>
		</div>
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-phone">Phone Number</label>
			<input type="text" name="phone" id="field-phone" class="field-input" maxlength="70" value="<?php echo $phone; ?>"/>
			<div class="err-msg"><?php if($phone_err){ echo $phone_err;} ?></div>
		</div>
		
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-house-number">House Number</label>
			<input type="text" name="house-number" id="field-house-number" class="field-input" maxlength="10" value="<?php echo $houseno; ?>"/>
			<div class="err-msg"><?php if($houseno_err){ echo $houseno_err;} ?></div>
		</div>
		
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-addr-1">Addr 1</label>
			<input type="text" name="addr-1" id="field-addr-1" class="field-input" maxlength="20" value="<?php echo $addr1; ?>" />
			<div class="err-msg"><?php if($addr1_err){ echo $addr1_err;} ?></div>
		</div>
		
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-addr-2">Addr 2</label>
			<input type="text" name="addr-2" id="field-addr-2" class="field-input" maxlength="20" value="<?php if($addr2) {echo $addr2;} ?>" />
		</div>
		
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-addr-3">Addr 3</label>
			<input type="text" name="addr-3" id="field-addr-3" class="field-input" maxlength="20" value="<?php if($addr3) {echo $addr2;} ?>" />
		</div>
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-city">City</label>
			<input type="text" name="city" id="field-city" class="field-input" maxlength="20" value="<?php echo $city; ?>" />
			<div class="err-msg"><?php if($city_err){ echo $city_err;} ?></div>
		</div>
		
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-county">County</label>
			<input type="text" name="county" id="field-county" class="field-input" maxlength="20" value="<?php echo $county; ?>" />
			<div class="err-msg"><?php if($county_err){ echo $county_err;} ?></div>
		</div>
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-postcode">Postcode</label>
			<input type="text" name="postcode" id="field-postcode" class="field-input" maxlength="10" value="<?php echo $postcode; ?>" />
			<div class="err-msg"><?php if($postcode_err){ echo $postcode_err;} ?></div>
		</div>
		
		<div class="item-wrapper">
			<label class="re-register-label" for="field-favoyrite-player">Favourite Player</label>
			<input type="text" name="favourite-player" id="field-favoyrite-player" class="field-input" maxlength="20" value="<?php echo $favoriteplayer; ?>" />
			<div class="err-msg"><?php if($favplayer_err){ echo $favplayer_err;} ?></div>
		</div>
		
		<input type="submit" id="submit" value="submit" />
	
	</form>
	
	</div>
	
</div>
