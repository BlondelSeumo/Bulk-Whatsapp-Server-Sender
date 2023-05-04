 "use strict";

var successExist = $('.success-alert').length;

successExist > 0 ? congratulations() : '';
successExist > 0 ? congratulationsPride() : '';


loadStaticData();
var messagesTransactionDays=[];
var messagesTransactionValues=[];


function loadStaticData() {
  const url = $('#static-data').val();
  const base_url = $('#base_url').val();

  $.ajax({
    type: 'get',
    url: url,
    dataType: 'json',
    contentType: false,
    cache: false,
    processData:false,

    success: function(response){ 
      $('#total-device').html(response.devicesCount);
      $('#total-messages').html(response.messagesCount);
      $('#total-contacts').html(response.contactCount);
      $('#total-schedule').html(response.scheduleCount);
      
      
      $.each(response.devices, function(index, value){

        const device = `<li class="list-group-item px-0">
                          <div class="row align-items-center">
                            <div class="col ml--2">
                              <h4 class="mb-0">
                                <a href="${base_url}/user/device/${value.uuid}/qr">${value.name} ${value.phone != null ? '('+value.phone+')' : ''}</a>
                              </h4>
                              <span class="text-${value.status == 1 ? 'success' : 'danger'}">●</span>
                              <small>${value.status == 1 ? 'Online' : 'offline'}</small>
                            </div>
                            <div class="col-auto">
                              (${value.smstransaction_count} Messages)
                            </div>
                          </div>
                        </li>`;                
      $('#device-list').append(device)

      });

      $.each(response.messagesStatics, function(index, value){
        var dat=value.date;
        var transaction=value.smstransactions;

        messagesTransactionDays.push(dat);
        messagesTransactionValues.push(transaction);
      });
      initMessage(); 


      var chatbotReplyDate=[];
      var chatbotReplyCount=[];

      $.each(response.chatbotStatics,function(index, value){
          chatbotReplyDate.push(value.date);
          chatbotReplyCount.push(value.smstransactions);
      });

     initChatbotChart(chatbotReplyDate,chatbotReplyCount);

      var types=[];
      var typeCount=[];

      $.each(response.typeStatics,function(index, value){
          types.push(value.type);
          typeCount.push(value.smstransactions);
      });

     initMessagesTypes(types,typeCount)
      
    }
  });


}

$('#period').on('change',function(){
  var days= $(this).val();
  const base_url = $('#base_url').val();
  const url = base_url+'/user/messages-transaction/'+days;
  $.ajax({
    type: 'get',
    url: url,
    dataType: 'json',
    contentType: false,
    cache: false,
    processData:false,

    success: function(response){ 
      messagesTransactionDays=[];
      messagesTransactionValues=[];

      $.each(response.messagesStatics, function(index, value){
        var dat=value.date;
        var transaction=value.smstransactions;

        messagesTransactionDays.push(dat);
        messagesTransactionValues.push(transaction);
      });
      initMessage(); 


      
    }
  });

});


$('#automaticReply').on('change',function(){
  var   days     = $(this).val();
  const base_url = $('#base_url').val();
  const url      = base_url+'/user/chatbot-transaction/'+days;
 
  $.ajax({
    type: 'get',
    url: url,
    dataType: 'json',
    contentType: false,
    cache: false,
    processData:false,

    success: function(response){ 
      var chatbotReplyDate=[];
      var chatbotReplyCount=[];

      $.each(response,function(index, value){
          chatbotReplyDate.push(value.date);
          chatbotReplyCount.push(value.smstransactions);
      });

     initChatbotChart(chatbotReplyDate,chatbotReplyCount);
    }
  });
});

$('#messagesTypes').on('change',function(){
  var   days     = $(this).val();
  const base_url = $('#base_url').val();
  const url      = base_url+'/user/messages-types-transaction/'+days;
 
  $.ajax({
    type: 'get',
    url: url,
    dataType: 'json',
    contentType: false,
    cache: false,
    processData:false,

    success: function(response){ 
      var types=[];
      var typeCount=[];

      $.each(response.typeStatics,function(index, value){
          types.push(value.type);
          typeCount.push(value.smstransactions);
      });

     initMessagesTypes(types,typeCount)
    }
  });

});

function initMessage() {
  var $chart = $('#chart-sales');
  var salesChart = new Chart($chart, {
    type: 'line',
    options: {
      scales: {
        yAxes: [{
          gridLines: {
            color: Charts.colors.gray[200],
            zeroLineColor: Charts.colors.gray[200]
          },
          ticks: {

          }
        }]
      }
    },
    data: {
      labels: messagesTransactionDays,
      datasets: [{
        label: 'Messages',
        data: messagesTransactionValues
      }]
    }
  });
  $chart.data('chart', salesChart);
}





  


  function initChatbotChart(days, values) {
    var $chart = $('#chart-bars');

    // Create chart
    var ordersChart = new Chart($chart, {
      type: 'bar',
      data: {
        labels: days,
        datasets: [{
          label: 'Replies',
          data: values
        }]
      }
    });

    // Save to jQuery object
    $chart.data('chart', ordersChart);
  }





  // Methods

  function initMessagesTypes(types, values) {

    var $chart = $('#chart-doughnut');

    var doughnutChart = new Chart($chart, {
      type: 'doughnut',
      data: {
        labels: types,
        datasets: [{
          data: values,
          backgroundColor: [
            Charts.colors.theme['danger'],
            Charts.colors.theme['warning'],
            Charts.colors.theme['success'],
            Charts.colors.theme['primary'],
            Charts.colors.theme['info'],
          ],
          label: 'Dataset 1'
        }],
      },
      options: {
        responsive: true,
        legend: {
          position: 'top',
        },
        animation: {
          animateScale: true,
          animateRotate: true
        }
      }
    });

    // Save to jQuery object

    $chart.data('chart', doughnutChart);

  };