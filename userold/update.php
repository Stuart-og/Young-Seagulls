<?php

	require('header.php');

	$title = trim($_POST['title']);
	$firstName = trim($_POST['first-name']);
	$lastName = trim($_POST['last-name']);
	$email = trim($_POST['email']);
	$dobDay = trim($_POST['dob-day']);
	$dobMonth = trim($_POST['dob-month']);
	$dobYear = trim($_POST['dob-year']);
	$addr1 = trim($_POST['addr-line-1']);
	$addr2 = trim($_POST['addr-line-2']);
	$addr3 = trim($_POST['addr-line-3']);
	$addr4 = trim($_POST['addr-line-4']);
	$addr5 = trim($_POST['addr-line-5']);	
	$postcode = trim($_POST['postcode']);
	$newpass = trim($_POST['newpass']);
	$newpassconf = trim($_POST['newpassconf']);
	$currentPass = trim($_POST['current-pass']);
	$customerNo = $_COOKIE['id'];
	
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

	if( strlen($dobDay) < 1 || strlen($dobMonth) < 1 || strlen($dobYear) < 1 ){
		$dob_err = "<div id='title-err' class='err' >*Please enter you date of birth</div>";
		$err = true;
		}
		
	if( strlen($addr1) < 1 ){
		$addr1_err = "<div id='title-err' class='err' >*Please enter your house</div>";
		$err = true;
		}
		
	if( strlen($addr2) < 1 ){
		$addr2_err = "<div id='title-err' class='err' >*Please enter the first line of your address</div>";
		$err = true;
		}		
		
	if( strlen($addr4) < 1 ){
		$addr4_err = "<div id='title-err' class='err' >*Please enter your city</div>";
		$err = true;
		}
		
	if( strlen($addr5) < 1 ){
		$addr5_err = "<div id='title-err' class='err' >*Please enter your county</div>";
		$err = true;
		}
		
	if( strlen($postcode) < 1 ){
		$postcode_err = "<div id='title-err' class='err' >*Please enter your postcode</div>";
		$err = true;
		}
		
	if( strlen($newpass) > 1 || strlen($newpassconf) > 1 ){
		
		if( strlen($newpass) < 6 ){
			$newpass_err = "<div id='title-err' class='err' >*Password must be at least 6 characters</div>";
			$err = true;
			}
		else if( $newpass != $newpassconf ){
			$newpass_err = "<div id='title-err' class='err' >*Passwords do not match</div>";
			$err = true;			
			}
		else{
			$password = $newpass;		
			}
			
		}
		else{
			$password = $currentPass;
		}
		
	if( strlen($currentPass) < 1 ){
		$currentPass_err = "<div id='password-err' class='err' >*Please enter you current password</div>";
		$err = true;
		}
		else if( verify($customerNo, $currentPass) != "True" ){
			$currentPass_err = "<div id='password-err' class='err' >*Incorrect password</div>";
			$err = true;
			}

							
	if( $err == true ){
		include('edit.php');
		exit();
		}
							
	if( $err == false ){
	
		$dob = $dobYear.$dobMonth.$dobDay;
		
		switch($title){
		
			case("Mr"):
				$gender = "M";
				break;
				
			case("Mrs"):
				$gender = "F";
				break;
				
			case("Miss"):
				$gender = "F";
				break;	
		
			}
			
		$data = "loginId=YSG1&";
		$data .= "password=YSG1&";
		$data .= "company=YSG&";	
	
		$data .=	"XMLString=".urlencode("<?xml version=\"1.0\" encoding=\"UTF-8\"?>
					<CustomerUpdateRequest>
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
					  <CustomerUpdate>
					    <Sites Total='1'>
					      <Site Mode=''>
					        <Name>IRIS</Name>
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
					        <Contacts Total=''>
					          <Contact Mode=''>
					            <Title>$title</Title>
					            <Initials></Initials>
					            <Forename>$firstName</Forename>
					            <Surname>$lastName</Surname>
					            <FullName></FullName>
					            <Salutation>Test</Salutation>
					            <EmailAddress>$email</EmailAddress>
					            <LoginID>$customerNo</LoginID>
					            <Password>$password</Password>
					            <AccountNumber1/>
					            <AccountNumber2/>
					            <AccountNumber3/>
					            <AccountNumber4/>
					            <AccountNumber5/>
					            <Addresses Total=''>
					              <Address Mode=''>
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
					            <Position></Position>
					            <Gender>$gender</Gender>
					            <TelephoneNumber1></TelephoneNumber1>
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
					              <PaymentType Mode=''/>
					            </RestrictedPaymentTypes>
					            <Attributes Total=''>
					              <Attribute Mode=''/>
					            </Attributes>
					            <LoyaltyPoints/>
					            <IsLockedOut>False</IsLockedOut>
					            <CustomerPurchaseHistory>False</CustomerPurchaseHistory>
					          </Contact>
					        </Contacts>
					      </Site>
					    </Sites>
					  </CustomerUpdate>
					</CustomerUpdateRequest>");
	
		$length = strlen($data);
			
		$ch = curl_init(TALENT_UPDATE_URL);
		
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: $length"));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		$response = curl_exec($ch);
		
		if( simplexml_load_string($response) ){
		
			$response = new SimpleXMLElement($response);
		
		}
				
    $a = simplexml_load_string($response[0]);
		
		if( $a === false ){
			$sendError = "<div id='register-err-msg'>Sorry but there was an problem updating your details. Please try again or contact the Young Seagulls Team</div>";
			$created = false;
		}
		else{
			$xml = new SimpleXMLElement($response[0]);
		}				
		

		curl_close($ch);
		
  if( isset($xml) ){
		
  		if( $xml->CustomerUpdateDetails->Sites->Site->SiteActionSuccess ){

    		$updated = "<div id='updated'>Details updated</div>";
    			
    		$db = new mysqli('localhost', 'root', '', 'bhafc2');
    	
    		if( $db->connect_error ){
    		  echo "Error: ".$db->connect_error;
    		}
  				
  		  $db->query("UPDATE fe_users SET password = '$password' WHERE username = '$customerNo'");
  		  include("edit.php");
  				
    		if( $db->error ){
    		  die("Error:".$db->error);
    		}
  				
  		}
  		else{
  		  $updated = "<div id='not-updated'>ERROR - Details not updated</div>";
  		}
  	
    }
  		
  }
  
  $resp = print_r($xml, true);
  
  $log = "\n\n-------START REQUEST-------\n\n".$data."\n\n".$resp."\n\n-------END REQUEST-------\n\n";

  if ( is_writable("update-logs.txt") ){
		
		  if (!$logfile = fopen('update-logs.txt', 'a')){
		    die("Error opening log file");
		  }
		  
		  fwrite($logfile, $log);
		
  }
  else{
    die("Log file is not writable");
  }
	
	