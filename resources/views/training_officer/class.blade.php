@extends('training_officer.layouts.default')

@section("css")
<link href="/css/all.css?v=1.0.2" rel="stylesheet">
<link href="/css/flat/blue.css" rel="stylesheet">
<link href="/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen" />
<link href="/vendors/panel/panel.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="{{ asset('/css/toastr.min.css') }}">
<link rel="stylesheet" type="text/css" href="\vendors\bootstrap3-editable\css\bootstrap-editable.css">

@endsection
@section('content')
<style type="text/css">
h2{
	font-size: 30px;
	font-weight: 700;
}
.modal-xl{
	width: 90%;
}
</style>


<!-- Content Header (Page header) -->
<section class="content-header">
	<!--section starts-->
	<ol class="breadcrumb">
		<li>
			<a href="/tofficer">
				<i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
				Home
			</a> 
		</li>
		<li class="active">Class</li>
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
					<div class="col-md-12">
						<div class="form-horizontal">
							<h4><b>Course : &ensp;{{$tclass->scheduledprogram->rate->program->programName . ' (' . $tclass->scheduledprogram->rate->duration . ' Hours)'}}</b></h4>
							<h4><b>Training Officer : &ensp;{{$tclass->scheduledprogram->trainingofficer->firstName . ' ' . $tclass->scheduledprogram->trainingofficer->middleName . ' ' .$tclass->scheduledprogram->trainingofficer->lastName}}</b></h4>
							<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
							<h4><b>Class Name : &ensp;<a id="text" data-type="text" data-pk="{{$tclass->id}}" data-url="/update-class" data-title="Edit Session Name">{{$tclass->class_name}}</a>&ensp;<button id="toggleEdit1" class="btn btn-primary btn-sm"><i id="toggleEdit2" class="glyphicon glyphicon-pencil"></i></button></b></h4>
							@if($tclass->status != 1 && $tclass->status != 0)
							<div style="margin-bottom: 20px;">
								<a href="/tofficer/class/attendance" class="btn btn-primary"><i class="glyphicon glyphicon-calendar"></i>&ensp;Set Attendance</a>
								<a href="/tofficer/class/grade" class="btn btn-info"><i class="glyphicon glyphicon-list-alt"></i>&ensp;Set Grades</a>	
							</div>
							@endif
						</div>
						<table class="table table-striped" id="table1">
							<thead>
								<tr>
									<th width="20%">Student Number</th>
									<th width="50%">Student Name</th>
									<th width="30%">Action</th>
								</tr>
							</thead>
							<tbody>
								@if(count($tclass->groupclassdetail)!=0)
								<input type="hidden" class="class_type" id="class_type" value="2">
								@foreach($tclass->groupclassdetail as $details)
								<tr>
									<td>{{$details->groupenrollee->studentNumber}}<input type="hidden" name="groupclassdetail_id[]" value="{{$details->id}}"></td>
									<td>{{$details->groupenrollee->lastName . ', ' . $details->groupenrollee->firstName}}</td>
								</tr>
								@endforeach
								@else
								<input type="hidden" class="class_type" id="class_type" value="1">
								@foreach($tclass->classdetail as $details)
								@if($details->status != 0)
								<tr>
									<td>{{$details->enrollee->studentNumber}}</td><input type="hidden" name="classdetail_id[]" value="{{$details->id}}">
									<td>{{$details->enrollee->firstName . ' ' . $details->enrollee->middleName . ' ' . $details->enrollee->lastName}}</td>
									<td><form>@if(count($details->enrollee->trainingattend)>0)<button  data-toggle="modal" onclick="counter({{$details->enrollee->trainingattend->sum('id')}},{{$details->id}})" data-href="#studentUpdate{{$details->id}}" href="#studentUpdate{{$details->id}}" type="button" class="btn btn-primary" onclick="clicks({{$details->id}})"><i class="glyphicon glyphicon-edit"></i>&ensp; Update</button>@else<button  data-toggle="modal" onclick="counter(0, {{$details->id}})" data-href="#studentUpdate{{$details->id}}" href="#studentUpdate{{$details->id}}" type="button" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i>&ensp; Update</button>@endif</form></td>
								</tr>
								@endif
								@endforeach
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Update Student -->
	<!-- Dialog Box Confirmation -->
	@if(count($tclass->classdetail)>0)
	@foreach($tclass->classdetail as $details)
		<div class="modal fade in" id="studentUpdate{{$details->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
			<div class="modal-dialog modal-xl">
				<div class="modal-content">
					<form action="/tofficer/class/enrollee/update" id="update-form{{$details->id}}" method="post" class="form-horizontal">
						{{ csrf_field() }} 	
						<input type="hidden" name="tclass_id" value="{{$details->trainingclass_id}}"/>
						<input type="hidden" name="enrollee_id" value="{{$details->enrollee_id}}">
						<input type="hidden" name="contactperson_id" value="{{$details->enrollee->contactperson_id}}">
						<input type="hidden" name="educationalbackground_id" value="{{$details->enrollee->educationalbackground_id}}">
						@if(count($details->enrollee->seaexperience)>0)
						<input type="hidden" name="seaexperience_id" value="{{$details->enrollee->seaexperience->id}}">
						@endif
						@if(count($details->enrollee->trainingattend)>0)
						@foreach($details->enrollee->trainingattend as $attends)
						<input type="hidden" name="trainingattend_id[]" value="{{$attends->id}}">
						@endforeach
						@endif
						<div class="modal-header btn-primary">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title">Update Trainee</h4>
						</div>
						<div class="modal-body">
							<div class="row">

								<div class="row">
									<div class="col-md-4">
										<div class="alert alert-success">
												<p><em>Note: <font color="red">*</font> fields are required</em></p>
										</div>
									</div>
								</div>
								<div class="col-md-12">
					                <div class="panel panel-primary" style="margin-top: 0px;">
					                    <div class="panel-heading">
					                        <h3 class="panel-title">
					                            <i class="livicon" data-name="user" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
					                            Personal Information
					                        </h3>
					                        <span class="pull-right clickable">
					                            <i class="glyphicon glyphicon-chevron-up"></i>
					                        </span>
					                    </div>
					                    <div class="panel-body">
					                        <div class="row form-group">
					                            <div class="col-md-4">
				                                    <div class="input-group">
				                                        <span class="input-group-addon">First Name<font color="red">*</font></span>
				                                        <input id="1firstName" type="text" class="selector form-control capital" name="firstName" value="{{$details->enrollee->firstName}}">
				                                    </div>
					                            </div>
					                            <div class="col-md-4">
				                                    <div class="input-group">
				                                        <span class="input-group-addon">Middle Name</span>
				                                        <input id="1middleName" type="text" class="selector form-control capital" name="middleName" value="{{$details->enrollee->middleName}}">
				                                    </div>
					                            </div>
					                            <div class="col-md-4">
				                                    <div class="input-group">
				                                        <span class="input-group-addon">Last Name<font color="red">*</font></span>
				                                        <input id="1lastName" type="text" class="selector form-control capital" name="lastName" value="{{$details->enrollee->lastName}}">
				                                    </div>
					                            </div>
					                        </div>
					                        <div class="row form-group">
					                            <div class="col-md-4">
				                                    <div class="input-group">
				                                        <span>Gender<font color="red">*</font></span>
				                                        <label class="radio-inline">
				                                            <input class="selector" type="radio" name="gender" required id="male" value="M" checked>Male
				                                        </label>
				                                        <label class="radio-inline">
				                                            <input class="selector" type="radio" name="gender" required id="female" value="F">Female
				                                        </label>
				                                    </div>
					                            </div>
					                            <div class="col-md-4">
				                                    <div class="input-group">
				                                        <span class="input-group-addon">Civil Status<font color="red">*</font></span>
				                                        <select name="civilStatus" id="civilStatus" class="selector form-control">
				                                            <option  id="option1" selected disabled>--Select Civil Status--</option>
				                                            @foreach($cstatus as $cstatuses)
				                                            @if($cstatuses->id == $details->enrollee->civilstatus->id)
				                                            	<option selected value="{{$cstatuses->id}}">{{$cstatuses->statusName}}</option>
				                                            @else
				                                            	<option value="{{$cstatuses->id}}">{{$cstatuses->statusName}}</option>
				                                            @endif
				                                            @endforeach
				                                        </select>
				                                    </div>
					                            </div>
					                        </div>
					                        <div class="row">
					                            <div class="col-md-4">
					                                <div class="input-group date form_datetime"  data-date-format="MM dd, yyyy" data-link-field="dtp_input1">
					                                    <span class="input-group-addon">Birthdate<font color="red">*</font></span>
					                                    <input class="form-control" size="16" type="text" readonly name="dob" id="1dob"  value="{{Carbon\Carbon::parse($details->enrollee->dob)->format('F d, Y')}}" onchange="dobChanged(this)">
					                                    <span class="input-group-addon">
					                                        <span class="glyphicon glyphicon-th"></span>
					                                    </span>
					                                </div>
					                            </div>
	                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">Age</span>
                                            <input type="text" id="age" class="form-control" name="age" readonly="readonly" maxlength="3" value="{{Carbon\Carbon::parse($details->enrollee->dob)->age}}">
                                        </div>
	                                    </div>
					                            <div class="col-md-4">
				                                    <div class="input-group">
				                                        <span class="input-group-addon">Birthplace<font color="red">*</font></span>
				                                        <input type="text" id="1dop" class="selector form-control" name="dop" value="{{$details->enrollee->birthPlace}}">
				                                    </div>
					                            </div>
					                        </div>
					                    </div>
					                </div>
					            </div>
					            <div class="col-md-12">
					                <div class="panel panel-primary">
					                    <div class="panel-heading">
					                        <h3 class="panel-title">
					                            <i class="livicon" data-name="home" data-size="18" data-c="#fff" data-hc="white" data-loop="true"></i>
					                            Home Address
					                        </h3>

					                        <span class="pull-right clickable">
					                            <i class="glyphicon glyphicon-chevron-up"></i>
					                        </span>
					                    </div>
					                    <div class="panel-body">
					                        <h2 class="hidden">&nbsp;</h2>
					                        <div class="row">
					                            <div class="col-md-4">
				                                    <div class="input-group">
				                                        <span class="input-group-addon">Street<font color="red">*</font></span>
				                                        <input type="text" id="1street" value="{{$details->enrollee->street}}" class="selector form-control capital" name="street">
				                                    </div>
					                            </div>
					                            <div class="col-md-4">
				                                    <div class="input-group">
				                                        <span class="input-group-addon">Barangay<font color="red">*</font></span>
				                                        <input type="text" id="1barangay" value="{{$details->enrollee->barangay}}" class="selector form-control capital" name="barangay">
				                                    </div>
					                            </div>
					                            <div class="col-md-4">
				                                    <div class="input-group">
				                                        <span class="input-group-addon">City<font color="red">*</font></span>
				                                        <input type="text" id="1city" value="{{$details->enrollee->city}}" class="selector form-control capital" name="city">
				                                    </div>
					                            </div>
					                        </div>
					                    </div>
					                </div>
					            </div>
					            <div class="col-md-6">
					                <div class="panel panel-primary">
					                    <div class="panel-heading">
					                        <h3 class="panel-title">
					                            <span class="glyphicon glyphicon-earphone"></span>&ensp; Contact Information
					                        </h3>

					                        <span class="pull-right clickable">
					                            <i class="glyphicon glyphicon-chevron-up"></i>
					                        </span>
					                    </div>
					                    <div class="panel-body">
					                        <h2 class="hidden">&nbsp;</h2>
					                        <div class="row form-group">
					                            <div class="col-md-8">
				                                    <div id="contactC" class="input-group">
				                                        <span class="input-group-addon">Contact<font color="red">*</font></span>
	                                            		@if(strlen($details->enrollee->contact) < 9)
	                                                <input type="text" id="1contactI" name="contact" class="tel form-control placeholder selector" placeholder="e.g: 999 9999" value="{{$details->enrollee->contact}}">
	                                                @else
	                                                <input type="text" id="1contactI" name="contact" class="cp form-control placeholder selector" placeholder="e.g: 0999 9999 999" value="{{$details->enrollee->contact}}">
	                                                @endif
				                                    </div>
					                            </div>
					                            <div class="col-md-4">
					                                <select name="contactType" id="contactType" class="selector form-control" onchange="changeContactType(this)">
					                                    @if(strlen($details->enrollee->contact) < 9)
	                                                <option value="mobile">Mobile No.</option>
	                                                <option selected value="tel">Landline No.</option>
	                                              @else
	                                                <option selected value="mobile">Mobile No.</option>
	                                                <option value="tel">Landline No.</option>
	                                              @endif
					                                </select>
					                            </div>
					                        </div>
					                        <div class="row">
					                            <div class="col-md-12">
				                                    <div class="input-group">
				                                        <span class="input-group-addon">Email<font color="red">*</font></span>
				                                        <input type="email" value="{{$details->enrollee->email}}" id="1email" class="form-control selector" name="email">
				                                    </div>
					                            </div>
					                        </div>
					                    </div>
					                </div>
					            </div>
					            <div class="col-md-6">
					                <div class="panel panel-primary">
					                    <div class="panel-heading">
					                        <h3 class="panel-title">
					                            <span class="glyphicon glyphicon-phone-alt"></span>&ensp;Contact In Case Of Emergency
					                        </h3>
					                        <span class="pull-right clickable">
					                            <i class="glyphicon glyphicon-chevron-up"></i>
					                        </span>
					                    </div>
					                    <div class="panel-body">
					                        <h2 class="hidden">&nbsp;</h2>
					                        <div class="row form-group">
					                            <div class="col-md-12">
				                                    <div class="input-group">
				                                        <span class="input-group-addon">Name<font color="red">*</font></span>
				                                        <input type="text" id="1Ename" value="{{$details->enrollee->contactperson->name}}" class="selector form-control capital" name="Ename">
				                                    </div>
					                            </div>
					                        </div>
					                        <div class="row form-group">
					                            <div class="col-md-12">
				                                    <div class="input-group">
				                                        <span class="input-group-addon">Relationship<font color="red">*</font></span>
				                                        <input type="text" id="1Erel" value="{{$details->enrollee->contactperson->relationship}}" class="selector form-control capital" name="Erel">
				                                    </div>
					                            </div>
					                        </div>
					                        <div class="row form-group">
		                                <div class="col-md-8">
                                        <div id="contactE" class="input-group">
                                            <span class="input-group-addon">Contact<font color="red">*</font></span>
                                            @if(strlen($details->enrollee->contactperson->contact) < 9)
                                            <input type="text" id="1Econtact" value="{{$details->enrollee->contactperson->contact}}" class="selector tel form-control placeholder" name="Econtact" placeholder="e.g: 0999 9999 999">
                                            @else
                                            <input type="text" id="1Econtact" value="{{$details->enrollee->contactperson->contact}}" class="selector cp form-control placeholder" name="Econtact" placeholder="e.g: 0999 9999 999">
                                            @endif
                                        </div>
                                    </div>
				                                <div class="col-md-4">
				                                    <select name="EContactType" id="1EContactType" class="selector form-control" onchange="EchangeContactType(this)">
				                                    	@if(strlen($details->enrollee->contactperson->contact) < 9)
				                                        <option value="mobile">Mobile No.</option>
				                                        <option selected value="tel">Landline No.</option>
				                                       @else
				                                        <option selected value="mobile">Mobile No.</option>
				                                        <option value="tel">Landline No.</option>
				                                       @endif
				                                    </select>
				                                </div>
					                      	</div>
					                        <div class="row form-group">
					                            <div class="col-md-12">
				                                    <div class="input-group">
				                                        <span class="input-group-addon">Address<font color="red">*</font></span>
				                                        <textarea class="selector form-control" name="Eaddress" id="1Eaddress">{{$details->enrollee->contactperson->address}}</textarea>
				                                    </div>
					                            </div>
					                        </div>
					                    </div>
					                </div>
					            </div>
					            <div class="col-md-6">
					                <div class="panel panel-primary">
					                    <div class="panel-heading">
					                        <h3 class="panel-title">
					                            <span><i class="ion-university" style="font-size:20px;"></i></span>&ensp;Educational Background
					                        </h3>
					                        <span class="pull-right clickable">
					                            <i class="glyphicon glyphicon-chevron-up"></i>
					                        </span>
					                    </div>
					                    <div class="panel-body">
					                        <h2 class="hidden">&nbsp;</h2>

					                        <div class="row form-group">
					                            <div class="col-md-12">
				                                    <div class="input-group">
				                                        <span class="input-group-addon">Attainment<font color="red">*</font></span>
				                                        <input type="text" id="1EBattainment" value="{{$details->enrollee->educationalbackground->attainment}}" class="selector form-control capital" name="EBattainment">
				                                    </div>
					                            </div>
					                        </div>
					                        <div class="row form-group">
					                            <div class="col-md-12">
				                                    <div class="input-group">
				                                        <span class="input-group-addon">School<font color="red">*</font></span>
				                                        <input type="text" value="{{$details->enrollee->educationalbackground->school}}" id="1EBschool" class="selector form-control capital" name="EBschool">
				                                    </div>
					                            </div>
					                        </div>
					                        <div class="row form-group">
					                            <div class="col-md-12">
				                                    <div class="input-group">
				                                        <span class="input-group-addon">Course<font color="red">*</font></span>
				                                        <input type="text" value="{{$details->enrollee->educationalbackground->course}}" id="1EBcourse" class="selector form-control capital" name="EBcourse">
				                                    </div>
					                            </div>
					                        </div>
					                    </div>
					                </div>
					            </div>
					            <!-- Sea Experience -->
					            <div class="col-md-6">
					                <div class="panel panel-primary">
					                    <div class="panel-heading">
					                        <h3 class="panel-title">
					                            <span><i class="ion-help-buoy" style="font-size:20px;"></i></span>&ensp;Sea Experience
					                        </h3>
					                        <span class="pull-right clickable">
					                            <i class="glyphicon glyphicon-chevron-up"></i>
					                        </span>
					                    </div>
					                    <div class="panel-body">
					                        <h2 class="hidden">&nbsp;</h2>

					                        <div class="row form-group">
					                            <div class="col-md-12">
				                                    <div class="input-group">
				                                        <span class="input-group-addon">No. of Years</span>
				                                        @if(count($details->enrollee->seaexperience)>0)
				                                        <input id="years" type="text" value="{{$details->enrollee->seaexperience->noYears}}" class="selector form-control" name="noYears">
				                                        @else
				                                        <input id="years" type="text" class="selector form-control" name="noYears">
				                                        @endif
				                                    </div>
					                            </div>
					                        </div>
					                        <div class="row form-group">
					                            <div class="col-md-12">
				                                    <div class="input-group">
				                                        <span class="input-group-addon">Rank/Position</span>
				                                        @if(count($details->enrollee->seaexperience)>0)
				                                        <input id="rank" type="text" value="{{$details->enrollee->seaexperience->rank}}" class="selector form-control capital" name="rank">
				                                        @else
				                                        <input id="rank" type="text" class="selector form-control capital" name="rank">
				                                        @endif
				                                    </div>
					                            </div>
					                        </div>
					                    </div>
					                </div>
					            </div>
					            <!-- Trainings Attended  -->
					            <div class="col-md-12">
					                <div class="panel panel-primary filterable" style="overflow:auto;">
					                    <div class="panel-heading">
					                        <h3 class="panel-title">
					                            <span><i class="ion-ribbon-b" style="font-size:20px;"></i></span>&ensp;Trainings Attended
					                        </h3>
					                        <span class="pull-right clickable">
					                            <i class="glyphicon glyphicon-chevron-up"></i>
					                        </span>
					                    </div>
					                    <div class="panel-body">
					                        <div class="col-md-12 table-responded">
					                            <table class="table table-striped table-bordered">
					                                <thead id="dynamic_head">
					                                    <tr>
					                                        <th width="35%">Training Title</th>
					                                        <th width="35%">Training Center</th>
					                                        <th width="20%">Date Taken</th>
					                                        <th width="10%">Action</th>
					                                    </tr>
					                                </thead>
					                                <tbody id="dynamic_field{{$details->id}}">
					                                	@if(count($details->enrollee->trainingattend)>0)
					                                	<input type="hidden" name="hidden" value="{{$x=0}}">
					                                	@foreach($details->enrollee->trainingattend as $attends)
					                                    <tr id="delete{{$attends->id}}">
					                                        <td><input type="text" class="selector form-control capital" value="{{$attends->trainingTitle}}" name="trainingTitle[]"></td>
					                                        <td><input type="text" class="selector form-control capital" value="{{$attends->trainingCenter}}" name="trainingCenter[]"></td>
					                                        <td><input type="date" class="selector form-control" value="{{$attends->dateTaken}}" name="dateTaken[]"></td>
						                                	@if($x==0)
						                                        <td><button type="button" class="selector btn btn-success" value="{{++$x}}" onclick="clicks({{$details->id}})" id="add">Add more</button></td>
						                                    @else
						                                    	<td><button type="button" class="selector btn btn-danger" onclick="remove({{$attends->id}})" id="add">Remove</button></td>
						                                    @endif
					                                    </tr>
					                                	@endforeach
					                                	@else
					                                    <tr>
					                                        <td><input type="text" class="selector form-control capital" name="trainingTitle[]"></td>
					                                        <td><input type="text" class="selector form-control capital" name="trainingCenter[]"></td>
					                                        <td><input type="date" class="selector form-control" name="dateTaken[]"></td>
					                                        <td><button type="button" class="selector btn btn-success" onclick="clicks({{$details->id}})" id="add">Add more</button></td>
					                                    </tr>
					                                    @endif
					                                </tbody>
					                            </table>
					                        </div>
					                    </div>
					                </div>
					            </div>
							</div>
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
	@endif

	<!-- Update Class Name -->

	<div class="modal fade in" id="updateClassName" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<form id="create-form" action="/type/insert" method="post" class="form-horizontal">
					{{ csrf_field() }}
					<div class="modal-header btn-primary">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title">Update Class</h4>
					</div>
					<div class="modal-body">
					</div>
				</form>
			</div>
		</div>
	</div>
	@endsection
	@section('js')
	<script src="/js/icheck.js" type="text/javascript"></script>
	<script src="/vendors/iCheck/icheck.js" type="text/javascript"></script>
	<script src="/js/custom.js"></script>
	<script src="/vendors/touchspin/dist/jquery.bootstrap-touchspin.js"></script>
	<script type="text/javascript" src="/vendors/datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
	<script src="/js/toastr.min.js"></script>
	<script type="text/javascript" src="\vendors\bootstrap3-editable\js\bootstrap-editable.js"></script>
  <script type="text/javascript" src="/js/moment.min.js" charset="UTF-8"></script>
  <script src="/vendors/input-mask/jquerymask.js" type="text/javascript"></script>

	<script type="text/javascript">
		$.fn.editable.defaults.mode = 'popup';
		$.fn.editable.defaults.params = function (params) {
		    params._token = $("#_token").data("token");
		    return params;
		};
		$('#toggleEdit1').click(function(e){
       		e.stopPropagation();
			$('#text').editable('toggle');
		});
		$('#toggleEdit2').click(function(e){
       		e.stopPropagation();
			$('#text').editable('toggle');
		});
		
		$("#text").editable({
        	placement: 'right',
            validate: function(value) {
                if($.trim(value) == '') 
                    return 'This Field is required.';
            },
        	ajaxOptions:{
        		success:function(data){
        			if(data['alert-type'] == "error")
        			{
        				toastr.error(data['message']);
        			}
        			else
        			{
        				toastr.success(data['message']);
        			}
        		}
        	},
		});
	</script>
	<script type="text/javascript">
		$('#table1').DataTable();
	var i = 0;
	function counter(x, id){
		i = x+1;
		console.log(x);
		$.validator.addMethod("regx", function(value, element, regexpr) {          
                return regexpr.test(value);
            }, "No special characters except(hypen ( - ))");

            $.validator.addMethod("regx1", function(value, element, regexpr) {          
                return regexpr.test(value);
            }, "No special characters except(hypen ( - ) and apostrophe ( ' ))");

            $.validator.addMethod("regx2", function(value, element, regexpr) {          
                return regexpr.test(value);
            }, "Allowed characters: ' - ( ) , : ; & / # ");

            $.validator.addMethod("regx3", function(value, element) {          
                return this.optional(element) || /(^[a-zA-Z0-9 \'\-\Ñ\ñ]+$)/i.test(value) || value == "";
            }, "Invalid Input");

            $.validator.addMethod("regx4", function(value, element) {          
                return this.optional(element) || ((/(^[0-9]+$)/i.test(value)) && (value.length == 7 || value.length == 11));
            }, "Invalid Input");

            $.validator.addMethod("adult", function(value, element) {          
            if(value>=18)
                return true;
            }, "Must be 18 years old and above");

            $(function(){
                $('#update-form'+id).validate({
                    ignore:[],
                    rules:{
                        firstName:{
                            required: true,
                            regx1: /(^[a-zA-Z0-9 -\'\Ñ\ñ]+$)/i,
                            space: true,
                        },
                        middleName:{
                            regx3: true,
                            space: true,
                        },
                        lastName:{
                            required: true,
                            regx1: /(^[a-zA-Z0-9 \'\-\Ñ\ñ]+$)/i,
                            space: true,
                        },
                        civilStatus:{
                            required: true
                        },
                        dob:{
                            required: true
                        },
                        age:{
                            adult: true
                        },
                        dop:{
                            required: true,
                            space: true,
                            regx2: /(^[a-zA-Z0-9 \'\-\Ñ\ñ\#\.\,();:/&]+$)/i,
                        },
                        street:{
                            required: true,
                            space: true,
                        },
                        barangay:{
                            required: true,
                            space: true,
                        },
                        city:{
                            required: true,
                            space: true,
                        },
                        contact:{
                            required: true
                        },
                        email:{
                            required: true
                        },
                        Ename:{
                            required: true,
                            regx1: /(^[a-zA-Z0-9 -\'\Ñ\ñ]+$)/i,
                            space: true,
                        },
                        Erel:{
                            required: true,
                            regx1: /(^[a-zA-Z0-9 -\'\Ñ\ñ]+$)/i,
                            space: true,
                        },
                        Econtact:{
                            required: true
                        },
                        Eaddress:{
                            required: true,
                            regx2: /(^[a-zA-Z0-9 \'\-\Ñ\ñ\#\.\,();:/&]+$)/i,
                            space: true,
                        },
                        EBattainment:{
                            required: true,
                            regx2: /(^[a-zA-Z0-9 \'\-\Ñ\ñ\#\.\,();:/&]+$)/i,
                            space: true,
                        },
                        EBschool:{
                            required: true,
                            regx2: /(^[a-zA-Z0-9 \'\-\Ñ\ñ\#\.\,();:/&]+$)/i,
                            space: true,
                        },
                        EBcourse:{
                            space: true,
                        },
                        noYears:{
                            number: true,
                            space: true
                        },
                        rank:{
                            space: true,
                        }
                    },
                    errorPlacement:function(error,element){
                        error.insertAfter(element.parent("div"));
                    },
                });
            });
	}
	function clicks(x){
		$('#dynamic_field'+x).append('<tr id="delete'+i+'"><td><input type="text" class="selector form-control capital" name="trainingTitle[]"></td><td><input type="text" class="selector form-control capital" name="trainingCenter[]"></td><td><input type="date" class="selector form-control" name="dateTaken[]"></td><td><button type="button" onclick="remove('+i+')" class="selector btn btn-danger" id="add">Remove</button></td></tr>');
		i++;
	}
	function remove(x){
		$('#delete'+x).remove();
	}

	 $(document).ready(function(){
	  $('input').iCheck({
	    radioClass: 'iradio_flat-blue'
	  });
	});   
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
    function dobChanged(dob){
        // var age = moment(dob.value,"MMM D, YYYY").fromNow(true);
        // $('#age').val(age+' old');
        var bday=  moment(dob.value,"MMM D, YYYY");
        var today = moment();
        $('#age').val(today.diff(bday,"years"));
        $('#age').valid();
    }
	</script>

<script type="text/javascript">
            
  function changeContactType(contactType){
      if(contactType.value == "tel"){
           {{--  document.getElementById('contact').value = "";
          $("#contact").removeClass("cp").addClass("tel").attr("placeholder":"e.g: 0999 9999 999");
          console.log("tel");   --}}
          $("#contactC").empty();
          $("#contactC").append('<span class="input-group-addon">Contact<font color="red">*</font></span><input type="text" id="1contactI" name="contact" class="tel form-control placeholder selector" placeholder="e.g: 999 9999">')
          
          
          $('.tel').mask('000 0000',
          {
              "placeholder": "--- ----"
          });

          $('.cp').mask('0000 0000 000',
          {
              "placeholder": "---- ---- ---"
          });
      }
      else{
          {{--  document.getElementById('contact').value = "";
          $("#contact").removeClass("tel").addClass("cp").attr("placeholder":"e.g: 999 9999");
          console.log("cp");  --}}
          
          $("#contactC").empty();
          $("#contactC").append('<span class="input-group-addon">Contact<font color="red">*</font></span><input type="text" id="1contactI" name="contact" class="cp form-control placeholder selector" placeholder="e.g: 0999 9999 999">')
          
          $('.tel').mask('000 0000',
       		{
              "placeholder": "--- ----"
          });

          $('.cp').mask('0000 0000 000',
          {
              "placeholder": "---- ---- ---"
          });
      }
  }

</script>

<script type="text/javascript">
  function EchangeContactType(contactType){
      if(contactType.value == "tel"){
           {{--  document.getElementById('Econtact').value = "";
          $("#contact").removeClass("cp").addClass("tel").attr("placeholder":"e.g: 0999 9999 999");
          console.log("tel");   --}}

          $("#contactE").empty();
          $("#contactE").append('<span class="input-group-addon">Contact<font color="red">*</font></span><input type="text" id="1Econtact" name="Econtact" class="tel form-control placeholder selector" placeholder="e.g: 999 9999">');

          
          $('.tel').mask('000 0000',
          {
              "placeholder": "--- ----"
          });

          $('.cp').mask('0000 0000 000',
          {
              "placeholder": "---- ---- ---"
          });
      }
      else{
          {{--  document.getElementById('contact').value = "";
          $("#contact").removeClass("tel").addClass("cp").attr("placeholder":"e.g: 999 9999");
          console.log("cp");  --}}

          $("#contactE").empty();

          $("#contactE").append('<span class="input-group-addon">Contact<font color="red">*</font></span><input type="text" id="1EContact" name="Econtact" class="cp form-control placeholder selector" placeholder="e.g: 0999 9999 999">');
          
          $('.tel').mask('000 0000',
          {
              "placeholder": "--- ----"
          });

          $('.cp').mask('0000 0000 000',
          {
              "placeholder": "---- ---- ---"
          });
      }
  }

</script>
@endsection