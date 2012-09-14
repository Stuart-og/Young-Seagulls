    <div id="gg-drawings">
    <div id="gg-drawings-top"><h2 class="spacer">Send us <strong>your own brilliant</strong> pictures!</h2></div>
        <!-- gg-drawings-container -->
        <div id="gg-drawings-container">

        
<!-- Gallery -->
<div id="caption"></div>

<div class="carbonbox h4 slideshow-container">
	<!-- Start Advanced Gallery Html Containers -->				
	<div id="controls" class="controls"></div>
	<div id="loading" class="loader"></div>
	<div id="slideshow" class="slideshow"></div>


	<div id="gg-team-info-stats">    
		<div id="thumbs" class="navigation">
			<a class="pageLink prev" style="visibility: hidden;" href="#" title="Previous Page"></a>

			<ul class="thumbs noscript">
<?
	while($img = $this->fetchDetails()){
?>
				<li>
					<a class="thumb" name="<?=$img['file']?>" href="uploads/gg_photos/<?=$img['file']?>" title="<?=$img['file']?>"> 
					<img width="65" height="49" alt="Placeholder" src="uploads/gg_photos/thumbs/<?=$img['file']?>" alt="<?=$img['file']?>" /> 
					</a>
       					<div class="caption" style='display: none'>
						<h3 class="image-title">Submitted by: <span><?=$img['user']?></span></h3>
						<span class='special' style='display:none'><?=$img['special']?></span>
					</div>
				</li>
<? } ?>
			</ul>
            
			<a class="pageLink next" style="visibility: hidden;" href="#" title="Next Page"></a>

		<div>
	<div>

</div>

</div>

</div> <!-- /#thumbs -->
</div>
<!-- End Gallery Html Containers -->

        <div class="bottom-panel-bg">
          <div class="bottom-panel">
		<p><a href="#">Need Help?</a></p><a class="button nyroModal" href="<?=$this->makeAjaxLink("form")?>">Enter</a>

          </div>
        </div>


</div>
<!-- End Gallery -->
        </div><!-- /gg-drawings-container -->
	</div><!-- /gg-drawings -->
