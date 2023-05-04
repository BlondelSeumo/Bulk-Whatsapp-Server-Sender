   "use strict";
   
   const base_url  = $('#base_url').val();
  
   $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
   });

   $.ajax({
    type: 'POST',
    url: base_url+'/user/device-statics',
    dataType: 'json',
    success: function(response) {
        $('#total-device').html(response.total);
        $('#total-inactive').html(response.inActive);
        $('#total-active').html(response.active);
    }
   });