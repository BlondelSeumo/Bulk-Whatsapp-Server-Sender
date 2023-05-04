"use strict";

$('.edit-row').on('click',function(){
	const title = $(this).data('title');
	const slug   = $(this).data('slug');
	const comment = $(this).data('comment');
	const lang = $(this).data('lang');
	const action =   $(this).data('action');

	$('#reviewer_name').val(title);
	$('#reviewer_position').val(slug);
	$('#star').val(lang);
	$('#comment').val(comment);

	$('.edit-modal').attr('action',action);
	
});