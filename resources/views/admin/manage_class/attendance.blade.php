@extends('admin.layouts.default')
@section("css")
<link href="/css/all.css?v=1.0.2" rel="stylesheet">
<link href="/css/flat/blue.css" rel="stylesheet">
<link href="/css/flat/red.css" rel="stylesheet">
<link href="/css/flat/orange.css" rel="stylesheet">
<link href="/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen" />
<link href="/vendors/panel/panel.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="{{ asset('/css/toastr.min.css') }}">
@endsection
@section('content')
<style type="text/css">
h2{
	font-size: 30px;
	font-weight: 700;
}
</style>


<!-- Content Header (Page header) -->
<section class="content-header">
	<!--section starts-->
	<ol class="breadcrumb">
		<li>
			<a href="{{url('/admin')}}">
				<i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
				Home
			</a> 
		</li>
		<li>
			<a >Transaction</a>
		</li>
		<li>
			<a >Manage Class</a>
		</li>
		<li class="active">Set Attendance</li>
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
				<form id="form-table" method="post" action="/attendance/insert">{{csrf_field()}}
					<input type="hidden" name="trainingclass_id" value="{{$tclass->id}}">
					<input type="hidden" id="attendance_id" value="{{$tclass->attendance->id}}">
					<div class="panel-body table-responsive">
						<div class="col-md-12">
							<div class="form-horizontal">
								<h4><b>Course : &ensp;{{$tclass->scheduledprogram->rate->program->programName . ' (' . $tclass->scheduledprogram->rate->duration . ' Hours)'}}</b></h4>
								<h4><b>Training Officer : &ensp;{{$tclass->scheduledprogram->trainingofficer->firstName . ' ' . $tclass->scheduledprogram->trainingofficer->middleName . ' ' .$tclass->scheduledprogram->trainingofficer->lastName}}</b></h4>
								<h4><b>{{$tclass->class_name}}</b></h4>
								<input type="hidden" id="checkAttendance" name="checkAttendance" value="0">
								<input type="hidden" id="attendanceCheck" name="attendanceCheck" value="0">
							</div>
							<div class="row form-group">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label col-md-4" style="margin-left: -8%;">Start Date</label>
										<div class="col-md-7">
											<input class="form-control type="text" value="{{Carbon\Carbon::parse($tclass->scheduledprogram->dateStart)->format('F d,Y')}}" id="start" readonly>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label col-md-4" style="margin-left: -8%;">End Date</label>
										<div class="col-md-7">
											<input class="form-control type="text" value="{{Carbon\Carbon::parse($dateEnd)->format('F d,Y')}}" id="start" readonly>
										</div>
									</div>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-md-8">
									<div class="form-group col-md-offset-2">
										<label class="control-label col-md-4" style="margin-left: -8%;">Attendance Date<font color="red">*</font></label>
										<div class="col-md-5">
											<div class="input-group date form_datetime" data-link-field="dtp_input1">
												<input class="form-control hasDatepicker" size="16" type="text" value="" onchange="dateChanged()" id="attendanceDate" name="attendanceDate" readonly>
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-th"></span>
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row" style="margin-bottom: 50px;">
								<div class="col-md-12">
									<div class="col-md-1"></div>
									<div class="col-md-2">
										<div class="panel panel-lightgreen">
											<div class="panel-heading">
												<h4 class="panel-title" style="text-align: center;">Trainees</h4>
												<h2 class="text-center">
													@if(count($tclass->groupclassdetail)!=0)
													{{count($tclass->groupclassdetail)}}
													@else
													{{count($tclass->classdetail->where('status','!=',1))}}
													@endif
												</h2>
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<div class="panel panel-blue">
											<div class="panel-heading">
												<h4 class="panel-title" style="text-align: center;">Present</h4>
												<h2 class="text-center" id="present">
													@if(count($tclass->groupclassdetail)!=0)
													{{count($tclass->groupclassdetail)}}
													@else
													{{count($tclass->classdetail->where('status','!=',1))}}
													@endif
												</h2>
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<div class="panel panel-red">
											<div class="panel-heading">
												<h4 class="panel-title" style="text-align: center;">Absent</h4>
												<h2 class="text-center" id="absent">0
												</h2>
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<div class="panel panel-yellow">
											<div class="panel-heading">
												<h4 class="panel-title" style="text-align: center;">Late</h4>
												<h2 class="text-center" id="late">0
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<div class="panel panel-purple">
											<div class="panel-heading">
												<h4 class="panel-title" style="text-align: center;">Percentage</h4>
												<h2 class="text-center" id="percentage">100</h2>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12 form-group">
							<button id="update" type="button" onclick="updateAttendance()" class="disabled btn btn-primary"><i class="glyphicon glyphicon-edit"></i>&ensp;Update Attendance</button>
						</div>
						<table class="table table-striped" id="table1">
							<thead>
								<tr>
									<th width="20%">Student Id</th>
									<th width="30%">Student Name</th>
									<th align="center" width="10%" class="btn-primary">Present</th>
									<th align="center" width="10%" class="btn-danger">Absent</th>
									<th align="center" width="10%" class="btn-warning">Late</th>
									<th width="20%">Remarks</th>
								</tr>
							</thead>
							<tbody>
								@if(count($tclass->groupclassdetail)!=0)
								<input type="hidden" class="class_type" id="class_type" value="2">
								@foreach($tclass->groupclassdetail as $details)
								<tr>
									<td>{{$details->groupenrollee->studentNumber}}<input type="hidden" name="groupclassdetail_id[]" value="{{$details->id}}"></td>
									<td>{{$details->groupenrollee->lastName . ', ' . $details->groupenrollee->firstName}}</td>
									<td align="center"><input id="blue{{$details->id}}" type="radio" name="status{{$details->id}}" checked value="1"></td>
									<td align="center"><input id="red{{$details->id}}" type="radio" name="status{{$details->id}}" value="2"></td>
									<td align="center"><input id="orange{{$details->id}}" type="radio" name="status{{$details->id}}" value="3"></td>
									<input id="{{$details->id}}" type="hidden" name="status[]" value="1">
									<td><textarea class="form-control" name="remarks[]"></textarea></td>
								</tr>
								@endforeach
								@else
								<input type="hidden" class="class_type" id="class_type" value="1">
								@foreach($tclass->classdetail as $details)
									@if($details->status != 1)
									<tr>
										<td>{{$details->enrollee->studentNumber}}</td><input type="hidden" name="classdetail_id[]" value="{{$details->id}}">
										<td>{{$details->enrollee->lastName . ', ' .$details->enrollee->firstName}}</td>
										<td align="center"><input id="blue{{$details->id}}" type="radio" name="status{{$details->id}}" checked value="1"></td>
										<td align="center"><input id="red{{$details->id}}" type="radio" name="status{{$details->id}}" value="2"></td>
										<td align="center"><input id="orange{{$details->id}}" type="radio" name="status{{$details->id}}" value="3"></td>
										<td>
											<input id="{{$details->id}}" type="hidden" name="status[]" value="1"><textarea class="form-control" name="remarks[]"></textarea></td>
									</tr>
									@endif
								@endforeach
								@endif
								</tbody>
							</table>
							<div class="col-md-3 col-md-offset-4">	
								<button type="submit" class="btn btn-block btn-primary">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
	@endsection
	@section('js')
	<script src="/js/icheck.js" type="text/javascript"></script>
	<script src="/vendors/iCheck/icheck.js" type="text/javascript"></script>
	<script src="/js/custom.js"></script>
	<script src="/vendors/touchspin/dist/jquery.bootstrap-touchspin.js"></script>
	<script type="text/javascript" src="/vendors/datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
  	<script src="/js/toastr.min.js"></script>

	<script type="text/javascript">
		@if(Session::has('message'))
		var type = "{{ Session::get('alert-type', 'info') }}";
		switch(type){
			case 'info':
			toastr.info("{{ Session::get('message') }}");
			break;

			case 'warning':
			toastr.warning("{{ Session::get('message') }}");
			break;

			case 'success':
			toastr.success("{{ Session::get('message') }}");
			break;

			case 'error':
			toastr.error("{{ Session::get('message') }}");
			break;
		}
		@endif

		$( "#form-table" ).submit(function(e) {
			console.log($('#checkAttendance').val());
			if($('#checkAttendance').val() == 1){
		  		e.preventDefault();
		  		toastr.error("Already had an attendance in this day");
			}
		});

		function updateAttendance(){
			$('#checkAttendance').val('0');
			toastr.info("You can now update attendance in this day");
			@if(count($tclass->groupclassdetail)!=0)
			@foreach($tclass->groupclassdetail as $details)
				$('#blue{{$details->id}}').iCheck('enable');
				$('#orange{{$details->id}}').iCheck('enable');
				$('#red{{$details->id}}').iCheck('enable');
			@endforeach
			@else
			@foreach($tclass->classdetail as $details)
				$('#blue{{$details->id}}').iCheck('enable');
				$('#orange{{$details->id}}').iCheck('enable');
				$('#red{{$details->id}}').iCheck('enable');
			@endforeach
			@endif
		}
	</script>
	<script type="text/javascript">
		var present = $('#present').text();	
		var absent = 0;
		var late = 0;
		var total = present;
		var attendanceDate = $('#attendanceDate').val();
		var class_type = $('#class_type').val();
		$(document).ready(function(){
			console.log(attendanceDate +" "+ $('#class_type').val()+" "+$('#attendance_id').val());
			$.ajax({
				type:'get',
				url:'{!!URL::to('ajax-manageclass-getAttendance')!!}',
				data:{"attendanceDate":attendanceDate,"class_type":$('#class_type').val(),"attendance_id":$('#attendance_id').val()},
				success:function(data){
					if(data.length != 0){
						$('#update').removeClass("disabled");
						$('#checkAttendance').val('1');
						$('#attendanceCheck').val('1');
						for(var i=0; i<data.length; i++){
							if(data[i].classdetail_id>0)
							{
								if(data[i].status == 1)
								{
									$('#blue'+data[i].groupclassdetail_id).iCheck('check');
									$('#red'+data[i].groupclassdetail_id).iCheck('disable');
									$('#orange'+data[i].groupclassdetail_id).iCheck('disable');
								}
								else if(data[i].status == 2)
								{
									$('#red'+data[i].groupclassdetail_id).iCheck('check');
									$('#blue'+data[i].groupclassdetail_id).iCheck('disable');
									$('#orange'+data[i].groupclassdetail_id).iCheck('disable');
								}
								else
								{
									$('#red'+data[i].groupclassdetail_id).iCheck('disable');
									$('#blue'+data[i].groupclassdetail_id).iCheck('disable');
									$('#orange'+data[i].groupclassdetail_id).iCheck('check');
								}
							}
						}
					}
					else
					{
						$('#update').addClass("disabled");
						$('#checkAttendance').val('0');
						$('#attendanceCheck').val('0');
					}
				},
				error:function(){
				}
			});

});
</script>
<script type="text/javascript">
	@if(count($tclass->groupclassdetail)!=0)
	@foreach($tclass->groupclassdetail as $details)
	$('#blue{{$details->id}}').on('ifChecked',function(){
		$('#{{$details->id}}').val('1');
		present++;
		$('#present').text(""+present+"");
		var percent = (present+late)/total*100;
		$('#percentage').text(''+percent.toFixed(2)+'');
	});
	$('#red{{$details->id}}').on('ifChecked',function(){
		$('#{{$details->id}}').val('2');
		absent++;
		$('#absent').text(""+absent+"");
		var percent = (present+late)/total*100;
		$('#percentage').text(''+percent.toFixed(2)+'');
	});
	$('#orange{{$details->id}}').on('ifChecked',function(){
		$('#{{$details->id}}').val('3');
		late++;
		$('#late').text(""+late+"");
		var percent = (present+late)/total*100;
		$('#percentage').text(''+percent.toFixed(2)+'');
	});
	@endforeach
	@foreach($tclass->groupclassdetail as $details)
	$('#blue{{$details->id}}').on('ifUnchecked',function(){
		$('#{{$details->id}}').val('1');
		present--;
		$('#present').text(""+present+"");
		var percent = (present+late)/total*100;
		$('#percentage').text(''+percent.toFixed(2)+'');
	});
	$('#red{{$details->id}}').on('ifUnchecked',function(){
		$('#{{$details->id}}').val('2');
		absent--;
		$('#absent').text(""+absent+"");
		var percent = (present+late)/total*100;
		$('#percentage').text(''+percent.toFixed(2)+'');
	});
	$('#orange{{$details->id}}').on('ifUnchecked',function(){
		$('#{{$details->id}}').val('3');
		late--;
		$('#late').text(""+late+"");
		var percent = (present+late)/total*100;
		$('#percentage').text(''+percent.toFixed(2)+'');
	});
	@endforeach
	@else
	@foreach($tclass->classdetail as $details)
	$('#blue{{$details->id}}').on('ifChecked',function(){
		$('#{{$details->id}}').val('1');
		present++;
		$('#present').text(""+present+"");
		var percent = (present+late)/total*100;
		$('#percentage').text(''+percent.toFixed(2)+'');
	});
	$('#red{{$details->id}}').on('ifChecked',function(){
		$('#{{$details->id}}').val('2');
		absent++;
		$('#absent').text(""+absent+"");
		var percent = (present+late)/total*100;
		$('#percentage').text(''+percent.toFixed(2)+'');
	});
	$('#orange{{$details->id}}').on('ifChecked',function(){
		$('#{{$details->id}}').val('3');
		late++;
		$('#late').text(""+late+"");
		var percent = (present+late)/total*100;
		$('#percentage').text(''+percent.toFixed(2)+'');
	});
	@endforeach
	@foreach($tclass->classdetail as $details)
	$('#blue{{$details->id}}').on('ifUnchecked',function(){
		$('#{{$details->id}}').val('1');
		present--;
		$('#present').text(""+present+"");
		var percent = (present+late)/total*100;
		$('#percentage').text(''+percent.toFixed(2)+'');
	});
	$('#red{{$details->id}}').on('ifUnchecked',function(){
		$('#{{$details->id}}').val('2');
		absent--;
		$('#absent').text(""+absent+"");
		var percent = (present+late)/total*100;
		$('#percentage').text(''+percent.toFixed(2)+'');
	});
	$('#orange{{$details->id}}').on('ifUnchecked',function(){
		$('#{{$details->id}}').val('3');
		late--;
		$('#late').text(""+late+"");
		var percent = (present+late)/total*100;
		$('#percentage').text(''+percent.toFixed(2)+'');
	});
	@endforeach
	@endif
</script>
<script type="text/javascript">
	function dateChanged(){
		var attendanceDate = $('#attendanceDate').val();
		$.ajax({
			type:'get',
			url:'{!!URL::to('ajax-manageclass-getAttendance')!!}',
			data:{"attendanceDate":attendanceDate,"class_type":class_type,"attendance_id":$('#attendance_id').val()},
			success:function(data){
				if(data.length != 0){
					$('#update').removeClass("disabled");
					$('#checkAttendance').val('1');
					$('#attendanceCheck').val('1');
					for(var i=0; i<data.length; i++){
						console.log(data[i].status);
						if(data[i].classdetail_id>0)
						{
							if(data[i].status == 1)
							{
								$('#blue'+data[i].classdetail_id).iCheck('check');
								$('#blue'+data[i].classdetail_id).iCheck('enable');
								$('#red'+data[i].classdetail_id).iCheck('disable');
								$('#orange'+data[i].classdetail_id).iCheck('disable');
							}
							else if(data[i].status == 2)
							{	
								$('#red'+data[i].classdetail_id).iCheck('check');
								$('#red'+data[i].classdetail_id).iCheck('enable');
								$('#blue'+data[i].classdetail_id).iCheck('disable');
								$('#orange'+data[i].classdetail_id).iCheck('disable');
							}
							else
							{
								$('#red'+data[i].classdetail_id).iCheck('disable');
								$('#blue'+data[i].classdetail_id).iCheck('disable');
								$('#orange'+data[i].classdetail_id).iCheck('check');
								$('#orange'+data[i].classdetail_id).iCheck('enable');
							}
						}
						else
						{
							if(data[i].status == 1)
							{
								$('#blue'+data[i].groupclassdetail_id).iCheck('check');
								$('#blue'+data[i].groupclassdetail_id).iCheck('enable');
								$('#red'+data[i].groupclassdetail_id).iCheck('disable');
								$('#orange'+data[i].groupclassdetail_id).iCheck('disable');
							}
							else if(data[i].status == 2)
							{	
								$('#red'+data[i].groupclassdetail_id).iCheck('check');
								$('#red'+data[i].groupclassdetail_id).iCheck('enable');
								$('#blue'+data[i].groupclassdetail_id).iCheck('disable');
								$('#orange'+data[i].groupclassdetail_id).iCheck('disable');
							}
							else
							{
								$('#red'+data[i].groupclassdetail_id).iCheck('disable');
								$('#blue'+data[i].groupclassdetail_id).iCheck('disable');
								$('#orange'+data[i].groupclassdetail_id).iCheck('check');
								$('#orange'+data[i].groupclassdetail_id).iCheck('enable');
							}
						}
					}
				}
				else{
					$('#update').addClass("disabled");
					$('#checkAttendance').val('0');
					$('#attendanceCheck').val('0');
					@if(count($tclass->groupclassdetail)!=0)
					@foreach($tclass->groupclassdetail as $details)
					$('#blue{{$details->id}}').iCheck('enable');
					$('#blue{{$details->id}}').iCheck('check');
					$('#red{{$details->id}}').iCheck('enable');
					$('#orange{{$details->id}}').iCheck('enable');
					@endforeach
					@else
					@foreach($tclass->classdetail as $details)
					$('#blue{{$details->id}}').iCheck('enable');
					$('#blue{{$details->id}}').iCheck('check');
					$('#red{{$details->id}}').iCheck('enable');
					$('#orange{{$details->id}}').iCheck('enable');
					@endforeach
					@endif
				}
			},
			error:function(){
			}
		});
	}
</script>
<script>
	var present = $('#present').text();	
	var absent = 0;
	var late = 0;
	var total = present;
	$(document).ready(function(){
		@if(count($tclass->groupclassdetail)!=0)
		@foreach($tclass->groupclassdetail as $details)
		$('#blue{{$details->id}}').iCheck({
			radioClass: 'iradio_flat-blue'
		});
		$('#red{{$details->id}}').iCheck({
			radioClass: 'iradio_flat-red'
		});
		$('#orange{{$details->id}}').iCheck({
			radioClass: 'iradio_flat-orange'
		});
		@endforeach
		@else
		@foreach($tclass->classdetail as $details)
		$('#blue{{$details->id}}').iCheck({
			radioClass: 'iradio_flat-blue'
		});
		$('#red{{$details->id}}').iCheck({
			radioClass: 'iradio_flat-red'
		});
		$('#orange{{$details->id}}').iCheck({
			radioClass: 'iradio_flat-orange'
		});
		@endforeach
		@endif
	});
	$(document).ready( function(){
		var table = $('#table1').DataTable();
	});
	$("#transaction").last().addClass( "active" );
	$("#manage_class").last().addClass( "active" );

</script>
<script type="text/javascript">
	$(".form_datetime").datetimepicker({
		format: "MM d,yyyy",
		daysOfWeekDisabled: [0],
		initialDate: "{{Carbon\Carbon::parse($tclass->scheduledprogram->dateStart)}}",
		startDate: "{{Carbon\Carbon::parse($tclass->scheduledprogram->dateStart)}}",
		endDate: "{{Carbon\Carbon::parse($dateEnd)}}",
		weekStart: 1,
		todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		maxView: 3,
		forceParse: 0,
		viewSelect:'month'
	});
</script> 
@endsection