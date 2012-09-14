<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'on');

if(!isset($_SESSION['player_name'])) {
	exit;
}

if(!isset($_POST['userscore'])) {
	exit;
}

$score = (int) $_POST['userscore'];
$name = (string) $_SESSION['player_name'];
$pid = 128;



require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/typo3conf/localconf.php');

// Connet to DB
$db = new PDO('mysql:host=' . __MYSQL_HOST__ . ';dbname=' . __MYSQL_NAME__, __MYSQL_USER__, __MYSQL_PASS__);

$db->exec('
	INSERT INTO tx_gggame_scores(pid, tstamp, crdate, username,score)
	VALUES(
		' . $pid . ',
		' . time() . ',
		' . time() . ',
		' . $db->quote($name) . ',
		' . (int) $score . '
	)
');

//$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'INSERT INTO tx_gggame_scores (username,score) VALUES ('.mysql_real_escape_string($username).', "'.mysql_real_escape_string($userscore).'")');

// Close DB here
?>