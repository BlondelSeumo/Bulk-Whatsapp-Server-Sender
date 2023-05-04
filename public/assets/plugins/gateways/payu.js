"use strict";

$('#payment_form').on('submit',function(e){
    e.preventDefault();
    launchBOLT();
});    


launchBOLT();
  function launchBOLT() {
    var salt = $('#salt').val();
    var surl = $('#surl').val();
    bolt.launch({
        key: $('#key').val(),
        txnid: $('#txnid').val(),
        hash: $('#hash').val(),
        amount: $('#amount').val(),
        firstname: $('#firstname').val(),
        email: $('#email').val(),
        phone: $('#mobile').val(),
        productinfo: $('#productinfo').val(),
        udf5: $('#udf5').val(),
        surl: $('#surl').val(),
        furl: $('#surl').val(),
        mode: 'dropout'
    }, {
        responseHandler: function(BOLT) {
           
            if (BOLT.response.txnStatus != 'CANCEL') {
                        // Salt is passd here for demo purpose only. For practical use keep salt at server side only.
                        var fr = '<form action=\"' + surl + '\" method=\"post\">' +
                        '<input type=\"hidden\" name=\"key\" value=\"' + BOLT.response.key + '\" />' +
                        '<input type=\"hidden\" name=\"salt\" value=\"' + salt + '\" />' +
                        '<input type=\"hidden\" name=\"txnid\" value=\"' + BOLT.response.txnid + '\" />' +
                        '<input type=\"hidden\" name=\"amount\" value=\"' + BOLT.response.amount + '\" />' +
                        '<input type=\"hidden\" name=\"productinfo\" value=\"' + BOLT.response.productinfo +
                        '\" />' +
                        '<input type=\"hidden\" name=\"firstname\" value=\"' + BOLT.response.firstname +
                        '\" />' +
                        '<input type=\"hidden\" name=\"email\" value=\"' + BOLT.response.email + '\" />' +
                        '<input type=\"hidden\" name=\"udf5\" value=\"' + BOLT.response.udf5 + '\" />' +
                        '<input type=\"hidden\" name=\"mihpayid\" value=\"' + BOLT.response.mihpayid +
                        '\" />' +
                        '<input type=\"hidden\" name=\"status\" value=\"' + BOLT.response.status + '\" />' +
                        '<input type=\"hidden\" name=\"hash\" value=\"' + BOLT.response.hash + '\" />' +
                        '</form>';
                        var form = jQuery(fr);
                        jQuery('body').append(form);
                        form.submit();
                    }
                },
                catchException: function(BOLT) {
                    alert(BOLT.message);
                }
            });
}