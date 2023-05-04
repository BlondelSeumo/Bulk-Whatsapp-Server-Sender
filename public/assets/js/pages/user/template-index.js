"use strict";

$('.show-id').on('click',function(){
	const uuid= $(this).data('uuid');
	const templateName= $(this).data('templatename');

	$('#templateid').val(uuid);
	$('#templateName').html(templateName);
});