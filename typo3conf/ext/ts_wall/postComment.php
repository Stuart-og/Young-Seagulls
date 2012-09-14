<?php

require_once('typo3env.php');

$post = mysql_real_escape_string($_GET['ts-wall-comment']);
$user_uid = $_GET['ts-wall-user-uid'];
$user_id = $_GET['ts-wall-user-id'];
$user_name = $_GET['ts-wall-user-name'];

// INSERT:
$insertArray = array(
    'pid' => 108,
    'tstamp' => time(),
	'crdate' => time(),
	'cruser_id' => $user_uid,
	'deleted' => 0,
	'hidden' => 1,
	'post' => $post,
	'user' => $user_id
);

$query = $GLOBALS['TYPO3_DB']->INSERTquery('tx_tswall_posts', $insertArray);
$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, $query);

$to = 'youngseagulls@bhafc.co.uk,brian.hicks@bhafc.co.uk,Tim.Dudding@bhafc.co.uk';
$subject = 'A new post has been made to the Team Stripes Wall';
$mail = "The following post has been submitted to the Team Stipes Wall by ".$user_name.":\n\n\"".$post."\"\n\n";
$header = 'From: noreply@encompassco.com';

mail($to, $subject, $mail, $header);

die();

?>