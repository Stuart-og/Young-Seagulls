<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009  <>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

require_once(dirname(__FILE__).'/../pi/class.tx_seregistration_registrationform.php');
require_once(dirname(__FILE__).'/../lib/class.SupplyNetRequest.php');


/**
 * Plugin 'Seagulls Registration' for the 'se_registration' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_seregistration
 */
class tx_seregistration_pi1 extends tx_seregistration_registrationform {
	var $prefixId      = 'tx_seregistration_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_seregistration_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'se_registration';	// The extension key.
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function processData($post){
		$useSoap = true;
		$useDummy = false;
		if($useSoap){
			if($useDummy){
				$client = new SoapClient(dirname(__FILE__).'/../lib/dummy.wsdl',array('cache_wsdl'=>false));
			} else {
				$client = new SoapClient('http://'.SUPPLYNET_DOMAIN.'/Supplynet/Customer.asmx?WSDL',array('cache_wsdl'=>false));
			}
			$response = $client->CustomerAddRequest(array('loginId'=>'YSG1','password'=>'YSG1','company'=>'YSG','XMLString'=>$xml = returnAddCustomerXML($post)));
		} else {
			if(!$url) $url = "http://gully.local/webDump.php";
			if($useDummy){
				$client = new SupplyNetClient("http://gully.local/webDump.php");
			} else {
				$client = new SupplyNetClient();
			}
			$response = $client->CustomerAdd(array('loginId'=>'YSG1','password'=>'YSG1','company'=>'YSG','XMLString'=>$xml = returnAddCustomerXML($post)));
		}
		error_log("SOAP: $xml");
		error_log("Full Response ".serialize($response));
		$xml = simplexml_load_string($response->CustomerAddRequestResult);
		$subResponse = $xml->CustomerAddDetails->Response;
		
		// Evaluate response
		//$subResponse = $xml->CustomerAddDetails->Response;
		
		switch($subResponse ? (string)$subResponse->ReturnCode : 'FAIL'){
		case '':
			$customerNumber = $xml->CustomerAddDetails->Sites->Site->Contacts->Contact->CustomerNo;
			$post['customerNumber'] = $customerNumber;
			
			$name = mysql_real_escape_string(@$post['gg-reg-fname'].' '.$post['gg-reg-lname']);
			$email = mysql_real_escape_string(@$post['gg-reg-email']);
			$school = mysql_real_escape_string(@$post['gg-reg-school']);
			$parent = mysql_real_escape_string(@$post['gg-reg-parent']);
			$team = mysql_real_escape_string(join(",",@$post['gg-reg-team']));
			$seasonTicket = mysql_real_escape_string('Stand: '.@$post['gg-reg-stand'].' Block: '.@$post['gg-reg-block'].' Row: '.@$post['gg-reg-row'].' Seat: '.@$post['gg-reg-seat']);
			$favPlayer = mysql_real_escape_string(@$post['gg-reg-fav-player']);
			$additionalMaterial = mysql_real_escape_string(@$post['gg-reg-additional']);
			$password = mysql_real_escape_string(@$post['gg-reg-password']);
			$dob = $post['gg-reg-dob-year'].$post['gg-reg-dob-month'].$post['gg-reg-dob-day'];
			
			$userData = compact(array('name','email','school','parent','team','seasonTicket','favPlayer','additionalMaterial','password','customerNumber'));
			$content = $this->view('registration-complete',$userData);
			$this->sendConfirmation($userData);
			$res = $GLOBALS['TYPO3_DB']->exec_INSERTquery('fe_users', $this->getDBAssigns($post));

			// Send email to new user with username and password details
			
			// Pull code out of response xml and store in database
			//echo "<pre>".htmlspecialchars($subResponse->asXML())."</pre>";
			break;
			
		case 'XP':
		case 'EU':
			//throw new Exception("Duplicate Customer");
			$content = $this->view('duplicate-error',$post);
			break;
		default:
			error_log("Registration Failure '$subResponse->returnCode' - ".json_encode(array('code'=>$subResponse->returnCode,'response'=>$response->CustomerAddRequestResponse,'post'=>$post)));
			//error_log("Full Response ".$response->asXML());
			$content = $this->view('soap-error',array_merge($post,array('subResponse'=>$subResponse,'response'=>$response)));
			break;
		}
		return $content;
	}

	function getValidationErrors($post){
		include(dirname(__FILE__).'/fields.php');

		$errors = array();
		foreach($fields as $k=>$params){
			if($params['email']){
				if(!preg_match("/^.+@.+\..+$/",$post[$k]))
					$errors[$k] = "Please enter a valid email address for $params[name] ";
			}
			if($params['required']){
				switch($params['type']){
				case 'date':
					foreach(array('year','day','month') as $period){
						if(!$post["$k-$period"]) $errors[$k] = "$params[name] is required";
					}
					break;
				default:
					if(!$post[$k])
						$errors[$k] = "$params[name] is requred";
				}
			}
		}
		return $errors;
	}
	function getAssigns($post){
		include(dirname(__FILE__).'/fields.php');
		$assigns = array();
		foreach($fields as $k=>$params){
			switch($params['type']){
			case 'date':
				$value = array();
				foreach(array('year','month','day') as $period){
					$value[] = $post["$k-$period"];
				}
				$assigns[$k] = join("",$value);
				break;
			default:
				$assigns[$k]=$post[$k];
			}
		}
		return $assigns;
	}

	function sendConfirmation($data){
		require_once(dirname(__FILE__).'/../lib/phpmailer/class.phpmailer.php');

		$html = $this->view('html-confirmation-email',$data);
		$text = $this->view('text-confirmation-email',$data);
		if(!$text) $text = html_entity_decode(strip_tags($html));

		$mail = new phpmailer();
		$mail->From = "registration@seagulls.co.uk";
		$mail->FromName="Gully's Gang Registration";
		$mail->Subject = "Thank you for joining Gully's Gang";
		if($html){
			$mail->IsHtml(true);
			$mail->Body=$html;
			$mail->AltBody=$text;
		} else {
			$mail->Body=$text;
		}
		$mail->AddAddress($data['email']);
		//$mail->AddBCC("db@brightenup.me");
		//$mail->AddBCC("stuart@oandg.co.uk");
		$mail->AddBCC("brian.hicks@bhafc.co.uk");
		$mail->Send();

	}

}

/*function returnString() {
	$xmlString = '<?xml version="1.0" encoding="utf-8" ?><CustomerAddRequest><Version>1.0</Version><TransactionHeader><SenderID></SenderID><ReceiverID></ReceiverID><CountryCode></CountryCode><LoginID>YSG1</LoginID><Password>YSG</Password><Company>YSG</Company><TransactionID></TransactionID></TransactionHeader><CustomerAdd><ContactTitle>Mr</ContactTitle><ContactInitials>G</ContactInitials><ContactForename>Test1229</ContactForename><ContactSurname>Test1220</ContactSurname><Salutation>Mr</Salutation><CompanyName></CompanyName><PositionInCompany></PositionInCompany><AddressLine1>Test Street</AddressLine1><AddressLine3>Test Town</AddressLine3><AddressLine4>Test County</AddressLine4><AddressLine5>England</AddressLine5><PostCode>TE5 3ST</PostCode><Gender>M</Gender><HomeTelephoneNumber>01234 56789010</HomeTelephoneNumber><WorkTelephoneNumber>012345 6789100</WorkTelephoneNumber><MobileNumber>07777 777777</MobileNumber><EmailAddress>test5@test.com</EmailAddress><DateOfBirth>19820806</DateOfBirth><ContactViaMail>Y</ContactViaMail><Subscription1>N</Subscription1><Subscription2>N</Subscription2><Subscription3>N</Subscription3><MailFlag1>N</MailFlag1><ExternalId1>1234</ExternalId1><ExternalId2>5678</ExternalId2><Password>5678</Password><Attributes><Attribute action="Add">HELLO</Attribute></Attributes></CustomerAdd></CustomerAddRequest>';
	return $xmlString;
}*/

function returnAddCustomerXML($post) {
	// Salutation
	if ($post['gg-reg-gender'] == 'M') {
		$salutation = 'Mr';
	} else {
		$salutation = 'Ms';
	}
	$dob = $_POST['gg-reg-dob-year'].$_POST['gg-reg-dob-month'].$_POST['gg-reg-dob-day'];
	ob_start();
	include(dirname(__FILE__).'/soap/CustomerAddRequest.php');
	$xmlString = ob_get_contents();
	ob_end_clean();
	return $xmlString;
}


class LocalSoapClient extends SoapClient {

  function __construct($wsdl, $options) {
    parent::__construct($wsdl, $options);
    $this->server = new SoapServer($wsdl, $options);
    $this->server->addFunction('returnString'); // Action?
  }

  function __doRequest($request, $location, $action, $version) {
    ob_start();
    $this->server->handle($request);
    $response = ob_get_contents();
    ob_end_clean();
    return $response;
  }

}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/se_registration/pi1/class.tx_seregistration_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/se_registration/pi1/class.tx_seregistration_pi1.php']);
}

?>
