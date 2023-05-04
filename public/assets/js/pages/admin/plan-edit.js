"use strict";

$('#iconpicker').on('change', function(e){
    $('#icon-name').val(e.icon);
});

$('#is-trial').on('change',function(){
    var target_action = $(this).data('target');
    $(this).is(':checked') ? $(target_action).show() : $(target_action).hide();
});