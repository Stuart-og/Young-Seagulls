<?php

require_once('typo3env.php');

$post_id = $_GET['post_id'];
$reporter_id = $_GET['reporter_id'];

// select the post
$query = $GLOBALS['TYPO3_DB']->SELECTquery(
                '*',         // SELECT ...
                'tx_tswall_posts',     // FROM ...
                'uid='.$post_id,    // WHERE...
                '',            // GROUP BY...
                '',    // ORDER BY...
                ''            // LIMIT ...
            );

$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, $query);
if (mysql_num_rows($res) > 0) {
	$row = mysql_fetch_assoc($res);
	//print_r($row);
	$post = $row['post'];
	$user_name = $row['user'];
	$user_query = $GLOBALS['TYPO3_DB']->SELECTquery(
                	'*',   // SELECT ...
                	'fe_users',     // FROM ...
                	'username='.$user_name,    // WHERE...
                	'',    // GROUP BY...
                	'',    // ORDER BY...
                	''     // LIMIT ...
            	);
	$user_res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, $user_query);
	if (mysql_num_rows($user_res) > 0) {
		$user_row = mysql_fetch_assoc($user_res);
		//print_r($user_row);
		$user_name = $user_row['username'];
	}
	
}


$reporter_query = $GLOBALS['TYPO3_DB']->SELECTquery(
                	'*',   // SELECT ...
                	'fe_users',     // FROM ...
                	'uid='.$reporter_id,    // WHERE...
                	'',    // GROUP BY...
                	'',    // ORDER BY...
                	''     // LIMIT ...
            	);
$reporter_res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, $reporter_query);
if (mysql_num_rows($reporter_res) > 0) {
	$reporter_row = mysql_fetch_assoc($reporter_res);
	$reporter_username = $reporter_row['username'];
}


$to = 'youngseagulls@bhafc.co.uk,brian.hicks@bhafc.co.uk,Tim.Dudding@bhafc.co.uk';
$subject = 'A wall post has been reported';
$mail = "The following post has been submitted for review by the user with the username \"".$reporter_username."\":\n\n\"";
$mail .= "The post was made by user with the username: ".$user_name."\n\n";
$mail .= "The post reads: ".$post."\n\n";
$mail .= "If you deem this post to contain inappropriate language please log in as an administrator and delete it.";
$header = 'From: noreply@encompassco.com';

mail($to, $subject, $mail, $header);

die();

?>