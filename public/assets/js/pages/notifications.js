"use strict";

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.ajax({
    type: 'POST',
    url: '/user/notifications',
    
    dataType: 'json',
    contentType: false,
    cache: false,
    processData: false,
    
    success: function (res) {
       $('.notification-count').html(res.notifications_unread);
       
       $(res.notifications).each(function(index, row){  
          var html  = `<a href="${row.url}" class="list-group-item list-group-item-action">
                        <div class="row align-items-center">
                           
                           <div class="col ml-2">
                              <div class="d-flex justify-content-between align-items-center">
                                 <div>
                                    <h4 class="mb-0 text-sm">${row.title}</h4>
                                 </div>
                                 <div class="text-right text-muted">
                                    <small>${row.created_at}</small>
                                 </div>
                              </div>
                              <p class="text-sm mb-0">${row.comment != null ? row.comment : ''}</p>
                           </div>
                        </div>
                     </a>`;  

         $('.notifications-list').append(html);

       });

       res.notifications.length > 0 ? $('.notifications-area').show() :  $('.notifications-area').hide(); 
    },
    error: function (xhr) {
       
    }
});