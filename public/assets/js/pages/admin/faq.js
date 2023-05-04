"use strict";

$('.edit-row').on('click',function(){
	const question = $(this).data('question');
	const answer   = $(this).data('answer');
	const language = $(this).data('lang');
	const action   = $(this).data('action');
	const position = $(this).data('position');

	$('#question').val(question);
	$('#answer').val(answer);
	$('#language').val(language);
	$('#position').val(position);
	$('.edit-modal').attr('action',action);
	
});