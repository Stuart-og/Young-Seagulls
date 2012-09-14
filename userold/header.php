<?php

	define('TALENT_ADD_URL', "http://www.seagulls.talent-sport.co.uk/supplynet/customer.asmx/CustomerAddRequest");
	define('TALENT_RETRIVE_URL', "http://www.seagulls.talent-sport.co.uk/supplynet/customer.asmx/CustomerRetrievalRequest");
	define('TALENT_VERIFY_URL', "http://www.seagulls.talent-sport.co.uk/supplynet/customer.asmx/VerifyPasswordRequest");
	define('TALENT_UPDATE_URL', "http://www.seagulls.talent-sport.co.uk/supplynet/customer.asmx/CustomerUpdateRequest");
	define('TALENT_PASSWORD_RETRIVE_URL', "http://www.seagulls.talent-sport.co.uk/supplynet/customer.asmx/RetrievePasswordRequest");


	function verify($customernumber, $pass){

		$data = "loginId=YSG1&";
		$data .= "password=YSG1&";
		$data .= "company=YSG&";
	
		$data .= "XMLString=".urlencode("<?xml version=\"1.0\" encoding=\"UTF-8\"?>
					<VerifyPasswordRequest>
					  <Version>1.0</Version>
					  <TransactionHeader>
					    <SenderID/>
					    <ReceiverID/>
					    <CountryCode/>
					    <LoginID>YSG1</LoginID>
					    <Password>YSG1</Password>
					    <Company>YSG</Company>
					    <TransactionID/>
					  </TransactionHeader>
					  <VerifyPassword>
					    <UserName>$customernumber</UserName>
					    <Password>$pass</Password>
					  </VerifyPassword>
					</VerifyPasswordRequest>");
	
		$length = strlen($data);
				
		$ch = curl_init(TALENT_VERIFY_URL);
		
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: $length"));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		$response = curl_exec($ch);	
		
		curl_close($ch);
			
		$response = new SimpleXMLElement($response);
			
		$xml = new SimpleXMLElement($response[0]);
		
		return $xml->VerifyPassword->Response->PasswordOK;
	
		}