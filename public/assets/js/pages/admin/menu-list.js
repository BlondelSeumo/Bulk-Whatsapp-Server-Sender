"use strict";

$('.edit-contact').on('click',function(){
	const name = $(this).data('name');
	const position = $(this).data('position');
	const language = $(this).data('lang');
	const status = $(this).data('status');
	const action = $(this).data('action');

	$('#name').val(name);
	$('#position').val(position);
	$('#language').val(language);
	$('#status').val(status);

	$('.edit-modal').attr('action',action);
	
});