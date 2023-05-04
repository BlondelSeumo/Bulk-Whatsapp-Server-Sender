"use strict";
$('.message_type').on('change',function(){
	var val=$(this).val();
	if (val == 'text') {
		$('.templates-list').hide();
		$('.plain-text').show();
	}
	else{
		$('.templates-list').show();
		$('.plain-text').hide();
	}
	
});

$('#selectall').on('change',function(){
	if ($(this).is(':checked')) {
		
		$('.receivers').hide();
	}
	else{
		$('.receivers').show();
	}

});