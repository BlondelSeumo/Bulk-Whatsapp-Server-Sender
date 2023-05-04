"use strict";

$('.edit-row').on('click',function(){
	const title = $(this).data('title');
	const description   = $(this).data('description');
	const language = $(this).data('lang');
	const action =   $(this).data('action');

	$('#title').val(title);
	$('#description').val(description);
	$('#language').val(language);
	$('.edit-modal').attr('action',action);
	
});