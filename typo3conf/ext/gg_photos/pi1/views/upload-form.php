<?
	if(!$user = $GLOBALS['TSFE']->fe_user->user){
		echo $this->view('registration-required');
		return;
	}
?>
			<h1 class="popuptitle"><?=$this->getType()?>s</h1>
			<div class="popupcontent">
			<p>Please use the form below to choose the file you'd like to submit. Just to let you know your drawing will not appear on the website straight away as it need to be checked by Gully!</p>
			<form method='post' action='<?=$this->makeAjaxLink('upload')?>'>
				<div id='fileProgress' class='fileProgress'>
					<div class='progressBar'></div>
				</div>
				<div id="fileQueue" class='fileQueue'></div>
				<div class='uploadify-wrapper'>
					<input type='file' class='uploadify' id='file-upload'/>
				</div>
				<input type='submit' class='uploadify-hide' value='Upload'/>
				<div style='display:none;' class='confirm'>
					<?=$this->view('upload-confirmation')?>
				</div>
			</form>
			</div>
