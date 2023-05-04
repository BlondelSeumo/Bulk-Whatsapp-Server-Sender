"use strict";

$('.reply_type').on('change',function(){
		
		if ($(this).val() == 'text') {
			$('.text-area').show();
			$('.templates').hide();
		}
		else{
			$('.text-area').hide();
			$('.templates').show();
		}
});

$('.edit-reply').on('click',function(){

		const action = $(this).data('action');
		const templateid = $(this).data('templateid');
		const reply = $(this).data('reply');
		const matchtype = $(this).data('matchtype');
		const replytype = $(this).data('replytype');
		const keyword = $(this).data('keyword');
		const device = $(this).data('device');

		$('.edit-reply-form').attr('action',action);
		$('#templateid').val(templateid);
		$('#reply').val(reply);
		$('#matchtype').val(matchtype);
		$('#replytype').val(replytype);
		$('#keyword').val(keyword);
		$('#device').val(device);

		if (replytype == 'text') {
			$('#reply-area').show();
			$('#templates-area').hide();
		}
		else{
			$('#reply-area').hide();
			$('#templates-area').show();
		}

});