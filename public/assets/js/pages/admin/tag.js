"use strict";

$('.edit-row').on('click',function(){
	const title = $(this).data('title');
	const slug = $(this).data('slug');
	const lang = $(this).data('lang');
	const status = $(this).data('status');
	const action = $(this).data('action');

	$('#title').val(title);
	$('#slug').val(slug);
	$('#lang').val(lang);
	$('#status').val(status);

	$('.edit-form').attr('action',action);
	
});