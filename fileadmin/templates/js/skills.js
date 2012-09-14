$(document).ready(function(){	
	$("#gg-video-thumbs-container").easySlider();
});

function loadVideo(target, video, title, desc, rating) {
	$(target).flashembed("http://releases.flowplayer.org/swf/flowplayer-3.1.5.swf", { 
    //$(target).flashembed("http://localhost/bhafc/fileadmin/templates/swf/gg-player.swf", { 
		// "config" parameter is a complex JSON object, not just a simple value 
		config: {
			clip:  {
				autoPlay: true, 
				autoBuffering: true, 
				url: video
			} 
		} 
	});
	
	
	document.getElementById('gg-skills-video-info').innerHTML =  '<h2 class="start">Start</h2>'+
																  '<h3>'+title+'</h3>'+
  																  '<p>'+desc+'</p>'+
  																  '<div class="mainrating">'+
    															  '<p><strong>Video Rating:</strong></p>'+
																  '<a href="#" class="bigrating-off">1 Star</a>'+
																  '<a href="#" class="bigrating">2 Stars</a>'+
																  '<a href="#" class="bigrating">3 Stars</a>';
}