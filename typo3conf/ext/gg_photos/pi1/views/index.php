		<div id="gg-photo-panel-bg">
		  <div id="gg-photo-panel-top"><h2 class="spacer">Send in<br /><strong>your photos</strong></h2></div>
		  <div class="content">
			<?
            if($top = $this->getFeatured("Top Photo")){
                $alt = $top['title'];
                $src = "uploads/gg_photos/thumbs/".$top['img'][0];
            } else {
                $alt = "Placeholder";
                $src = "fileadmin/templates/img/global/placeholder.png";
            }
            
            ?>
			<!--<img width="85" height="79" alt="<?=$alt?>" src="<?=$src?>"/><p>Send us your cool Albion pictures and get them featured on this site!</p>-->
			<img width="85" height="79" src="/fileadmin/templates/img/fanzone/upload-pic.jpg"/><p>Send us your cool Albion pictures and get them featured on this site!</p>
		  </div>
		  <div class="bottom-panel-bg">
		    <div class="bottom-panel">
		    <p><a href="/gullys-gang/fan-zone/rules/">Rules</a></p><a href="<?=$this->makeAjaxLink('form')?>" class="button nyroModal">Enter</a></div>
		  </div> <!-- /#gg-photo-panel-bg -->
		</div>