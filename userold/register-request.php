<?php

	require ('header.php');

	$firstName = trim($_POST['first-name']);
	$lastName = trim($_POST['last-name']);
	$email = trim($_POST['email']);
	$emailConf = trim($_POST['email-conf']);
	$telephoneNumber = trim($_POST['telephone-number']);
	$dobDay = trim($_POST['dob-day']);
	$dobMonth = trim($_POST['dob-month']);
	$dobYear = trim($_POST['dob-year']);
	$gender = trim($_POST['gender']);
	$addr1 = trim($_POST['addr-line-1']);
	$addr2 = trim($_POST['addr-line-2']);
	$addr3 = trim($_POST['addr-line-3']);
	$addr4 = trim($_POST['addr-line-4']);
	$addr5 = trim($_POST['addr-line-5']);	
	$postcode = trim($_POST['postcode']);
	$selectPassword = trim($_POST['select-password']);
	$confirmPassword = trim($_POST['confirm-password']);	
		
	$err = false;
	
	if( strlen($firstName) < 1 ){
		$firstName_err = "<div id='first-name-err' class='err' >*Please enter your first name</div>";
		$err = true;
	}

	if( strlen($lastName) < 1 ){
		$lastName_err = "<div id='last-name-err' class='err' >*Please enter a last name</div>";
		$err = true;
	}
	
	if( strlen($email) < 1 ){
		$email_err = "<div id='email-err' class='err' >*Please enter an email address</div>";
		$err = true;
	}
		
	if( strlen($emailConf) < 1 ){
		$emailConf_err = "<div id='email-err' class='err' >*Please confirm your email address</div>";
		$err = true;
	}
		
	if( $email != $emailConf ){
		$emailConf_err = "<div id='email-err' class='err' >*Emails do not match</div>";
		$err = true;
	}
		
	if( strlen($telephoneNumber) < 1 ){
		$telephoneNumber_err = "<div id='telephone-err' class='err' >*Please enter your telephone number</div>";
		$err = true;
	}

	if( strlen($dobDay) < 1 || strlen($dobMonth) < 1 || strlen($dobYear) < 1 ){
		$dob_err = "<div id='dob-err' class='err' >*Please enter you date of birth</div>";
		$err = true;
	}
		
	if( strlen($gender) < 1 ){
		$gender_err = "<div id='gender-err' class='err' >*Please select your gender</div>";
		$err = true;
	}
		
	if( strlen($addr1) < 1 ){
		$addr1_err = "<div id='addr1-err' class='err' >*Please enter your house</div>";
		$err = true;
	}
				
	if( strlen($addr2) < 1 ){
		$addr2_err = "<div id='addr2-err' class='err' >*Please enter the first line of your address</div>";
		$err = true;
	}		
		
	if( strlen($addr4) < 1 ){
		$addr4_err = "<div id='addr4-err' class='err' >*Please enter your city</div>";
		$err = true;
	}
		
	if( strlen($addr5) < 1 ){
		$addr5_err = "<div id='addr5-err' class='err' >*Please enter your county</div>";
		$err = true;
	}
		
	if( strlen($postcode) < 1 ){
		$postcode_err = "<div id='postcode-err' class='err' >*Please enter your postcode</div>";
		$err = true;
	}
		
	if( strlen($selectPassword) < 6 ){
		$password_err = "<div id='password-err' class='err' >*Please enter you desired password (min 6 characters)</div>";
		$err = true;
	}
	else if( $selectPassword != $confirmPassword  ){
		$password_err = "<div id='password-err' class='err' >*Passwords did not match</div>";
		$err = true;
	}
		
	$dob = $dobYear.$dobMonth.$dobDay;
			
	$data = "loginId=YSG1&";
	$data .= "password=YSG1&";
	$data .= "company=YSG&";
	$data .= "XMLString=".urlencode("<?xml version='1.0' encoding='UTF-8'?>
				<CustomerAddRequest>
				  <Version>1.1</Version>
				  <TransactionHeader>
				    <SenderID/>
				    <ReceiverID/>
				    <CountryCode/>
				    <LoginID>YSG1</LoginID>
				    <Password>YSG1</Password>
				    <Company>YSG</Company>
				    <TransactionID/>
				  </TransactionHeader>
				  <Defaults>
				    <BusinessUnit>UNITEDKINGDOM</BusinessUnit>
				  </Defaults>
				  <CustomerAdd>
				    <Sites Total='1'>
				      <Site>
				        <Name></Name>
				        <AccountNumber1/>
				        <AccountNumber2/>
				        <AccountNumber3/>
				        <AccountNumber4/>
				        <AccountNumber5/>
				        <Address>
				          <Line1></Line1>
				          <Line2></Line2>
				          <Line3></Line3>
				          <Line4></Line4>
				          <Line5></Line5>
				          <PostCode></PostCode>
				          <Country>United Kingdom</Country>
				        </Address>
				        <TelephoneNumber/>
				        <FaxNumber/>
				        <VATNumber/>
				        <URL/>
				        <ID/>
				        <CRMBranch/>
				        <Contacts Total='1'>
				          <Contact>
				            <Title></Title>
				            <Initials></Initials>
				            <Forename>$firstName</Forename>
				            <Surname>$lastName</Surname>
				            <FullName></FullName>
				            <Salutation></Salutation>
            				<MothersName/>
           					<FathersName/>
				            <EmailAddress>$email</EmailAddress>
				            <LoginID/>
				            <Password>$selectPassword</Password>
				            <AccountNumber1/>
				            <AccountNumber2/>
				            <AccountNumber3/>
				            <AccountNumber4/>
				            <AccountNumber5/>
				            <Addresses Total='1'>
				              <Address>
				                <SequenceNumber>1</SequenceNumber>
				                <Default>True</Default>
				                <Reference>Default Address</Reference>
				                <Line1>$addr1</Line1>
				                <Line2>$addr2</Line2>
				                <Line3>$addr3</Line3>
				                <Line4>$addr4</Line4>
				                <Line5>$addr5</Line5>
				                <PostCode>$postcode</PostCode>
				                <Country>United Kingdom</Country>
				              </Address>
				            </Addresses>
				            <Position>YS-11/12</Position>
				            <Gender>$gender</Gender>
				            <TelephoneNumber1>$telephoneNumber</TelephoneNumber1>
				            <TelephoneNumber2/>
				            <TelephoneNumber3/>
				            <TelephoneNumber4/>
				            <TelephoneNumber5/>
				            <DateOfBirth>$dob</DateOfBirth>
				            <ContactViaMail>Y</ContactViaMail>
				            <HTMLNewsletter>N</HTMLNewsletter>
	                        <Subscription1>N</Subscription1>
				            <Subscription2>N</Subscription2>
				            <Subscription3>N</Subscription3>
				            <MailFlag1>N</MailFlag1>
				            <ExternalId1>1234</ExternalId1>
				            <ExternalId2>5678</ExternalId2>
				            <MessagingID/>
				            <Boolean1/>
				            <Boolean2/>
				            <Boolean3/>
				            <Boolean4/>
				            <Boolean5/>
				            <ID/>
				            <USERID1/>
				            <USERID2/>
				            <USERID3/>
				            <USERID4/>
				            <USERID5/>
				            <USERID6/>
				            <USERID7/>
				            <USERID8/>
				            <USERID9/>
				            <RestrictedPaymentTypes Total=''>
				              <PaymentType/>
				            </RestrictedPaymentTypes>
				            <Attributes Total=''>
				              <Attribute/>
				            </Attributes>
				            <LoyaltyPoints/>
				            <IsLockedOut>False</IsLockedOut>
				            <CustomerPurchaseHistory>False</CustomerPurchaseHistory>
				          </Contact>
				        </Contacts>
				      </Site>
				    </Sites>
				  </CustomerAdd>
				</CustomerAddRequest>");
				
	if($err == false){


		$length = strlen($data);

		$ch = curl_init(TALENT_ADD_URL);

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: $length"));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


		$response = curl_exec($ch);

		curl_close($ch);

		if( simplexml_load_string($response) ){

			$response = new SimpleXMLElement($response);

		}

		//$response = new SimpleXMLElement($response);


		$a = simplexml_load_string($response[0]);

		if( $a === false ){
			$sendError = "<div id='register-err-msg'>Sorry but there was an problem sending off your details. Please try again or contact the Young Seagulls Team</div>";
			$created = false;
		}
		else{
			$xml = new SimpleXMLElement($response[0]);
		}



		if( isset($xml) ){

			if( $xml->CustomerAddDetails->Response->ReturnCode == "XP" ){
				$duplicate = "<div id='register-err-msg'>Sorry but you appear to already be registered with the young seagulls<br />If you are experiencing problems please contact the Young Seagulls Team on: <a href='youngseagulls@bhafc.co.uk'>youngseagulls@bhafc.co.uk</a></div>";
				$created = false;
			}

			if( $xml->CustomerAddDetails->Response->ReturnCode == "" ){

				$customerNo = $xml->CustomerAddDetails->Sites->Site->Contacts->Contact->CustomerNo;

				if( strlen($customerNo) < 12 ){
					$sendError = "<div id='register-err-msg'>Sorry but there was an problem sending off your details. Please  try again or contact the Young Seagulls Team</div>";
					$created = false;
				}
				else{
					require("register-confirmation.php");
					exit();
				}				

			}
		}
	}