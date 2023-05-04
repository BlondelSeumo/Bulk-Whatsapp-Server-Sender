"use strict";

const device_id = $('#uuid').val();
const base_url  = $('#base_url').val();
const whatsappicon = base_url+'/assets/img/whatsapp.png';

checkSession();

function checkSession() {

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		type: 'POST',
		url: base_url+'/user/check-session/'+device_id,
		dataType: 'json',
		success: function(response) {
			if (response.connected === true) {
				$('.server_disconnect').remove();
				$('.qr-area').remove();

				NotifyAlert('success', null, response.message);
				getChatList();

			}
			else{
				NotifyAlert('error', null, 'device not ready for sending message');
			}
		},
		error: function(xhr, status, error) {
			if (xhr.status == 500) {
				const image=`<img src="${base_url}/uploads/disconnect.webp" class="w-50"><br>`;
				$('.qr-area').html(image);
				$('.server_disconnect').show();
			}

		}
	});
}

function getChatList() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		type: 'POST',
		url: base_url+'/user/get-chats/'+device_id,
		dataType: 'json',
		success: function(response) {
			const chats = sortByKey(response.chats,'timestamp');
			$('.qr-area').remove();

			$.each(response.chats, function (key, item) {

				if (item.timestamp > 0) {
					var time = formatTimestamp(item.timestamp);
					time = `<span class="text-success">${time}</span>`;
				}
				else{
					var time='';
				}

				var html = `<li class="list-group-item px-0 contact contact${key}">
				<div class="row align-items-center">
				<div class="col-auto">
				<a href="javascript:void(0)" data-active=".contact${key}" data-number="${item.number}" class="avatar rounded-circle wa-link ml-2">
				<img alt="" src="${whatsappicon}">
				</a>
				</div>
				<div class="col ml--2">
				<h4 class="mb-0">
				<a href="javascript:void(0)" data-active=".contact${key}" class="wa-link" data-number="${item.number}">+${item.number}</a>
				</h4>
				${time}
				</div>
				</div>
				</li>`;

				$('.contact-list').append(html);
			});


		},
		error: function(xhr, status, error) {
			if (xhr.status == 500) {

			}

		}
	});
}


function successCallBack() {
	$('#plain-text').val('');
}


$(document).on('click','.wa-link',function(){
	const phone = $(this).data('number');
	const activeTarget = $(this).data('active');

	$('.contact').removeClass('active');
	$(activeTarget).addClass('active');
	$('.chat-list').html(phone);
	$('.sendble-row').removeClass('none');
	$('.reciver-number').val(phone);

});

$(document).on('change','#select-type',function(){
	var type = $(this).val();


	if (type == 'plain-text') {
		$('#plain-text').show();
		$('#templates').hide();
	}
	else{
		$('#plain-text').hide();
		$('#templates').show();
	}


});

function sortByKey(array, key) {
	return array.sort(function(a, b) {
		var x = a[key]; var y = b[key];
		return ((x > y) ? -1 : ((x < y) ? 1 : 0));
	});
}

function formatTimestamp(unixTimestamp) {

	    var d=new Date();  // Gets the current time
	    var nowTs = Math.floor(d.getTime()/1000); //
	    var seconds = nowTs-unixTimestamp;

	    // more that two days
	    if (seconds > 2*24*3600) {
	    	return "a few days ago";
	    }
	    // a day
	    if (seconds > 24*3600) {
	    	return "yesterday";
	    }

	    if (seconds > 3600) {
	    	return "a few hours ago";
	    }
	    if (seconds > 1800) {
	    	return "Half an hour ago";
	    }
	    if (seconds > 60) {
	    	return Math.floor(seconds/60) + " minutes ago";
	    }

	    return "Few seconds ago";

	}