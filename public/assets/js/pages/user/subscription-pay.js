   "use strict";
   
   $('.gateway-button').on('change',function (argument) {
      $('.gateway-form').hide();
      var target = $(this).data('target');
      $(target).show();
   });