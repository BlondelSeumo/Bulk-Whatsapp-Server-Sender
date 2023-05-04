"use strict"
$.fn.initFormValidation = function () {
        var validator = $(this).validate({
            errorClass: 'is-invalid',
            highlight: function (element, errorClass) {
                var elem = $(element);
                if (elem.hasClass("select2-hidden-accessible")) {
                    $("#select2-" + elem.attr("id") + "-container").parent().addClass(errorClass);
                } else if (elem.hasClass('input-group')) {
                    $('#' + elem.add("id")).parents('.input-group').append(errorClass);
                } else if (elem.parents().hasClass('image-checkbox')){
                    NotifyAlert('error', null, elem.parent().data('required'))
                }else {
                    elem.addClass(errorClass);
                }
            },
            unhighlight: function (element, errorClass) {
                var elem = $(element);
                if (elem.hasClass("select2-hidden-accessible")) {
                    $("#select2-" + elem.attr("id") + "-container").parent().removeClass(errorClass);
                } else {
                    elem.removeClass(errorClass);
                }
            },
            errorPlacement: function (error, element) {
                var elem = $(element);
                if (elem.hasClass("select2-hidden-accessible")) {
                    element = $("#select2-" + elem.attr("id") + "-container").parent();
                    error.insertAfter(element);
                } else if (elem.parents().hasClass('image-checkbox')){

                } else if (elem.parent().hasClass('form-floating')) {
                    error.insertAfter(element.parent().css('color', 'text-danger'));
                } else if (elem.parent().hasClass('input-group')) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });

        $(this).on('select2:select', function () {
            if (!$.isEmptyObject(validator.submitted)) {
                validator.form();
            }
        });
    };

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

let $savingLoader = '<div class="spinner-border spinner-border-sm" role="status">' +
    '<span class="visually-hidden">Loading...</span>' +
    '</div>';

let $ajaxform = $('.ajaxform');
$ajaxform.initFormValidation();

$(document).on('submit', '.ajaxform', function (e) {
    e.preventDefault();

    let $this = $(this);
    let $submitBtn = $this.find('.submit-button');
    let $oldSubmitBtn = $submitBtn.html();

    if ($ajaxform.valid()) {
        $.ajax({
            type: 'POST',
            url: this.action,
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $submitBtn.html('Sending...').attr('disabled', true);
            },
            success: function (res) {
                $submitBtn.html($oldSubmitBtn).attr('disabled', false);

                NotifyAlert('success', res);
                successCallBack();
            },
            error: function (xhr) {
                $submitBtn.html($oldSubmitBtn).attr('disabled', false);
                NotifyAlert('error', xhr.responseJSON);
                showInputErrors(xhr.responseJSON);
            }
        });
    }
});

// Show Success Message After Page Reload
let $ajaxform_instant_reload = $('.ajaxform_instant_reload');
$ajaxform_instant_reload.initFormValidation();

$(document).on('submit', '.ajaxform_instant_reload', function (e) {
    e.preventDefault();

    let $this = $(this);
    let $submitBtn = $this.find('.submit-btn');
    let $oldSubmitBtn = $submitBtn.html();

    if ($ajaxform_instant_reload.valid()) {
        $.ajax({
            type: 'POST',
            url: this.action,
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $submitBtn.html($savingLoader).addClass('disabled').attr('disabled', true);
            },
            success: function (res) {
                $submitBtn.html($oldSubmitBtn).removeClass('disabled').attr('disabled', false);
                window.sessionStorage.hasPreviousMessage = true;
                window.sessionStorage.previousMessage = res.message ?? null;

                if (res.redirect) {
                    location.href = res.redirect;
                }
            },
            error: function (xhr) {
                $submitBtn.html($oldSubmitBtn).removeClass('disabled').attr('disabled', false);
                NotifyAlert('error', xhr.responseJSON);
                showInputErrors(xhr.responseJSON);
            }
        });
    }
});


// Show Success Message After Page Reload
let $ajaxform_instant_reload_after_confirm = $('.ajaxform_instant_reload_after_confirm');
$ajaxform_instant_reload_after_confirm.initFormValidation();

$(document).on('submit', '.ajaxform_instant_reload_after_confirm', function (e) {
    e.preventDefault();

    let $this = $(this);
    let $submitBtn = $this.find('.submit-btn');
    let $oldSubmitBtn = $submitBtn.html();

    if ($ajaxform_instant_reload_after_confirm.valid()) {
        let icon = $(this).find('.submit-btn').data('icon') ?? 'fas fa-warning';
        let action = this.action
        let formData = new FormData(this)

        $.confirm({
            title:"Heads Up!",
            icon: icon,
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'red',
            scrollToPreviousElement: false,
            scrollToPreviousElementAnimate: false,
            buttons: {
                confirm: {
                    btnClass: 'btn-red',
                    action: function () {
                        event.preventDefault();
                        let btnThis = this;
                        $.ajax({
                            type: 'POST',
                            url: action,
                            data: formData,
                            dataType: 'json',
                            contentType: false,
                            cache: false,
                            processData: false,
                            beforeSend: function () {
                                $submitBtn.html($savingLoader).addClass('disabled').attr('disabled', true);
                                btnThis.buttons.close.hide()
                            },
                            success: function (res) {
                                $submitBtn.html($oldSubmitBtn).removeClass('disabled').attr('disabled', false);
                                window.sessionStorage.hasPreviousMessage = true;
                                window.sessionStorage.previousMessage = res.message ?? null;

                                if (res.redirect) {
                                    location.href = res.redirect;
                                }
                            },
                            error: function (xhr) {
                                $submitBtn.html($oldSubmitBtn).removeClass('disabled').attr('disabled', false);
                                NotifyAlert('error', xhr.responseJSON, null, xhr.responseJSON.url ?? null);
                                showInputErrors(xhr.responseJSON);
                            }
                        });
                    }
                },
                close: {
                    action: function () {
                        this.buttons.close.hide()
                    }
                }
            },
        });
    }
});

// Reset The form after success response
let $ajaxform_reset_form = $('.ajaxform_reset_form');
$ajaxform_reset_form.initFormValidation();

$(document).on('submit', '.ajaxform_reset_form', function (e) {
    e.preventDefault();

    let $this = $(this);
    let $submitBtn = $this.find('.submit-button');
    let $oldSubmitBtn = $submitBtn.html();

    if ($ajaxform_reset_form.valid()) {
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
            },
            success: function (res) {
                $submitBtn.html($oldSubmitBtn).attr('disabled', false);

                $this.trigger('reset');
                NotifyAlert('success', res);
            },
            error: function (xhr) {
                $submitBtn.html($oldSubmitBtn).attr('disabled', false);
              
                NotifyAlert('error', xhr.responseJSON);
            }
        });
    }
});


// form submit with next page


$(document).on('submit', '.ajaxform_next_page', function (e) {
    let $this = $(this);
    let $submitBtn = $this.find('.submit-button');
    let $oldSubmitBtn = $submitBtn.html();

    $submitBtn.html('Please').attr('disabled', true);

});


function NotifyAlert(type, res, msg = null, destination = null) {
    var background;
    var message;
    var redirect;
   

    switch (type) {
        case "error":
            background = "radial-gradient(circle at 10% 50.5%, rgb(255, 107, 6) 0%, rgb(255, 1, 107) 90%)";
            message = msg ?? res.message ?? res.responseText ?? 'Oops! Something went wrong';
            destination = destination ?? redirect ?? null;
            break;
        case "success":
            background = "linear-gradient(to right, rgb(0, 176, 155), rgb(150, 201, 61))";
            message = msg ?? res.message ?? 'Congratulate! Operation Successful.';
            destination = destination ?? redirect ?? null;
            break;
        case "warning":
            background = "linear-gradient(135deg, rgb(252, 207, 49) 10%, rgb(245, 85, 85) 100%)";
            message = msg ?? res.message ?? res.responseJSON.message ?? 'Warning! Operation Failed.';
            destination = destination ?? redirect ?? null;
            break;
        default:

    }
    Toastify({
        text: message,
        destination: destination,
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        style: {
            background: background,
        }
    }).showToast();
}


function ToastAlert(type, res){
    var background;
    var message;
    var redirect;

    switch (type) {
        case "error":
            background  = "radial-gradient(circle at 10% 50.5%, rgb(255, 107, 6) 0%, rgb(255, 1, 107) 90%)";
            message     = res ?? 'Oops! Something went wrong';
           
            break;
        case "success":
            background  = "linear-gradient(to right, rgb(0, 176, 155), rgb(150, 201, 61))";
            message     = res ?? 'Congratulate! Operation Successful.';
           
            break;
        case "warning":
            background  = "linear-gradient(135deg, rgb(252, 207, 49) 10%, rgb(245, 85, 85) 100%)";
            message     =    res ?? 'Warning! Operation Failed.';
           
            break;
        default:

    }
    Toastify({
        text: message,
        destination: null,
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        style: {
            background: background,
        }
    }).showToast();
}

function congratulations() {
    var count = 200;
    var defaults = {
      origin: { y: 0.7 }
  };

  function fire(particleRatio, opts) {
      confetti(Object.assign({}, defaults, opts, {
        particleCount: Math.floor(count * particleRatio)
    }));
  }

  fire(0.25, {
      spread: 26,
      startVelocity: 55,
  });
  fire(0.2, {
      spread: 60,
  });
  fire(0.35, {
      spread: 100,
      decay: 0.91,
      scalar: 0.8
  });
  fire(0.1, {
      spread: 120,
      startVelocity: 25,
      decay: 0.92,
      scalar: 1.2
  });
  fire(0.1, {
      spread: 120,
      startVelocity: 45,
  });


}

function congratulationsPride() {
   var end = Date.now() + (1 * 1000);
   var colors = ['#825ee4', '#5e72e4'];

   (function frame() {
      confetti({
        particleCount: 2,
        angle: 60,
        spread: 55,
        origin: { x: 0 },
        colors: colors
    });
      confetti({
        particleCount: 2,
        angle: 120,
        spread: 55,
        origin: { x: 1 },
        colors: colors
    });

      if (Date.now() < end) {
        requestAnimationFrame(frame);

    }
}());
}

$('.init_form_validation').initFormValidation();

  /*----------------------------
        Jquery Live Search
      ------------------------------*/

$('.filter-row').on('keyup', function(){  
    var target = $(this).data('target');
    var value = $(this).val();

    search_table(value,target);  
});  
function search_table(value,target){  
    $(target).each(function(){  
        var found = 'false';  
        $(this).each(function(){  
          if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0) {  
            found = true;  
          }  
        });  
        
        if(found == true) {  
          $(this).show();  
        }  
        else {  
          $(this).hide();  
        }  
  });  
} 

/*-------------------------------
    Delete Confirmation Alert
    -----------------------------------*/
    $('.delete-confirm').on('click', function(event) {
        let url = $(this).data('action');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    success: function(response){
                        if (response.redirect){
                            if (response.message){
                                NotifyAlert('success', response)
                            }

                            window.location.href = response.redirect;
                        }else{
                            NotifyAlert('success', null, response)
                        }
                    },
                    error: function(xhr, status, error)
                    {
                        NotifyAlert('error', xhr)
                    }
                })
            }
        })
    });

    $('.action-confirm').on('click', function(event) {
        let url = $(this).data('action');
        let text = $(this).data('text');
        let icon = $(this).data('icon');
        Swal.fire({
            title: 'Are you sure?',
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes confirm!'
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response){
                        if (response.redirect){
                            if (response.message){
                                NotifyAlert('success', response)
                            }
                            window.location.href = response.redirect;
                        } else {
                            NotifyAlert('success', null, response)
                        }
                    },
                    error: function(xhr, status, error)
                    {
                        NotifyAlert('error', xhr)
                    }
                })
            }
        })
    });

/*-------------------------------
  Action Confirmation Alert
-----------------------------------*/
$(document).on('click', '.confirm-action', function(event) {
        var url = $(this).data('action');
        var method = $(this).data('method') ?? 'POST'
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to do this?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#6777ef',
            cancelButtonColor: '#fc544b',
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                $.ajax({
                    type: method,
                    url: url,
                    success: function(response){
                        success(response)
                    },
                    error: function(xhr, status, error)
                    {
                        error_response(xhr)
                    }
                })
            }
        })
});

$(document).on('click', '.logout-button', function(e) {
    e.preventDefault();
    $('#logout-form').submit();
});

$(".checkAll").on('click',function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
});

$('.group-input').on('click',function(){
    checkPermissionByGroup($(this).data('class'),this);
});

$('#disk-method').on('change',function(){

    $(this).val() == 'wasabi' ? $('.wasabi').show() : $('.wasabi').hide(); 

});

function checkPermissionByGroup(className, checkThis){
  
    const groupIdName = $("#"+checkThis.id);
    const classCheckBox = $('.'+className+' input');
    if(groupIdName.is(':checked')){
            classCheckBox.prop('checked', true);
    }else{
        classCheckBox.prop('checked', false);
    }
}