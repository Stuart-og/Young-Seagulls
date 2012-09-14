
$(document).ready(function(){
	$("#ts-skills-slider").easySlider({
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
	var loadUrl = "http://www.youngseagulls.co.uk/typo3conf/ext/ts_skills/skills.php?uid="+$uid;
	$("#ts-skills-vid-detail-wrapper").html(ajax_load).load(loadUrl,function() { // Callback
		Cufon.replace('h1')('h2')('h3')('h4')('.intro')('.nextfixture');
	});
}