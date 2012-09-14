
$(document).ready(function(){
	$("#gg-video-thumbs-container").easySlider({
		auto: false, 
		continuous: true
	});
});

function loadVideo($uid) {
	$.ajaxSetup ({
		cache: false
	});
	
	var ajax_load = "<img src='fileadmin/ts-templates/img/global/mtt-loading.gif' id='ts-skills-loading' alt='loading...' />";
	// load() functions
	var loadUrl = "http://www.youngseagulls.co.uk/typo3conf/ext/gg_skills/skills.php?uid="+$uid;
	$("#gg-skills-video-panel").html(ajax_load).load(loadUrl,function() { // Callback
		//Cufon.replace('h1')('h2')('h3')('h4')('.intro')('.nextfixture');
	});
}