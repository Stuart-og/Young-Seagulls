$(function(){
	$('a.submit').live('click',function(){
		$(this).closest('form').submit();
		return false;
	});
	$('form.ajax').bind('submit',function(){
		var $el =$('input[name="ajax-target"]',this);
		var action = $(this).attr('action');
		if($el.length>0) action = $el.val();
		$(this).ajaxSubmit({url:action,target:this});
		return false;
	});
	$('a.comment').live('click',function(){
		var id = $(this).attr('id');
		var $form = $("#"+id.replace("link","form"));
		$form.toggle('slide');
		return false;
	});
	$('a.ajax-link').live('click',function(){
		var href=$(this).find('link[rel="ajax-action"]').attr('href');
		if(!href) href=$(this).attr('href');
		var $resp = $(this).closest('.ajax-wrapper').find('.ajax-response');
		$resp.html("<p>Please Wait</p>");
		$resp.load(href);
		return false;
	});
});
