<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010  <>
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
 * Plugin 'Seagulls Profile' for the 'se_registration' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_seregistration
 */
class tx_seregistration_pi2 extends tx_seregistration_registrationform {
	var $prefixId      = 'tx_seregistration_pi2';		// Same as class name
	var $scriptRelPath = 'pi2/class.tx_seregistration_pi2.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'se_registration';	// The extension key.
	
	function getFormData(){
		$user = $GLOBALS['TSFE']->fe_user->user;
		if(!$_SESSION['retrieved']){
			$customer = $this->retreiveCustomerData();
			ob_start();
			print_r($customer);
			error_log("SOAP Retrieved: ".ob_get_contents());
			ob_end_clean();
			$_SESSION['retrieved'] = $customer;
		}

		$customer = $_SESSION['retrieved'];

		for($a=0;$a<4;$a++){
			$user["add$a"] = $customer["AddressLine$a"];
		}
		$map = array(
			"ContactForename"=>"fname",
			"ContactSurname"=>"lname",
			"PostCode"=>"pcode",
			"DateOfBirth"=>"dob",
			"EmailAddress"=>"email",
			"HomeTelephoneNumber"=>"home-phone",
			"WorkTelephoneNumber"=>"daytime-phone",
			"Gender"=>"gender",

			);
		foreach($map as $k=>$v)
			$user[$v] = $customer[$k];

//		list($user['fname'],$user['lname']) = explode(" ",$user['name']);
		//list($user['add1'],$user['add2'],$user['add3']) = explode("\\n",$user['address']);

		if(preg_match('/Stand: (.*) Block: (.*) Row: (.*) Seat: (.*)/',$user['tx_seregistration_season_ticket'],$matches)){

			list($null,$seat['stand'],$seat['block'],$seat['row'],$seat['seat']) = $matches;
			$user = array_merge($user,$seat);
			$user['seat'] = $seat;
		}
		$user['parent'] = $user['tx_seregistration_parent_name'];
		if($user['tx_seregistration_play_for']) $user['team'] = explode(",",$user['tx_seregistration_play_for']);
		if($user){
			foreach($user as $k=>$v){
				$output["gg-reg-$k"] = $v;
			}
		}
		return array_merge($output,$_POST);
	}
	function retreiveCustomerData(){
		$user = $GLOBALS['TSFE']->fe_user->user;
//		$client = new SupplyNetClient();
		
		$client = new SoapClient('http://'.SUPPLYNET_DOMAIN.'/Supplynet/Customer.asmx?WSDL',array('cache_wsdl'=>false));
		
		//$response = $client->CustomerRetrievalRequest(array('loginId'=>'YSG1','password'=>'YSG1','company'=>'YSG','XMLString'=>
		ob_start();
		include(dirname(__FILE__).'/soap/CustomerRetrievalRequest.php');
		$xml = ob_get_contents();
		ob_end_clean();
		$response = $client->CustomerRetrievalRequest(array('loginId'=>'YSG1','password'=>'YSG1','company'=>'YSG','XMLString'=>$xml));
		$xml = simplexml_load_string($response->CustomerRetrievalRequestResult);
		if(!$xml) return array();

		$customer = $xml->CustomerRetrieval->CustomerDetails;
		foreach($customer->children() as $node){
			$values[(string)$node->getName()] = trim((string)$node);
		}
		return ($values);
		// Not sure what the xml would look like....
	}
	function processData($post){
		$post = $this->getFormData();
		$assigns = $this->getDBAssigns($post);

		// Update Supply Net

		$client = new SoapClient('http://'.SUPPLYNET_DOMAIN.'/Supplynet/Customer.asmx?WSDL',array('cache_wsdl'=>false));
		
		$response = $client->CustomerUpdateRequest(array('loginId'=>'YSG1','password'=>'YSG1','company'=>'YSG','XMLString'=>$xml = returnUpdateCustomerXML($post)));
		error_log("Update Request: $xml");
		$xml = simplexml_load_string($response->CustomerUpdateRequestResult);
		$subResponse = $xml->CustomerUpdateDetails->Response;
		switch($subResponse ? (string)$subResponse->ReturnCode : 'FAIL'){
		case '':
			$content = $this->view('confirmation',array(
				'fields'=>$this->getFields(),
				'values'=>$this->getFormData(),
				'result'=>$post
			));
			unset($_SESSION['retrieved']);
			break;
		case 'XR':
		case 'FAIL':
		default:
			$message = "Code : $subResponse->ReturnCode\n".htmlspecialchars($xml?$xml->asXML():"Could not parse")."\n".json_encode($response);
			error_log("SOAP FAIL: $response->CustomerUpdateRequestResult");
			$content = $this->view('soap-error',array('message'=>$message));
			break;
		}
		$res = $GLOBALS['TYPO3_DB']->exec_UPDATEquery('fe_users', "uid='".$GLOBALS['TSFE']->fe_user->user['uid']."'",$this->getDBAssigns($post));

		return $content;
	}
	function getDBAssigns($post){
		$post = parent::getDBAssigns($post);
		unset($post['username']);
		unset($post['email']);
		unset($post['dob']);
		unset($post['gender']);
		return $post;
	}
	function validationErrors($post){
		return false;
	}
}
function returnUpdateCustomerXML($post) {
		$user = $GLOBALS['TSFE']->fe_user->user;
	// Salutation
	if ($post['gg-reg-gender'] == 'M') {
		$salutation = 'Mr';
	} else {
		$salutation = 'Ms';
	}
	if($post['gg-reg-dob']){
		$dob=$post['gg-reg-dob'];
	} else {
		$dob = $post['gg-reg-dob-year'].$post['gg-reg-dob-month'].$post['gg-reg-dob-day'];
	}
	ob_start();
	include(dirname(__FILE__).'/soap/CustomerUpdateRequest.php');
	$xmlString = ob_get_contents();
	ob_end_clean();
	return $xmlString;
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/se_registration/pi2/class.tx_seregistration_pi2.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/se_registration/pi2/class.tx_seregistration_pi2.php']);
}

?>
