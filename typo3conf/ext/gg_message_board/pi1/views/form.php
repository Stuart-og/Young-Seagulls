<?
		if($user){
?>
			<form method='post' class='ajax'>
				<?=$this->makeAjaxHiddenInputs('post')?>
				<input type='hidden' name='response_to' value='<?=$response_to?>'/>
		      <textarea rows="" cols="" name="message"></textarea>
		      <p>
		        <a href="#">Rules</a> | <a href="#">Help</a>
		        <br />
		        <a class="button submit" href="#">Post</a>
		      </p>
		      <div class="clearer"></div>
			</form>
<? } else { ?>
			<p><a href='<?=$this->makeLink("Login")?>'>Log In</a> or <a href='<?=$this->makeLink("Join The Gang")?>'>Join The Gang</a> to post messages</p>
<? } ?>
