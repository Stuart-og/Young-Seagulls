<?php
			
	if( verify($loginCustomerNo, $loginPassword) == "True" ){
		setcookie("id", $loginCustomerNo);
		} 
		
	$data = "loginId=YSG1&";
	$data .= "password=YSG1&";
	$data .= "company=YSG&";

	$data .= "XMLString=".urlencode("<?xml version=\"1.0\" encoding=\"UTF-8\"?>
				<CustomerRetrievalRequest>
				  <Version>1.0</Version>
				   <TransactionHeader>
				    <SenderID></SenderID>
				    <ReceiverID></ReceiverID>
				    <CountryCode></CountryCode>
				    <LoginID>YSG1</LoginID>
				    <Password>YSG1</Password>
				    <Company>YSG</Company>
				    <TransactionID></TransactionID>
				  </TransactionHeader>
				  <CustomerRetrieval>
				    <CustomerNo>$loginCustomerNo</CustomerNo>
				  </CustomerRetrieval>
				</CustomerRetrievalRequest>");

	$length = strlen($data);
			
	$ch = curl_init(TALENT_RETRIVE_URL);
	
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: $length"));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	$response = curl_exec($ch);	
	
	curl_close($ch);
		
	$response = new SimpleXMLElement($response);
		
	$xml = new SimpleXMLElement($response[0]);
	
	$customer = $xml->CustomerRetrieval->CustomerDetails;
	
	$customerNo = trim($customer->CustomerNo);
	$firstName = trim($customer->ContactForename);
	$lastName = trim($customer->ContactSurname);
	$addr1 = trim($customer->AddressLine1);
	$addr2 = trim($customer->AddressLine2);
	$addr3 = trim($customer->AddressLine3);
	$addr4 = trim($customer->AddressLine4);
	$addr5 = trim($customer->AddressLine5);
	$postcode = trim($customer->PostCode);
	$email = trim($customer->EmailAddress);
	$dob = trim($customer->DateOfBirth);
		
	$dobYear = $dob{0};
	$dobYear .= $dob{1};
	$dobYear .= $dob{2};
	$dobYear .= $dob{3};
	
	$dobMonth = $dob{4};
	$dobMonth .= $dob{5};
	
	$dobDay = $dob{6};
	$dobDay .= $dob{7};
	
	include('edit.php');