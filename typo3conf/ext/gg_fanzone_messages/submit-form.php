<?php

error_reporting(E_ALL);
ini_set('display_errors', 'on');

require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/typo3conf/localconf.php');

$pid = 132;
$hidden = '1';
$user_uid = $_POST['gg-messages-small-user-uid'];
$message = $_POST['gg-messages-small-message'];

// Connet to DB
$db = new PDO('mysql:host=' . __MYSQL_HOST__ . ';dbname=' . __MYSQL_NAME__, __MYSQL_USER__, __MYSQL_PASS__);

$db->exec('
	INSERT INTO tx_ggfanzonemessages_messages (pid, tstamp, crdate, hidden, user_uid, message)
	VALUES(
		' . $pid . ',
		' . time() . ',
		' . time() . ',
		' . $hidden . ',
		' . $user_uid . ',
		' . $db->quote($message) . '
	)');

// Send email letting admins know message has been posted
$to = 'youngseagulls@bhafc.co.uk,brian.hicks@bhafc.co.uk,Tim.Dudding@bhafc.co.uk';
$subject = 'New message has been posted on Gully\'s Gang';
$mail_message = "The following message has been posted to Gully's Gang - ".$message.".\n\nLog into the TYPO3 CMS to approve this message";
$header = 'From: noreply@youngseagulls.co.uk';
// Send
mail($to, $subject, $mail_message, $header);

?>