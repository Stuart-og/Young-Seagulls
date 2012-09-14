
		<div id="gg-messages-small">
		  <div id="gg-messages-small-top"></div>
		
		  <div id="gg-message-small-container">

		<? while($message = $this->fetch()){ ?>
			<div class="message-small ajax-wrapper" id='message-<?=$message['uid']?>'>
				<? include(dirname(__FILE__).'/thread.php'); ?>
	<p class="tools"><a class="like ajax-link" href="<?=$this->makeAjaxLink('like',array('uid'=>$message['uid']))?>">Like</a> <a class="comment" id='comment-link-<?=$message['uid']?>' href="#">Comment</a> <a class="report ajax-link" href="<?=$this->makeAjaxLink('reportconfirm',array('uid'=>$message['uid']))?>">Report</a></p>
			<div class='comment-form' id='comment-form-<?=$message['uid']?>' style='display: none'>
				<?=$this->view('form',array('response_to'=>$message['uid']))?>
			</div>
			<div class='ajax-response'></div>
			</div><!--message-small-->
		<? } ?>
			</div><!--small-container-->
		
		
		
<!--		  <div class="bottom-panel-bg">
		    <div class="bottom-panel">-->




<div id="gg-message-bottom-panel">
  <div id="gg-message-top-bg"></div>
  <div id="gg-message-middle-bg">
	<?=$this->view('form')?>
  </div>
  <div id="gg-message-bottom-bg"></div>
</div>



<!--			</div>
		  </div>-->

		</div><!--messages-small-->
<div class="clearer"></div>