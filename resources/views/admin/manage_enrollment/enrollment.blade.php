@extends('admin.layouts.default')
@section("css")
  <link href="/css/all.css?v=1.0.2" rel="stylesheet">
  <link href="/css/flat/blue.css" rel="stylesheet">
<link href="vendors/touchspin/dist/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css" media="all" />
<link href="/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen" />
<link href="/vendors/panel/panel.css" rel="stylesheet" type="text/css"/>
    <link href="/css/fullcalendar.css" rel="stylesheet" type="text/css" />
    <link href="/css/calendar_custom.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')

<style type="text/css">
	.buttons{
		margin-left: 1.5%;
		margin-bottom: 2.5%;
	}

	.butt{
		margin-bottom: 5px;
	}
    .rowColor{
        background-color: #FFDFBA!important;
    }
    table tbody td form button{
    	margin-bottom: 2px !important;
    }
    .blue th{
    	background-color: #A6C8E6
    }
    .red{
		background-color: #FFB3BA!important;
		}
		.orange{
			background-color: #FFDFBA!important;
		}
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
	<!--section starts-->
	<h1>Manage Schedule</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-success filterable" style="overflow:auto;">
				<div class="panel-heading">
					<h3 class="panel-title">
						&ensp;&ensp;<big>List of Sessions</big>
					</h3>
				</div>
				<div class="panel-body table-responsive">
					<button class="buttons btn btn-success" data-toggle="modal" data-href="#responsive" href="#responsive"><i class="glyphicon glyphicon-plus"></i>&ensp;New Schedule</button>
					<button class="buttons btn btn-success" data-toggle="modal" data-href="#NoSession" href="#NoSession"><i class="glyphicon glyphicon-plus"></i>&ensp;No Session Day</button>
					<a href="/calendar" class="buttons btn btn-info"><i class="glyphicon glyphicon-calendar"></i>&ensp;Oceanlink Calendar</a>

						<div class="col-md-3 pull-right">
							<fieldset>
              	<legend>Legend</legend>
              	<span class="badge red">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;Class starts <b>today</b> with insufficient enrolled trainees<br>
              	<span class="badge orange">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;Less than <b>6 days</b> before class start with insufficient enrolled trainees
              </fieldset>
            </div>
					<table class="table table-striped table-bordered" id="table1">
						<thead>
							<tr>
								<th width="10%">Class Name</th>
								<th width="15%">Course Name</th>
								<th width="12%">Date Start</th>
								<th width="11%">Date End</th>
								<th width="18%">Schedule</th>
								<th width="11%">Total no. of Students</th>
								<th width="10%">Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($tclass as $tclasses)
								<tr id="row{{$tclasses['id']}}">
									<td>{{$tclasses['class_name']}}</td>
									<td>{{$tclasses['course_name']}}</td>
									<td>{{$tclasses['dateStart']}}</td>
									<td>{{$tclasses['dateEnd']}}</td>
									<td>@if(count($tclasses['sched'])>1)
									@foreach($tclasses['sched'] as $scheds)
										{{$scheds['scheds']}}</br>
									@endforeach
									@else
										{{$tclasses['sched']}}
									@endif
									</td>
									<td align="center">{{$tclasses['total']}}</td>
									<td><form action="/manage_enrollment/set" method="get">@if($tclasses['status'] == 0)<input type="hidden" name="id" value="{{$tclasses['id']}}"><button type="submit" class="btn btn-info col-sm-12"><i class="glyphicon glyphicon-pushpin" ></i>&ensp;Post</button><br>@endif
									@if($tclasses['status'] == 0)
										<button type="button" class="btn btn-primary col-sm-12" data-toggle="modal" data-href="#updateModal{{$tclasses['id']}}" href="#updateModal{{$tclasses['id']}}" onclick="counter({{$tclasses['id']}})"><i class="glyphicon glyphicon-edit" ></i>&ensp;Update</button><br>
										<button type="button" onclick="cancelClick({{$tclasses['id']}})" class="btn btn-danger col-sm-12" data-toggle="modal" data-href="#dialog{{$tclasses['id']}}" href="#dialog{{$tclasses['id']}}"><i class="glyphicon glyphicon-remove"></i>&ensp;Cancel</button>
									@else
										@if(Carbon\Carbon::parse($tclasses['dateStart'])->subDays(5)->lte(Carbon\Carbon::today()))
											@if($tclasses['total'] < $tclasses['min_student'])
											<button type="button" class="btn btn-primary col-sm-12" data-toggle="modal" data-href="#updateModal{{$tclasses['id']}}" href="#updateDate{{$tclasses['id']}}"><i class="glyphicon glyphicon-edit" ></i>&ensp;Update</button><br>
											<button type="button" onclick="cancelClick({{$tclasses['id']}})" class="btn btn-danger col-sm-12" data-toggle="modal" data-href="#dialog{{$tclasses['id']}}" href="#dialog{{$tclasses['id']}}"><i class="glyphicon glyphicon-remove"></i>&ensp;Cancel</button>
											@endif
										@endif
									@endif
									<button type="button" data-toggle="modal" data-href="#SessionCalendar{{$tclasses['id']}}" href="#SessionCalendar{{$tclasses['id']}}" class="btn btn-info col-sm-12"><i class="glyphicon glyphicon-calendar"></i>&ensp;Session Calendar</button>
									</form></td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- SESSION CALENDAR -->
@foreach($tclass as $tclasses)
<div class="modal fade in" id="SessionCalendar{{$tclasses['id']}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header btn-info">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Training Session Calendar</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-4">
						<div class="box">
							<div class="box-title">
								<h3>Legends</h3>
							</div>
							<div class="box-body">
								<div >
									<div class='external-event palette-primary'>Days that have session</div>
									<div class='external-event palette-warning'>No session day</div>
									<div class='external-event palette-danger'>Holiday</div>
								</div>
							</div>
						</div>
						<!-- /.box --> 
					</div>
					<div class="col-md-12">
						<div class="box">
							<div class="box-body">
								<div id="calendar{{$tclasses['id']}}"></div>
							</div>
						</div>
						<!-- /.box --> 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endforeach
<!-- No session day modal -->
<div class="modal fade in" id="NoSession" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<form id="session-form" action="/manage_enrollment/nosession" method="post" class="form-horizontal">
				{{ csrf_field() }} 	
				<div class="modal-header btn-primary">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">No Session Day</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="row">
							<div class="col-md-12">
								<div class="alert alert-success">
									<p><em>Note: <font color="red">*</font> fields are required</em></p>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-3 col-md-offset-3">
									<div class="form-group">
										&ensp;
										<input type="checkbox" name="dateRange" id="dateRange">&ensp; Date Range
									</div>
								</div>
							</div>
							<div id="dates">
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-3 control-label">Date<font color="red">*</font></label>
									<div class="col-sm-8">
										<div class="input-group date form_datetime col-sm-7" data-link-field="dtp_input1">
			                                <input class="form-control hasDatepicker" size="16" type="text" value="{{Carbon\Carbon::now()->format('F d,Y')}}"  name="sessionDate" readonly>
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-th"></span>
											</span>
			                            </div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Description</label>
								<div class="col-sm-8">
									<textarea class="form-control" name="description"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--Create Modal-->
<div class="modal fade in" id="responsive" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="/manage_enrollment/insert" method="post" class="form-horizontal">
				{{ csrf_field() }} 	
				<div class="modal-header btn-primary">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">New Course Schedule</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="row">
							<div class="col-md-12">
								<div class="alert alert-success">
									<p><em>Note: <font color="red">*</font> fields are required</em></p>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Course Name<font color="red">*</font></label>
								<div class="col-sm-8">
									<select required name="rate_id" class="form-control">
										@foreach($rate as $rates)
										<option value="{{$rates->id}}">{{$rates->program->programName . ' ( ' . $rates->duration . ' Hours )'}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Training Officer<font color="red">*</font></label>
								<div class="col-sm-8">
									<select required name="officer_id" class="form-control">
										@foreach($officer as $officers)
										<option value="{{$officers->id}}">{{$officers->firstName . ' ' . $officers->middleName . ' ' . $officers->lastName}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Date Start<font color="red">*</font></label>
								<div class="col-sm-8">
									<div class="input-group date form_datetime col-sm-7" data-link-field="dtp_input1">
										<input class="form-control hasDatepicker" size="16" type="text" value="{{Carbon\Carbon::now()->format('F d,Y')}}" name="dateStart" readonly>
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-th"></span>
										</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Building<font color="red">*</font></label>
								<div class="col-sm-8">
									<select id="building" onchange="changes()" name="building_id" class="form-control">
										@foreach($building as $buildings)
										<option value="{{$buildings->id}}">{{$buildings->buildingName}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Floor<font color="red">*</font></label>
								<div class="col-sm-8">
									<select id="floor" onchange="floorchange()" name="floor_id" class="form-control">
										@foreach($firsts as $firsts)
										<option>{{$firsts->floorName}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Room<font color="red">*</font></label>
								<div class="col-sm-8">
									<select required id="rooms" name="room_id" class="form-control">
										@foreach($room as $rooms)
										<option value="{{$rooms->id}}">{{$rooms->room_no}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="text-center">
								<h2>Schedule</h2>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<div style="margin-left: 10%;">
										<input tabindex="13" type="checkbox" id="check">
										<label for="flat-checkbox-1">Date Range</label>
									</div>
								</div>
								<div>
									<table class="table table-striped table-bordered blue" id="dynamic_table">
										<thead>
											<th width="30%">Day<font color="red">*</font></th>
											<th width="20%">Start<font color="red">*</font></th>
											<th width="20%">End<font color="red">*</font></th>
											<th width="20%">Break Time</th>
											<th width="10%"></th>
										</thead>
										<tbody id="row">
											<tr >
												<td><select id="day1" onchange="days(1)" class="form-control" name="day[]">
													@foreach($day as $days)
													<option value="{{$days->id}}">{{$days->dayName}}</option>
												@endforeach</select>
											</td>
											<td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="morning[]" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($i<17) @if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option>@endif @endif @if($i==17 && $a==0)<option value="{{$i}}:00">{{$i}}:00</option>@endif @endfor @endfor</select></div></td>
											<td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="afternoon[]" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($i<17) @if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option>@endif @endif @if($i==17 && $a==0)<option value="{{$i}}:00">{{$i}}:00</option>@endif @endfor @endfor</select></div></td>
											<td><select name="breaktime[]" class="form-control" >@for($a=1;$a<5;$a++)<option value="{{$a*15}}">{{$a*15}}</option>@endfor</select></td>
											<td><button type="button" onclick="clicks()" class="btn btn-primary"><i class="glyphicon glyphicon-plus" ></i></button></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn">Close</button>
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
	</div>
</div>
</div>

<!-- Update Modal -->
@foreach($class as $classes)
@if(count($classes->groupapplicationdetail)==0)
<div class="modal fade in" id="updateModal{{$classes->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="/manage_enrollment/update" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<input type="hidden" name="trainingclass_id" value="{{$classes->id}}">
				<div class="modal-header btn-primary">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Update Course Schedule</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="row">
							<div class="col-md-12">
								<div class="alert alert-success">
									<p><em>Note: <font color="red">*</font> fields are required</em></p>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Course Name<font color="red">*</font></label>
								<div class="col-sm-8">
									<select required name="rate_id" class="form-control">
									@foreach($rate as $rates)
										@if($rates->id == $classes->scheduledprogram->rate->id)
										<option selected value="{{$rates->id}}">{{$rates->program->programName . ' ( ' . $rates->duration . ' Hours )'}}</option>
										@else
										<option value="{{$rates->id}}">{{$rates->program->programName . ' ( ' . $rates->duration . ' Hours )'}}</option>
										@endif
									@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Training Officer<font color="red">*</font></label>
								<div class="col-sm-8">
									<select required name="officer_id" class="form-control">
									@foreach($officer as $officers)
										@if($classes->scheduledprogram->trainingofficer->id == $officers->id)
										<option selected value="{{$officers->id}}">{{$officers->firstName . ' ' . $officers->middleName . ' ' . $officers->lastName}}</option>
										@else
										<option value="{{$officers->id}}">{{$officers->firstName . ' ' . $officers->middleName . ' ' . $officers->lastName}}</option>
										@endif
									@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Date Start<font color="red">*</font></label>
								<div class="col-sm-8">
									<div class="input-group date form_datetime col-sm-7" data-link-field="dtp_input1">
					                    <input class="form-control hasDatepicker" size="16" type="text" value="{{Carbon\Carbon::parse($classes->scheduledprogram->dateStart)->format('F d,Y')}}" name="dateStart" readonly>
					                    <span class="input-group-addon">
					                        <span class="glyphicon glyphicon-th"></span>
					                    </span>
							        </div>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Building<font color="red">*</font></label>
								<div class="col-sm-8">
									<select id="building" onchange="changes()" name="building_id" class="form-control">
										@foreach($building as $buildings)
											@if($buildings->id == $classes->trainingroom->building->id)
											@else
											<option value="{{$buildings->id}}">{{$buildings->buildingName}}</option>
											@endif
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Floor<font color="red">*</font></label>
								<div class="col-sm-8">
									<select id="floor" onchange="floorchange()" name="floor_id" class="form-control">
										@foreach($classes->trainingroom->building->floor as $floors)
											@if($floors->id == $classes->trainingroom->floor->id)
												<option selected value="{{$floors->id}}">{{$floors->floorName}}</option>
											@else
												<option value="{{$floors->id}}">{{$floors->floorName}}</option>
											@endif
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Room<font color="red">*</font></label>
								<div class="col-sm-8">
									<select required id="rooms" name="room_id" class="form-control">
									@foreach($classes->trainingroom->building->trainingroom as $rooms)
										@if($rooms->id == $classes->trainingroom_id)
										<option selected value="{{$rooms->id}}">{{$rooms->room_no}}</option>
										@else
										<option value="{{$rooms->id}}">{{$rooms->room_no}}</option>
										@endif
									@endforeach
									</select>
								</div>
							</div>
							<div class="text-center">
								<h2>Schedule</h2>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<div style="margin-left: 10%;">
										<input tabindex="13" type="checkbox" id="check{{$classes->id}}">
		                  				<label for="flat-checkbox-1">Date Range</label>
									</div>
								</div>
								<div>
									<input type="hidden" name="name" value="{{$z=0}}">
									<table class="table table-striped table-bordered blue" id="dynamic_table{{$classes->id}}">
										<thead>
											<th width="30%">Day<font color="red">*</font></th>
											<th width="20%">Start<font color="red">*</font></th>
											<th width="20%">End<font color="red">*</font></th>
											<th width="20%">Break Time</th>
											<th width="10%"></th>
										</thead>
										<tbody id="tableRow{{$classes->id}}">
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn">Close</button>
					<button type="submit" class="btn btn-primary">Update</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endif
@endforeach

@foreach($class as $classes)
@if(count($classes->groupapplicationdetail)==0)
@if($classes->status ==1)
@if(Carbon\Carbon::parse($classes->scheduledprogram->dateStart)->subDays(5)->lte(Carbon\Carbon::today()))
@if(count($classes->classdetail->where('status','=',2)) + count($classes->classdetail->where('status','=',3)) < $classes->scheduledprogram->rate->min_students)
<div class="modal fade in" id="updateDate{{$classes->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<form action="/manage_enrollment/updateDateStart" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<input type="hidden" name="trainingclass_id" value="{{$classes->id}}">
				<input type="hidden" name="officer_id" value="{{$classes->scheduledprogram->trainingofficer->id}}">
				<div class="modal-header btn-primary">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Update Training Class Date Start</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Date Start &ensp;*</label>
								<div class="col-sm-8">
									<div class="input-group date form_datetime col-sm-7" data-link-field="dtp_input1">
					                    <input class="form-control hasDatepicker" size="16" type="text" value="{{Carbon\Carbon::parse($classes->scheduledprogram->dateStart)->format('F d,Y')}}" name="dateStart" readonly>
					                    <span class="input-group-addon">
					                        <span class="glyphicon glyphicon-th"></span>
					                    </span>
							        </div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn">Close</button>
					<button type="submit" class="btn btn-primary">Update</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endif
@endif
@endif
@endif
@endforeach

<!-- Dialog Box Confirmation -->
@foreach($tclass as $tclasses)
	<div class="modal fade in" id="dialog{{$tclasses['id']}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form action="/manage_enrollment/cancel" method="post" class="form-horizontal">
					{{ csrf_field() }} 	
					<input type="hidden" name="tclass_id" value="{{$tclasses['id']}}"/>
					<div class="modal-header btn-danger">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title">Cancel Schedule</h4>
					</div>
					<div class="modal-body">
						<span id="span{{$tclasses['id']}}">Are you sure you want to cancel the schedule for <b>{{$tclasses['class_name']}}</b>?</span>
					</div>
					<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn">No</button>
					<button type="submit" class="btn btn-primary" >Yes</button>
				</div>
				</form>
			</div>
		</div>
	</div>
@endforeach

@endsection
@section('js')
	<script src="/js/fullcalendar.min.js" type="text/javascript"></script>
	<script src="/js/calendarcustom.min.js" type="text/javascript"></script>
    <script src="js/metisMenu.js" type="text/javascript"></script>
    <script src="/vendors/touchspin/dist/jquery.bootstrap-touchspin.js"></script>
    <script src="js/icheck.js" type="text/javascript"></script>
  	<script src="/js/custom.js"></script>
	<script type="text/javascript" src="/vendors/datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script src="/js/moment.min.js"></script>
    <script type="text/javascript">

		$.validator.addMethod("valid1", function(value, element) { 
			var start = Date.parse($("#start").val());
			var end =Date.parse($("#end").val());
		    return this.optional(element) || end>=start;
		}, "End Date must be greater than or equal to Start Date");

    	$('#dateRange').on('ifChecked',function(){
		$('#dates').empty();
		$('#dates').append('<div class="form-group"><label class="control-label col-sm-3">Start Date<font color="red">*</font></label><div class="col-md-8"><div class="input-group date form_datetime col-sm-7" data-link-field="dtp_input1"><input class="form-control hasDatepicker" size="16" type="text" value="{{Carbon\Carbon::now()->format("F d,Y")}}" id="start" name="sessionStart" readonly><span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span></div></div></div><div class="form-group"><label class="control-label col-sm-3">End Date<font color="red">*</font></label><div class="col-md-8"><div class="input-group date form_datetime col-sm-7" data-link-field="dtp_input1"><input class="form-control" size="16" type="text" value="{{Carbon\Carbon::now()->format("F d,Y")}}" id="end" name="sessionEnd" readonly><span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span></div></div></div>');

		$(".form_datetime").datetimepicker({
	        format: "MM dd, yyyy",
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
	})

	$('#dateRange').on('ifUnchecked',function(){
		$('#dates').empty();
		$('#dates').append('<div class="form-group"><label class="control-label col-sm-3">Date<font color="red">*</font></label><div class="col-md-8"><div class="input-group date form_datetime col-sm-7" data-link-field="dtp_input1"><input class="form-control hasDatepicker" size="16" type="text" value="{{Carbon\Carbon::now()->format('F d,Y')}}" id="start" name="sessionDate" readonly><span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span></div></div></div>');

		$(".form_datetime").datetimepicker({
	        format: "MM dd, yyyy",
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
	});
	$(function(){
		$('#session-form').validate({
			rules:{
				sessionStart:{
					required:true,
					valid1:true
				},
				sessionEnd:{
					required: true,
					valid1:true
				},
			},
			errorPlacement:function(error,element){
         		error.insertAfter(element.parent("div"));
			}
		});
	});
    </script>
<script>
	$(document).ready(function(){
	  $('input').iCheck({
	    checkboxClass: 'icheckbox_flat-blue',
	    radioClass: 'iradio_flat'
	  });
	});
	function days(id){
		console.log($("#day"+id).val());
	}
	$('input').on('ifChecked', function(event){
		$("#dynamic_table").empty();
	  	$("#dynamic_table").append('<thead><th width="20%">From<font color="red">*</font</th><th width="20%">To</th><th width="20%">Start<font color="red">*</font</th><th width="20%">End<font color="red">*</font</th><th width="20">Break Time</th></thead><tbody><tr><td><select class="form-control" name="start">@foreach($day as $days)<option value="{{$days->id}}">{{$days->dayName}}</option>@endforeach</select></td><td><select class="form-control" name="end">@foreach($day as $days)@if($days->dayName == "Tuesday") <option selected value="{{$days->id}}">{{$days->dayName}}</option> @else <option value="{{$days->id}}">{{$days->dayName}}</option> @endif @endforeach</select></td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="morning" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($i<17) @if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option>@endif @endif @if($i==17 && $a==0)<option value="{{$i}}:00">{{$i}}:00</option>@endif @endfor @endfor</select></div></td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="afternoon" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($i<17) @if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option>@endif @endif @if($i==17 && $a==0)<option value="{{$i}}:00">{{$i}}:00</option>@endif @endfor @endfor</select></div></td><td><select name="breaktime" class="form-control" >@for($a=1;$a<5;$a++)<option value="{{$a*15}}">{{$a*15}}</option>@endfor</select></td></tr></tbody>');
	  	$("input[name='demo_vertical']").TouchSpin({
	  		initval: 00,
	  		min: 0,
            max: 59,
            step: 15,
	      verticalbuttons: true,
	    });
	});
	$('input').on('ifUnchecked', function(event){
		$("#dynamic_table").empty();
		$("#dynamic_table").append('<thead><th width="30%">Day<font color="red">*</font</th><th width="20%">Morning<font color="red">*</font</th><th width="20%">Afternoon<font color="red">*</font</th></th><th width="20">Break Time</th><th width="10%"></thead><tbody id="row"><tr><td><select class="form-control" name="day[]">@foreach($day as $days)<option value="{{$days->id}}">{{$days->dayName}}</option>@endforeach</td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="morning[]" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option> @endif @endfor @endfor</select></div></td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="afternoon[]" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($i<17) @if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option>@endif @endif @if($i==17 && $a==0)<option value="{{$i}}:00">{{$i}}:00</option>@endif @endfor @endfor</select></div></td><td><select name="breaktime[]" class="form-control" >@for($a=1;$a<5;$a++)<option value="{{$a*15}}">{{$a*15}}</option>@endfor</select></td><td><button type="button" onclick="clicks()" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i></button></td></tr></tbody>');
	});
	var i=1;
	function clicks(){
		$("#row").append('<tr id="row'+i+'"><td><select class="form-control" name="day[]">@foreach($day as $days)<option value="{{$days->id}}">{{$days->dayName}}</option>@endforeach</td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="morning[]" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option> @endif @endfor @endfor</select></div></td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="afternoon[]" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($i<17) @if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option>@endif @endif @if($i==17 && $a==0)<option value="{{$i}}:00">{{$i}}:00</option>@endif @endfor @endfor</select></div></td><td><select name="breaktime[]" class="form-control" >@for($a=1;$a<5;$a++)<option value="{{$a*15}}">{{$a*15}}</option>@endfor</select></td><td><button type="button" onclick="removes('+i+')" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></button></td></tr>');
	}
	function removes(id){
		$("#row"+id).remove();
		i--;
	}
</script>
<script type="text/javascript">
	var i = 0;
	function counter(x){
		console.log(x);
		@foreach($class as $classes)
			@if(count($classes->groupapplicationdetail)==0)
			if(x == {{$classes->id}})
			{
				$('#tableRow'+x).empty();
				i = {{count($classes->schedule->scheduledetail)}}+1;
				$('#tableRow'+x).append('@foreach($classes->schedule->scheduledetail as $details)<tr id="updateDelete{{$details->id}}"> <td> <select id="day1" onchange="days(1)" class="form-control" name="day[]"> @foreach ($day as $days) @if ($days->id == $details->day_id)<option selected value="{{$days->id}}">{{$days->dayName}}</option>@else<option value="{{$days->id}}">{{$days->dayName}}</option> @endif @endforeach</select></td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="morning[]" class="form-control" >@for ($i=8; $i<18;$i++) @for ($a=0;$a<4;$a++) @if ($i<17) @if ($a*15 == 0) @if (strval($i) == Carbon\Carbon::parse($details->start)->format("G")) <option selected value="{{$i}}:00">{{$i}}:00</option> @else <option value="{{$i}}:00">{{$i}}:00</option>  @endif @else @if(strval($i) == Carbon\Carbon::parse($details->start)->format("G") && strval($a*15) == Carbon\Carbon::parse($details->start)->format("i")) <option selected value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option> @else <option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option> @endif @endif @endif @if ($i==17 && $a==0 ) @if (Carbon\Carbon::parse($details->start)->format("G") == strval($i))<option selected value="{{$i}}:00">{{$i}}:00</option> @else <option value="{{$i}}:00">{{$i}}:00</option> @endif @endif @endfor @endfor</select></div></td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="afternoon[]" class="form-control" > @for ($i=8; $i<18;$i++) @for ($a=0;$a<4;$a++) @if ($i<17) @if ($a*15 == 0) @if(strval($i) == Carbon\Carbon::parse($details->end)->format("G")) <option selected value="{{$i}}:00">{{$i}}:00</option> @else <option value="{{$i}}:00">{{$i}}:00</option>  @endif @else @if(strval($i) == Carbon\Carbon::parse($details->end)->format("G") && strval($a*15) == Carbon\Carbon::parse($details->end)->format("i")) <option selected value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option> @else <option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option> @endif @endif @endif @if($i==17 && $a==0 ) @if (Carbon\Carbon::parse($details->end)->format("G") == strval($i))<option selected value="{{$i}}:00">{{$i}}:00</option> @else <option value="{{$i}}:00">{{$i}}:00</option> @endif @endif @endfor @endfor </select></div></td><td><select name="breaktime[]" class="form-control" > @for ($a=1;$a<5;$a++)<option value="{{$a*15}}">{{$a*15}}</option> @endfor </select></td> @if (++$z == 1)<td><button type="button" onclick="updateClick({{$classes->id}})" class="btn btn-primary"><i class="glyphicon glyphicon-plus" ></i></button></td> @else <td><button type="button" onclick="updateRemove({{$details->id}})" class="btn btn-danger"><i class="glyphicon glyphicon-remove" ></i></button></td> @endif </tr>@endforeach');
			}
			@endif
		@endforeach

		$('#check'+x).on('ifChecked',function(){
			$("#dynamic_table"+x).empty();
		  	$("#dynamic_table"+x).append('<thead><th width="20%">From<font color="red">*</font</th><th width="20%">To</th><th width="20%">Start<font color="red">*</font</th><th width="20%">End<font color="red">*</font</th><th width="20">Break Time</th></thead><tbody><tr><td><select class="form-control" name="start">@foreach($day as $days)<option value="{{$days->id}}">{{$days->dayName}}</option>@endforeach</select></td><td><select class="form-control" name="end">@foreach($day as $days)@if($days->dayName == "Tuesday") <option selected value="{{$days->id}}">{{$days->dayName}}</option> @else <option value="{{$days->id}}">{{$days->dayName}}</option> @endif @endforeach</select></td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="morning" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($i<17) @if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option>@endif @endif @if($i==17 && $a==0)<option value="{{$i}}:00">{{$i}}:00</option>@endif @endfor @endfor</select></div></td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="afternoon" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($i<17) @if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option>@endif @endif @if($i==17 && $a==0)<option value="{{$i}}:00">{{$i}}:00</option>@endif @endfor @endfor</select></div></td><td><select name="breaktime" class="form-control" >@for($a=1;$a<5;$a++)<option value="{{$a*15}}">{{$a*15}}</option>@endfor</select></td></tr></tbody>');
		  	$("input[name='demo_vertical']").TouchSpin({
		  		initval: 00,
		  		min: 0,
	            max: 59,
	            step: 15,
		      verticalbuttons: true,
		    });
		});

		$('#check'+x).on('ifUnchecked',function(){
			$("#dynamic_table"+x).empty();
			{{$z=0}}
			@foreach($class as $classes)
			@if(count($classes->groupapplicationdetail)==0)
			if(x == {{$classes->id}})
			{
				$("#dynamic_table"+x).append('<thead><th width="30%">Day<font color="red">*</font</th><th width="20%">Morning<font color="red">*</font</th><th width="20%">Afternoon<font color="red">*</font</th></th><th width="20">Break Time</th><th width="10%"></thead><tbody id="tableRow{{$classes->id}}">');
				i = {{count($classes->schedule->scheduledetail)}}+1;
				$('#tableRow'+x).append('@foreach($classes->schedule->scheduledetail as $details)<tr id="updateDelete{{$details->id}}"> <td> <select id="day1" onchange="days(1)" class="form-control" name="day[]"> @foreach ($day as $days) @if ($days->id == $details->day_id)<option selected value="{{$days->id}}">{{$days->dayName}}</option>@else<option value="{{$days->id}}">{{$days->dayName}}</option> @endif @endforeach</select></td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="morning[]" class="form-control" >@for ($i=8; $i<18;$i++) @for ($a=0;$a<4;$a++) @if ($i<17) @if ($a*15 == 0) @if (strval($i) == Carbon\Carbon::parse($details->start)->format("G")) <option selected value="{{$i}}:00">{{$i}}:00</option> @else <option value="{{$i}}:00">{{$i}}:00</option>  @endif @else @if(strval($i) == Carbon\Carbon::parse($details->start)->format("G") && strval($a*15) == Carbon\Carbon::parse($details->start)->format("i")) <option selected value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option> @else <option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option> @endif @endif @endif @if ($i==17 && $a==0 ) @if (Carbon\Carbon::parse($details->start)->format("G") == strval($i))<option selected value="{{$i}}:00">{{$i}}:00</option> @else <option value="{{$i}}:00">{{$i}}:00</option> @endif @endif @endfor @endfor</select></div></td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="afternoon[]" class="form-control" > @for ($i=8; $i<18;$i++) @for ($a=0;$a<4;$a++) @if ($i<17) @if ($a*15 == 0) @if(strval($i) == Carbon\Carbon::parse($details->end)->format("G")) <option selected value="{{$i}}:00">{{$i}}:00</option> @else <option value="{{$i}}:00">{{$i}}:00</option>  @endif @else @if(strval($i) == Carbon\Carbon::parse($details->end)->format("G") && strval($a*15) == Carbon\Carbon::parse($details->end)->format("i")) <option selected value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option> @else <option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option> @endif @endif @endif @if($i==17 && $a==0 ) @if (Carbon\Carbon::parse($details->end)->format("G") == strval($i))<option selected value="{{$i}}:00">{{$i}}:00</option> @else <option value="{{$i}}:00">{{$i}}:00</option> @endif @endif @endfor @endfor </select></div></td><td><select name="breaktime[]" class="form-control" > @for ($a=1;$a<5;$a++)<option value="{{$a*15}}">{{$a*15}}</option> @endfor </select></td> @if (++$z == 1)<td><button type="button" onclick="updateClick({{$classes->id}})" class="btn btn-primary"><i class="glyphicon glyphicon-plus" ></i></button></td> @else <td><button type="button" onclick="updateRemove({{$details->id}})" class="btn btn-danger"><i class="glyphicon glyphicon-remove" ></i></button></td> @endif </tr>@endforeach</tbody>');
			}
			@endif
		@endforeach
		});
	}
	function updateClick(id)
	{
		$("#tableRow"+id).append('<tr id="updateDelete'+id+'"><td><select class="form-control" name="day[]">@foreach($day as $days)<option value="{{$days->id}}">{{$days->dayName}}</option>@endforeach</td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="morning[]" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option> @endif @endfor @endfor</select></div></td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="afternoon[]" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($i<17) @if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option>@endif @endif @if($i==17 && $a==0)<option value="{{$i}}:00">{{$i}}:00</option>@endif @endfor @endfor</select></div></td><td><select name="breaktime[]" class="form-control" >@for($a=1;$a<5;$a++)<option value="{{$a*15}}">{{$a*15}}</option>@endfor</select></td><td><button type="button" onclick="updateRemove('+id+')" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></button></td></tr>');
	}

	function updateRemove(id)
	{
		console.log(id)
		$('#updateDelete'+id).remove();
		i--;
	}


	@foreach($class as $classes)
		@if(count($classes->groupapplicationdetail)==0)
			$('#updateModal{{$classes->id}}').on('hidden.bs.modal',function(){
				@foreach($classes->schedule->scheduledetail as $details)
				$('#updateDelete{{$details->id}}').remove();
				i--;
				@endforeach;
		    });
		@endif
	@endforeach
</script>
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
</script>

<script type="text/javascript">
	    $(".form_datetime").datetimepicker({
	        format: "MM dd,yyyy",
			startDate: "{{Carbon\Carbon::today()->format('Y-m-d')}}",
			daysOfWeekDisabled: [0],
	        weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			minView: 2,
			maxView: 4,
			forceParse: 0,
			viewSelect:'month'
	    });
</script> 
<script>
	$(document).ready( function(){
		var table = $('#table1').DataTable({
		});
	});
	$("#transaction").last().addClass( "active" );
	$("#manage_enrollment").last().addClass( "active" );
	function changes(){
		var building_id = $('#building').val();
		var floor_id = 0;
		$.ajax({
			type:'get',
			url:'{!!URL::to('ajax-floor')!!}',
			data:{'id':building_id},
			success:function(data){
				$('#floor').empty();
				floor_id = data[0].id;
				for(var i=0;i<data.length;i++){
					$('#floor').append('<option value="'+data[i].id+'">'+data[i].floorName+'</option>');
				}

				$.ajax({
					type:'get',
					url:'{!!URL::to('ajax-floor-and-room')!!}',
					data:{'building_id':building_id,'floor_id':floor_id},
					success:function(data){
						$('#rooms').empty();
						for(var i=0;i<data.length;i++){
							$('#rooms').append('<option value="'+data[i].id+'">'+data[i].room_no+'</option>');

						}
					},
				});
			},
		});
	}
	function floorchange(){
		var floor_id = $("#floor").val();
		$.ajax({
			type:'get',
			url:'{!!URL::to('ajax-room')!!}',
			data:{'floor_id':floor_id},
			success:function(data){
				$('#rooms').empty();
				for(var i=0;i<data.length;i++){
					$('#rooms').append('<option value="'+data[i].id+'">'+data[i].room_no+'</option>');
				}
			},
		});
	}

	function updateScheduleClicked(tclasses_id){
		$.ajax({
			type:'get',
			url:'{!!URL::to('ajax-enrollee-schedule-fill')!!}',
			data:{'tclasses_id':tclasses_id},
			success:function(data){
				console.log('success');
				$('#rooms').empty();
						console.log(data.length);
				for(var i=0;i<data.length;i++){
					$('#rooms').append('<option value="'+data[i].id+'">'+data[i].room_no+'</option>');
				}
			},
		});
	}

</script>
<script type="text/javascript">
	$(document).ready( function(){
		@foreach($tclass as $tclasses)
			var dateStart = moment("{{Carbon\Carbon::parse($tclasses['dateStart'])->subDays(5)->format('Y-m-d')}}");
			@if($tclasses['status'] == 1)
			@if(Carbon\Carbon::parse($tclasses['dateStart'])->subDays(5)->lte(Carbon\Carbon::today()))
				console.log("{{$tclasses['total'] .' '. $tclasses['min_student']}}")
				@if($tclasses['total'] < $tclasses['min_student'])
					$('#row{{$tclasses["id"]}}').addClass(" rowColor ");
				@endif
			@endif
			@endif
		@endforeach
	});
</script>
<script type="text/javascript">
	function cancelClick(id){
		@foreach($tclass as $tclasses)
			if({{$tclasses['id']}} == id)
			{
				@if($tclasses['total']>0)
					$('#span'+id).text("Are you sure you want to cancel this schedule and refund payments of all enrolled student?");
				@endif
			}
		@endforeach
	}
</script>
<script>
$(document).ready(function() {
/* initialize the external events
         -----------------------------------------------------------------*/
function ini_events(ele) {
    ele.each(function() {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
            title: $.trim($(this).text()) // use the element's text as the event title
        };

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject);

        // make the event draggable using jQuery UI

    });
}
ini_events($('#external-events div.external-event'));

/* initialize the calendar
         -----------------------------------------------------------------*/
//Date for the calendar events (dummy data)
var date = new Date();
var d = date.getDate(),
    m = date.getMonth(),
    y = date.getFullYear();
@foreach($tclass as $tclasses)
$('#calendar{{$tclasses["id"]}}').fullCalendar({
	
    header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month'
    },
    buttonText: {
        prev: "<span class='fa fa-caret-left'></span>",
        next: "<span class='fa fa-caret-right'></span>",
        today: 'today',
        month: 'month',
        week: 'week',
        day: 'day'
    },
    //Random events
	
    events: [
		@foreach($tclasses['dayschedule'] as $scheds)
		{
			id: '{{Carbon\Carbon::parse($scheds["date"])->format('Y-m-d')}}',
	        title: '{{$scheds['time']}}',
	        start: '{{Carbon\Carbon::parse($scheds["date"])->format('Y-m-d')}}',
	        backgroundColor: "#418BCA"
    	}, 
		@endforeach
		@foreach($holiday as $holidays){
			id: "{{$holidays->id}}",
			title: '{{$holidays->holidayName}}',
			start: "{{Carbon\Carbon::parse($holidays->dateStart)->format('Y-m-d')}}",
			end: "{{Carbon\Carbon::parse($holidays->dateEnd)->format('Y-m-d')}}"
		},
		@endforeach
		@foreach($sessionday as $sessiondays){
			id: "{{$sessiondays->id}}",
			title: '{{$sessiondays->description}}',
			start: "{{Carbon\Carbon::parse($sessiondays->dateStart)->format('Y-m-d')}}",
			end: "{{Carbon\Carbon::parse($sessiondays->dateEnd)->format('Y-m-d')}}",
            backgroundColor: "#F89A14"
		},
		@endforeach
		
	],
	eventClick: function(event, jsEvent, view){
		console.log(event.start);
	},
    drop: function(date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject');

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject);

        // assign it the date that was reported
        copiedEventObject.start = date;
        copiedEventObject.allDay = allDay;
        copiedEventObject.backgroundColor = $(this).css("background-color");
        copiedEventObject.borderColor = $(this).css("border-color");

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

    }
});
@endforeach
/* ADDING EVENTS */
var currColor = "#418BCA"; //default
//Color chooser button
});
</script>
@endsection