<p>This thread has been reported abusive:</p>

<?
	$q = $this->query(1,"$this->table.uid='$uid'");
	$message = $this->read($q);
	include(dirname(__FILE__).'/thread.php');
	$link = "http://$_SERVER[HTTP_HOST]/typo3/";
?>
<p>Please go to <a href='<?=$link?>'><?=$link?></a> to moderate it</p>
