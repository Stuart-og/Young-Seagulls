// JavaScript Document
$(document).ready(function(){
	$("#ts-home-slider").easySlider({
		auto: false,
		continuous: true
	});
});


function loadVideo($file) {
	$.ajaxSetup ({  
		cache: false  
	});
	
	var ajax_load = "<img src='fileadmin/ts-templates/img/global/mtt-loading.gif' id='ts-home-loading' alt='loading...' />";  
	// load() functions  
	var loadUrl = "http://www.youngseagulls.co.uk/typo3conf/ext/ts_home_videos/ts-home.php?vid="+$file;
	$("#ts-home-video").html(ajax_load).load(loadUrl);
}