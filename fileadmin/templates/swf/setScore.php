<?php
        require_once("includes/config.php");
        require_once("includes/database.php");
	?>
	<?php 
//escape_value  $database->escape_value("It's working?<br />"); 
$date = date('jS F Y h:i:s A');

	?>   
<?php

if(!isset($_GET['call']) || $_GET['call'] != '35gf34') die();

$user = trim($_GET['user']);
$score = trim($_GET['score']);
$chksum = trim($_GET['chksum']);

if($chksum != md5($score.$user."seagulls")) die(md5($score.$user.'seagulls'));

$status = 1;

//die('status=' . $status);


//$user = 'Rko test';
$sql  = "INSERT INTO players  (first_name, score) ";
$sql .= "VALUES ( '{$user}', '{$score}')";
//$sql  = "INSERT INTO players  (id, first_name, last_name, score, date) ";
//$sql .= "VALUES ( '','{$user}', 'Rko', '{$score}','{$date}')";
$result = $database->query($sql);

