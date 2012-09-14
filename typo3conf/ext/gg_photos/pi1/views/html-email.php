<p>A new <?=$this->getType()?> has been uploaded to Gully's Gang and needs moderation.</p>

<p>User <?=$user['name']?> (<?=$user['username']?>) uploaded this file:</p>
<?
$url = "http://$_SERVER[HTTP_HOST]/uploads/gg_photos/$file";
?>
<img src='<?=$url?>'/>
<p><a href='<?=$url?>'><?=$url?></a></p>
