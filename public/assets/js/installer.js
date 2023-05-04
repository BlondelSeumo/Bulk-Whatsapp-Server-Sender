"use strict";

let $installer_form_instant_reload = $('.installer_form_instant_reload');
var attampt = 0;
$installer_form_instant_reload.initFormValidation();

$(document).on('submit', '.installer_form_instant_reload', function (e) {
    e.preventDefault();

    let $this = $(this);
    let $submitBtn = $this.find('.submit-btn');
    let $oldSubmitBtn = $submitBtn.html();

    if ($installer_form_instant_reload.valid()) {
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
                $('.waiting-bar').removeClass('hide');
                $('.waiting-bar').addClass('show');
                $('.waiting-bar').show();

            },
            success: function (res) {
                $('#install-migrate').submit();
            },
            error: function (xhr) {
                if (attampt == 0) {
                    attampt=attampt+1;
                    $('.installer_form_instant_reload').submit();
                }
                else{
                    $('.submit-btn').html('<span class="mb-1">Submit &amp; Next</span><i class="fi  fi-rs-angle-right text-right mt-5"></i>').removeClass('disabled').attr('disabled', false);
                    NotifyAlert('error', xhr.responseJSON);
                    Swal.fire(
                       'Opps!',
                       'Could not connect to the database.  Please check your configuration',
                       'error'
                       )
                    $('.waiting-bar').removeClass('show');
                    $('.waiting-bar').addClass('hide');
                    $('.waiting-bar').hide(); 
                }
                
            }
        });
    }
});

$(document).on('submit', '#install-migrate', function (e) {
    e.preventDefault();

    let $this = $('.installer_form_instant_reload');
    let $submitBtn = $this.find('.submit-btn');
    let $oldSubmitBtn = $submitBtn.html();

   
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
                $('.waiting-bar').removeClass('hide');
                $('.waiting-bar').addClass('show');
                $('.waiting-bar').show();

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
                if (attampt == 0) {
                    attampt=attampt+1;
                    $('.installer_form_instant_reload').submit();
                }
                else{
                    $('.submit-btn').html('<span class="mb-1">Submit &amp; Next</span><i class="fi  fi-rs-angle-right text-right mt-5"></i>').removeClass('disabled').attr('disabled', false);
                    NotifyAlert('error', xhr.responseJSON);
                    Swal.fire(
                       'Opps!',
                       'Could not connect to the database.  Please check your configuration',
                       'error'
                       )
                    $('.waiting-bar').removeClass('show');
                    $('.waiting-bar').addClass('hide');
                    $('.waiting-bar').hide(); 
                }
                
            }
        });
    
});

var successExist = $('.success-alert').length;

successExist > 0 ? congratulations() : '';
successExist > 0 ? congratulationsPride() : '';