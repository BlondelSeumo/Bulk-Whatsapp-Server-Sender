"use strict";

$('.edit-row').on('click',function(){
	const url = $(this).data('url');
	const status = $(this).data('status');
	const action = $(this).data('action');
	const type = $(this).data('type');

	$('#url').val(url);
	$('#status').val(status);
	$('#type').val(type);
	
	$('.edit-form').attr('action',action);

});