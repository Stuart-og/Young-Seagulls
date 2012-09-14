$(document).ready(function() { 
	// prepare Options Object 
	/* Message form */
	var options = {
		beforeSubmit: function() { 
		    if ($('textarea#gg-messages-small-message').val() == '') {
		    	alert('Whoops - you need to enter a message before posting it off to Gully.');
		    	return false;
		    }
		},
	    success:    function() { 
	        // Find height of form wrapper, and set it so it doesn't shrink when content is faded out.
			var formHeight = $("div#gg-message-form").height();
			var formWidth = $("div#gg-message-form").width();
	        $("div#gg-message-form").height(formHeight);
			$("div#gg-message-form").width(formWidth);
			
			// Fade out comment form
			$('form#gg-message-form-small').fadeOut('slow', function() {
				// Fade out compelte
				$("form#gg-message-form-small").html('<h2>Thanks.</h2><p>Your message has been sent to the Team Stripes moderator. The best ones will appear on the wall shortly!</p>');
				$('form#gg-message-form-small').fadeIn('slow');
			});
		}
	};
	// pass options to ajaxForm 
	$('form#gg-message-form-small').ajaxForm(options);

	
	/* Comment forms */
	var options2 = {
	    success:    function() {
	    	$('div.gg-comment-form').slideUp('slow');
	    	alert('Thanks, your comment has been sent');
		}
	};
	// pass options to ajaxForm 
	$('form.gg-message-comment-form-small').ajaxForm(options2);
	
});


function report_message($uid) {
	$.ajax({
		type: "POST",
		url: "/typo3conf/ext/gg_fanzone_messages/report-comment.php",
		data: "uid="+$uid,
		success: function(msg){
			alert("Team Stripes have been told this message has been reported. We'll take a look and see what's wrong...");
		}
	});
}