"use strict";	

	$(document).on('click','.send_now',function(){
		var forms = $('.bulk_form').length;
	
		if (forms > 0) {
			$('.send_now').attr('disabled','disable');
			
			$('.bulk_form').each(function(){
				$(this).submit();
			})
		}
		else{
			$('.send_now').removeAttr('disabled');
			ToastAlert('error', 'No Record Avaible For Sent A Request');
		}

	});

	$(document).on('click','.delete-form',function(){		
		const row= $(this).data('action');
		$(row).remove();
		
		var totalRecords = $('#total_records').text();
		totalRecords = parseInt(totalRecords)
		totalRecords = totalRecords-1;
		$('.total_records').html(parseInt(totalRecords))
	});

	$('.send-message').on('click',function(){
		var formclass = $(this).data('form');
		$(formclass).submit();
	});

	$('.bulk_form').on('submit',function(e){
		 e.preventDefault();
		 $.ajaxSetup({
		 	headers: {
		 		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		 	}
		 });

		 let $savingLoader = 'Please wait...';

		 let $this = $(this);
		 let $submitBtn = $this.find('.submit-button');
		 let $oldSubmitBtn = $submitBtn.html();
		 const key = $(this).data('key');


		 
		 	$.ajax({
		 		type: 'POST',
		 		url: this.action,
		 		data: new FormData(this),
		 		dataType: 'json',
		 		contentType: false,
		 		cache: false,
		 		processData: false,
		 		beforeSend: function () {
		 			$submitBtn.html($savingLoader).attr('disabled', true);
		 			$('.badge_'+key).html('Sending.....')
		 		},
		 		success: function (res) {
		 			$submitBtn.html($oldSubmitBtn).attr('disabled', false);
		 			$('.badge_'+key).html('Sent 🚀');
		 			
		 			$('.badge_'+key).removeClass('badge-warning');
		 			$('.badge_'+key).addClass('badge-success');
		 			$('.badge_'+key).removeClass('sendable');
		 			$('.badge_'+key).addClass('msg-sent');
		 			$('.badge_'+key).removeClass('faild-form');
		 			
		 			var totalSent = $('.msg-sent').length;
		 			$('.total_sent').html(totalSent);
		 			NotifyAlert('success', res);
		 		},
		 		error: function (xhr) {
		 			$submitBtn.html($oldSubmitBtn).attr('disabled', false);
		 			showInputErrors(xhr.responseJSON);
		 			$('.badge_'+key).html('Sending Faild');
		 			$('.badge_'+key).addClass('badge-danger');
		 			$('.badge_'+key).addClass('faild-form');

		 			$('.total-faild').html($('.faild-form').length);
		 			NotifyAlert('error', xhr);
		 		}
		 	});
		 
	});