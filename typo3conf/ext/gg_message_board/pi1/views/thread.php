		    <h3><?=$message['user']?></h3>
		    <?=$message['message']?>

			<p style='display:none' class='message-time'>@<?=$message['at']?></p>
			<div class='response-list'>
<?
	$responses = $this->query_responses($message['uid']);
	while($response = $this->read($responses)){
?>
		<div class='response'>
			<h3><?=$response['user']?></h3>
			<?=$response['message']?>

			<p style='display:none' class='message-time'>@<?=$response['at']?></p>
		</div>
<?
	}
?>
			</div><!-- .response-list-->
			<? if ($message['liked']) { ?>
			<p style='display:none' class='liked-by'><?=$message['liked']?> user<?=($message['liked']>1)?'s':''?> likes this post</p>
			<? } ?>
