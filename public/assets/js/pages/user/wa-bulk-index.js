"use strict";

$('.select2').select2();
$('.save-template').on('change',function(){
   if ($(this).is(':checked')) {
       $('.receivers').hide();
       $('.bulk_send_form').addClass('ajaxform_instant_reload');
       $('.bulk_send_form').removeClass('ajaxform');
   }else{

       $('.bulk_send_form').removeClass('ajaxform_instant_reload');
       $('.bulk_send_form').addClass('ajaxform');
       $('.receivers').show()
   }  

});