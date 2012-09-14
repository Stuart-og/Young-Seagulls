var TS = {
	
	base : "http://bhafc/",
	
	postToWall : function() {
		if ($("textarea#ts-wall-comment").val() != "") {
			
			var formWidth = $("div#ts-wall-comment-form-wrapper").width();
			var formHeight = $("div#ts-wall-comment-form-wrapper").height();
			
			$("div#ts-wall-comment-form-wrapper").width(formWidth);
			$("div#ts-wall-comment-form-wrapper").height(formHeight);
			
			var formData = [];
			$(':input', $("form#ts-wall-form")).each(function() {
															   
				var value = escape(this.value);
				var $this = $(this);
				if($this.is(':checkbox') && !$this.attr('checked')) value='No';
				formData.push(this.name + '=' + escape(this.value));
			});
			
			jQuery.ajax({
				data: formData.join('&'),
				url: TS.base + '/typo3conf/ext/ts_wall/postComment.php',
				error: function() {
					console.log("Failed to submit");
				},
				success: function(r) { 
					$("div#en-email-wrapper-inner").fadeOut("slow");
					setTimeout("$('div#en-email-wrapper-inner').html('<div id=\"en-purchase-form-thankyou\"><h2>Sent</h2><p>Thank you. Your email has been sent.</p></div>');", 1000);
					setTimeout("$('div#en-email-wrapper-inner').fadeIn('fast');", 1000);
				}
			});
			
			
		} else {
			// No post entered
			alert('Enter text in the field to add a post to the wall...');
		}
	},
	
	reportPost : function (reporter_id,post_id) {
		//alert(id);
		jQuery.ajax({
				//data: formData.join('&'),
				url: TS.base + '/typo3conf/ext/ts_wall/postReport.php?post_id='+post_id+'&reporter_id='+reporter_id,
				error: function() {
					console.log("Failed to submit");
				},
				success: function(r) { 
					alert('Thank you, this post has been reported and will be reviewed by a site administrator.');
				}
		});
	}
}