	"use strict";
	const base_url = $('#base_url').val();

	loadStaticData();
	loadOverViewOfEarning();
	serverStatus();


	

	$('.overview-list').on('click',function(){
		var html = $(this).data('type');

		$('.overview-target').html(html);

		loadOverViewOfEarning();
	});

function loadStaticData() {
    const url = $('#static-data').val();

	  $.ajax({
	    type: 'get',
	    url: url,
	    dataType: 'json',
	    contentType: false,
	    cache: false,
	    processData:false,

	    success: function(response){ 
	      $('#total-orders').html(response.orders);
	      $('#pending-orders').html(response.pending_order);
	      $('#open-support').html(response.open_support);
	      $('#active-customers').html(response.active_user);
	      $('#active-devices').html(response.active_device);
	      $('#junk-devices').html(response.junk_device);
	      $('#pending-tickets').html(response.pending_support);
	      $('#todays-messages').html(response.todays_messages);
	      $('#new-users').html(response.todays_user);
	      printRecentOrders(response.recent_orders)
	      printPupularPlan(response.popular_plans)
	      
	      
	    }
	 });
}

function loadSalesOverView() {
    const url = $('#static-data').val();

	  $.ajax({
	    type: 'get',
	    url: url,
	    dataType: 'json',
	    contentType: false,
	    cache: false,
	    processData:false,

	    success: function(response){ 
	      $('#total-orders').html(response.orders);
	      $('#pending-orders').html(response.pending_order);
	      $('#open-support').html(response.open_support);
	      $('#active-customers').html(response.active_user);
	      $('#active-devices').html(response.active_device);
	      $('#junk-devices').html(response.junk_device);
	      $('#pending-tickets').html(response.pending_support);
	      $('#todays-messages').html(response.todays_messages);
	      $('#new-users').html(response.todays_user);
	      printRecentOrders(response.recent_orders)
	      printPupularPlan(response.popular_plans)
	      
	      
	    }
	 });
}


function loadOverViewOfEarning() {
	var range = $('.overview-target').html();
	
	 $.ajax({
	    type: 'get',
	    url: base_url+'/admin/sales-overview',
	    dataType: 'json',
	    data: {type: range},
	    
	    success: function(response){ 
	    	var dates=[];
	    	var values=[];

	    	$.each(response.orders,function(index, value){
	    		dates.push(value.date);
	    		values.push(value.amount);
	    	});

	    	initChart(dates,values);
	      
	    }
	 });
}


function printRecentOrders(data) {
	
	$.each(data, function(key, row){

		var html = `<li class="list-group-item px-0">
						<div class="row align-items-center">
							<div class="col-auto">
								<!-- Avatar -->
								<a href="${row.link}" class="avatar rounded-square">
									<img alt="Image placeholder" src="${row.avatar}" height="40">
								</a>
							</div>
							<div class="col ml--2">
								<h4 class="mb-0">
									<a href="${row.link}">${row.invoice}</a>
								</h4>
								
								<small class="text-muted">${row.plan}</small>
							</div>
							<div class="col-auto text-right">
								<span class="text-right">${row.amount}</span>
								<br>
								<span class="text-muted"><i class="fi fi-rs-clock pt-1"></i> <span class="ml-1">${row.created_at}</span></span>
							</div>
						</div>
					</li>`;

		$('.recent-order-list').append(html);
	});

}

function printPupularPlan(data) {
	$.each(data, function(key, row){

		var html = `<tr>
						<th scope="row">
							<div class="media align-items-center">
								<div class="media-body">
									<span class="name mb-0 text-sm">${row.name}</span>
									</div>
									</div>
								</th>
								<td class="budget text-center">
									${row.activeuser}
								</td>
								<td class="text-right">${row.orders_count}</td>
								<td class="text-right">${row.total_amount}</td>
							</tr>`;

		$('.popular-list').append(html);
	});
}

function serverStatus() {
	var onLine = `<span class="text-success">●</span>
				<small>Online</small>`;
	var offLine = `<span class="text-danger">●</span>
				<small>Offline</small>`;			

	 $.ajax({
	    type: 'get',
	    url: base_url+'/admin/wa-server-status',
	    dataType: 'json',
	    contentType: false,
	    cache: false,
	    processData:false,

	    success: function(response){ 
	       $('#server-status').html(onLine);    
	      
	    },
	    error: function (xhr) {
           $('#server-status').html(offLine);    
        }
	 });			
}


 function initChart(days, values) {
    var $chart = $('#sales-chart');
    
    // Create chart
    var ordersChart = new Chart($chart, {
      type: 'bar',
      data: {
        labels: days,
        datasets: [{
          label: 'Amount',
          data: values,
          backgroundColor: '#7d61e4',
        }]
      },

    });

    // Save to jQuery object
    $chart.data('chart', ordersChart);
    ordersChart.update()
  }
