<?php

ini_set('display_errors', 'on');

require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/typo3conf/localconf.php');

// Connet to DB
$dbh = new PDO('mysql:host=' . __MYSQL_HOST__ . ';dbname=' . __MYSQL_NAME__, __MYSQL_USER__, __MYSQL_PASS__);
$stmt = $dbh->prepare("SELECT * FROM tx_ggfanzonemessages_messages WHERE uid = ".$_POST['uid']."");
$stmt->execute();
$arrValues = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($arrValues as $k => $v) {
	$message = $v['message'];
}


// Send email letting admins know message has been posted
$to = 'youngseagulls@bhafc.co.uk,brian.hicks@bhafc.co.uk,Tim.Dudding@bhafc.co.uk';
$subject = 'New message has been reported on Gully\'s Gang';
$mail_message = "The following message has been reported on Gully's Gang - ".$message.".\n\nLog into the TYPO3 CMS to approve this message";
$header = 'From: noreply@youngseagulls.co.uk';
// Send
mail($to, $subject, $mail_message, $header);

?>