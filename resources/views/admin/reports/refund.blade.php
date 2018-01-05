@extends('admin.layouts.default')
@section('css')
<link href="/vendors/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" />
<link href="/css/table.css" rel="stylesheet" />
@endsection
@section('content')

<section class="content-header">
	<!--section starts-->
	<h1>Refund Report</h1>
	<ol class="breadcrumb">
		<li>
			<a href="{{url('/admin')}}">
				<i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
				Home
			</a> 
		</li>
		<li>
			<a >Reports</a>
		</li>
		<li class="active">Refund Report</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-success filterable" style="overflow:auto;">
				<div class="panel-heading">
					<h3 class="panel-title">
					</h3>
				</div>
				<div class="panel-body table-responsive">
					<div class="form-horizontal">
						<form action="/reports/refund/print" method="post" target="_blank">
							{{csrf_field()}}
							<div class="col-md-12">
								<div class="col-md-4">
									<div class="form-group">
										<label class="col-md-5 control-label" for="timePeriod">Time Period</label>
										<div class="col-md-7">
											<select name="timePeriod" id="timePeriod" class="form-control" onchange="timePeriodChanged(this)">
												<option value="monthly">Monthly</option>
												<option value="yearly" selected>Yearly</option>
												<option value="dateRange">Date Range</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-8 " style="display: none;" id="dateRange">
									<div class="col-md-6">
										<div class="form-group parent" id="form_dateFrom">
											<label class="col-md-4 control-label" for="timePeriod">Date From</label>
											<div class="input-group date form_datetime"  data-date-format="MM dd, yyyy" data-link-field="dtp_input1" aria-describedby="helpDateRange">
												<input class="form-control" size="16" type="text" value="" readonly name="dateFrom" id="dateFrom">
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-th"></span>
												</span>
											</div>
											<span id="helpDateRange" class="help-block child" style="display: none; color: red;"><em>Date To</em> must be greater than <em>Date From</em></span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group" id="form_dateTo">
											<label class="col-md-4 control-label" for="timePeriod">Date To</label>
											<div class="input-group date form_datetime"  data-date-format="MM dd, yyyy" data-link-field="dtp_input1">
												<input class="form-control" size="16" type="text" value="" readonly name="dateTo" id="dateTo">
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-th"></span>
												</span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-8" style="display: none;" id="monthly">
									<div class="col-md-6">
										<div class="form-group" id="form_monthly">
											<label class="col-md-4 control-label" for="monthly_month">Month</label>
											<div class="col-md-8">
												<select name="monthly_month" id="monthly_month" class="form-control">
													<option selected disabled>--Select a Month--</option>
													<option value="January">January</option>
													<option value="February">February</option>
													<option value="March">March</option>
													<option value="April">April</option>
													<option value="May">May</option>
													<option value="June">June</option>
													<option value="July">July</option>
													<option value="August">August</option>
													<option value="September">September</option>
													<option value="October">October</option>
													<option value="November">November</option>
													<option value="December">December</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="monthly_year">Year</label>
											<div class="col-md-8">
												<select name="monthly_year" id="monthly_year" class="form-control">
													<option disabled>--Select a Year--</option>
													@for($i=2000;$i<=Carbon\Carbon::now()->format('Y'); $i++)
													@if($i < (Carbon\Carbon::now()->format('Y')))
													<option value="{{$i}}">{{$i}}</option>
													@else
													<option value="{{$i}}" selected>{{$i}}</option>
													@endif
												}
												@endfor
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-8" style="display: block;" id="yearly">
								<label class="col-md-2 control-label" for="yearly_year">Year</label>
								<div class="col-md-5">
									<select name="yearly_year" id="yearly_year" class="form-control">
										<option disabled>--Select a Year--</option>
										@for($i=2000;$i<=Carbon\Carbon::now()->format('Y'); $i++)
										@if($i < (Carbon\Carbon::now()->format('Y')))
										<option value="{{$i}}">{{$i}}</option>
										
										@else
										<option value="{{$i}}" selected>{{$i}}</option>
										
										@endif
										
										@endfor
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-12" style="margin-top: 20px;">
							<div class="col-md-4 col-md-offset-4">
								<button type="button" class="btn btn-info" onclick="previewClicked()">
									<i class="livicon pull-left" data-name="eye-open" data-hc="#fff" data-c="#fff" data-size="25"></i>Preview
								</button>
								<button type="submit" class="btn btn-primary">
									<i class="livicon pull-left" data-name="printer" data-hc="#fff" data-c="#fff" data-size="25"></i>Generate
								</button>
							</div>
						</div>
						<div class="col-md-12" style="margin-top: 20px;" id="title"></div>
						<table id="queryTable">
						</table>
						<table id="total"></table>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
</section>
@endsection
@section('js')
<script type="text/javascript" src="/vendors/datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>

<script type="text/javascript">
	$(".form_datetime").datetimepicker({
		format: "MM dd, yyyy",
		weekStart: 1,
		todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		maxView: 4,
		forceParse: 0,
	});
	$('#reports').addClass(' active ');
	$('#refund').addClass(' active ');
</script> 

<script type="text/javascript">
	function timePeriodChanged(timePeriod){

		$('#queryTable').empty();
		$('#total').empty();
		$('#title').empty();
		$('#monthly_year').val("2017");
		$('#yearly_year').val("2017");
		$('#form_monthly').removeClass('has-error');
		$('#monthly_month').prop('selectedIndex',0);

		$('#form_dateTo').removeClass('has-error');
		$('#form_dateFrom').removeClass('has-error');
		$('#dateFrom').val("");
		$('#dateTo').val("");


		if(timePeriod.value == "dateRange") {
			$('#dateRange').css('display','block');
			$('#monthly').css('display','none');
			$('#yearly').css('display','none');
		}
		else if(timePeriod.value == "monthly"){
			$('#yearly').css('display','none');
			$('#dateRange').css('display','none');
			$('#monthly').css('display','block');
		}
		else{
			$('#dateRange').css('display','none');
			$('#monthly').css('display','none');
			$('#yearly').css('display','block');
		}
	}
</script>

<script type="text/javascript">
	function previewClicked(){
		var timePeriod = $('#timePeriod').val();
		var total=0;
//----------------------------MONTHLY REPORT--------------------------------------------
if(timePeriod == "monthly"){

	var monthly_month = $('#monthly_month').val();
	var monthly_year = $('#monthly_year').val();

	if (monthly_month ==null) {
		$('#form_monthly').addClass('has-error');
	}
	else{
		$('#form_monthly').removeClass('has-error');

		$('#title').empty();
		$('#title').append('<center><h2>Refund Report for the Month of '+monthly_month+'</h2></center>')

		$('#queryTable').empty();
		$('#queryTable').append('<thead><tr><th width="25%">Name</th><th width="30%">Course</th><th width="15%" style="text-align: right;">Amount (Php)</th><th width="15%" style="text-align:center;">Date</th></tr></thead><tbody id="tableBody"></tbody>');

		$.ajax({
			type:'get',
			url:'{!!URL::to('ajax-query-refund-monthly')!!}',
			data:{monthly_month:monthly_month,monthly_year:monthly_year},
			success:function(data){
				for(var i = 0; i< data.length; i++){
					$('#tableBody').append('<tr><td>'+data[i]['name']+'</td><td>'+data[i]['course']+'</td><td style="text-align:right;">'+data[i]['amount']+'</td><td style="text-align:center;">'+data[i]['date']+'</td></tr>');
					// total += parseFloat(data[i]['amount']);

				}
				// $('#total').empty();
				// $('#total').append('<thead><tr><th width="25%">Total</th><th width="25%"></th><th width="25%"></th><th width="25%">'+parseFloat(total).toFixed(2)+'</th></tr></thead>');
			},
			error:function(){
			}
		});
	}
}
//----------------------------YEARLY REPORT----------------------------------------------
else if(timePeriod == "yearly"){
	var yearly_year = $('#yearly_year').val();

	$('#title').empty();
	$('#title').append('<center><h2>Refund Report for the Year '+yearly_year+'</h2></center>')

	$('#queryTable').empty();
		$('#queryTable').append('<thead><tr><th width="25%">Name</th><th width="30%">Course</th><th width="15%" style="text-align: right;">Amount (Php)</th><th width="15%" style="text-align:center;">Date</th></tr></thead><tbody id="tableBody"></tbody>');

	$.ajax({
		type:'get',
		url:'{!!URL::to('ajax-query-refund-yearly')!!}',
		data:{yearly_year:yearly_year},
		success:function(data){
			for(var i = 0; i< data.length; i++){
					$('#tableBody').append('<tr><td>'+data[i]['name']+'</td><td>'+data[i]['course']+'</td><td style="text-align:right;">'+data[i]['amount']+'</td><td style="text-align:center;">'+data[i]['date']+'</td></tr>');
				// total += parseFloat(data[i]['amount']);
			}
			// $('#total').empty();
			// $('#total').append('<thead><tr><th width="25%">Total</th><th width="25%"></th><th width="25%"></th><th width="25%">'+parseFloat(total).toFixed(2)+'</th></tr></thead>');
		},
		error:function(){
		}
	});
}
//----------------------------DATE RANGE REPORT----------------------------------------------
else if(timePeriod == "dateRange"){
	var range_dateFrom = $('#dateFrom').val();
	var range_dateTo = $('#dateTo').val();

	if ((range_dateFrom =="") || (range_dateTo=="")) {
		if((range_dateFrom =="") && (range_dateTo=="")){
			$('#form_dateFrom').addClass('has-error');
			$('#form_dateTo').addClass('has-error');
			$('#helpDateRange').css('display','none');
		}
		else if((range_dateTo=="")&&(range_dateFrom !="")){

			$('#form_dateTo').addClass('has-error');
			$('#form_dateFrom').removeClass('has-error');
			$('#helpDateRange').css('display','none');
		}
		else if((range_dateTo!="")&&(range_dateFrom =="")){
			$('#form_dateTo').removeClass('has-error');
			$('#form_dateFrom').addClass('has-error');
			$('#helpDateRange').css('display','none');
		}
	}
	else{

		if(moment($('#dateFrom').val(),'MM dd,YY').isAfter(moment($('#dateTo').val(),'MM dd,YY'))){
			$('#form_dateTo').addClass('has-error');
			$('#form_dateFrom').addClass('has-error');
			$('#queryTable').empty();
			$('#total').empty();
			$('#helpDateRange').css('display','block');
		}
		else{
			$('#form_dateTo').removeClass('has-error');
			$('#form_dateFrom').removeClass('has-error');
			$('#helpDateRange').css('display','none');


			$('#title').empty();
			$('#title').append('<center><h2>Refund Report from '+range_dateFrom+' to '+range_dateTo+'</h2></center>')

			$('#queryTable').empty();
		$('#queryTable').append('<thead><tr><th width="25%">Name</th><th width="30%">Course</th><th width="15%" style="text-align: right;">Amount (Php)</th><th width="15%" style="text-align:center;">Date</th></tr></thead><tbody id="tableBody"></tbody>');

			$.ajax({
				type:'get',
				url:'{!!URL::to('ajax-query-refund-dateRange')!!}',
				data:{range_dateFrom:range_dateFrom,range_dateTo:range_dateTo},
				success:function(data){
					for(var i = 0; i< data.length; i++){
						$('#tableBody').append('<tr><td>'+data[i]['name']+'</td><td>'+data[i]['course']+'</td><td style="text-align:right;">'+data[i]['amount']+'</td><td style="text-align:center;">'+data[i]['date']+'</td></tr>');
					}
					// $('#total').empty();
					// $('#total').append('<thead><tr><th width="25%">Total</th><th width="25%"></th><th width="25%"></th><th width="25%">'+parseFloat(total).toFixed(2)+'</th></tr></thead>');
				},
				error:function(){
				}
			});
		}
	}
			}//end of dateRange report
		}//end of PreviewCLicked
	</script>
@endsection