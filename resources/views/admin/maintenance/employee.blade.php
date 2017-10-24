@extends('admin.layouts.default')

@section('css')
<link href="/vendors/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" />
<link href="/vendors/panel/panel.css" rel="stylesheet" type="text/css"/>
<link href="/css/flat/blue.css" rel="stylesheet">
<link href="/css/all.css?v=1.0.2" rel="stylesheet">
@endsection

@section('content')
<!-- Content Header (Page header) -->
<style type="text/css">

	.buttons{
		margin-top: 10px;
		margin-bottom: 20px;
	}
	.modal-xl{
		width: 85%;
	}
</style>
<section class="content-header">
	<!--section starts-->
	<h1>Employee</h1>
	<ol class="breadcrumb">
		<li>
			<a href="{{url('/admin')}}">
				<i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
				Home
			</a>
		</li>
		<li>
			<a >Maintenance</a>
		</li>
		<li class="active">Employee</li>
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
					<div class="col-md-6">
						<button class="buttons btn btn-success" data-toggle="modal" data-href="#responsive" href="#responsive"><i class="glyphicon glyphicon-plus"></i>&ensp;New Employee</button>
					</div>
					<table class="table table-striped table-bordered" id="table1">
						<thead>
							<tr>
								<th width="20%">Name</th>
								<th width="30%">Address</th>
								<th width="10%">Gender</th>
								<th width="5%">Age</th>
								<th width="15%">Position</th>
								<th width="10%"></th>
								<th width="10%"></th>
							</tr>
						</thead>
						<tbody>
							@foreach($employee as $employees)
							<tr>
								<td>{{$employees->firstName . ' ' . $employees->middleName . ' '. $employees->lastName}}</td>
								<td>{{$employees->street . ' ' . $employees->barangay . ' ' . $employees->city}}</td>
								<td>@if($employees->gender == 'F')Female @else Male @endif</td>
								<td>{{Carbon\Carbon::createFromFormat('Y-m-d',$employees->dob)->age}}</td>
								<td>{{$employees->user->position->positionName}}</td>
								<td align="center"><button class="btn btn-primary" data-toggle="modal" data-href="#update{{$employees->id}}" href="#update{{$employees->id}}">Update</button></td>
								<td align="center"><form action="/employee/delete" method="post">{{csrf_field()}}<input type="hidden" name="id" value="{{$employees->id}}"><button type="submit" class="btn btn-danger">Deactivate</button></form></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Create Modal -->
<div class="modal fade in" id="responsive" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form id="create-form" action="/employee/insert" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<div class="modal-header btn-primary" >
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">New Employee</h4>
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
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">First Name<font color="red">*</font></label>
								<div class="col-sm-8">
									<input required type="text" class="form-control" name="firstName">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Middle Name</label>
								<div class="col-sm-8">
									<input type="text" class="form-control " name="middleName">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Last Name<font color="red">*</font></label>
								<div class="col-sm-8">
									<input required type="text" class="form-control " name="lastName">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Gender<font color="red">*</font></label>
	              <label class="radio-inline">
	                  <input class="selector" type="radio" name="gender" id="male" value="M" checked>Male
	              </label>
	              <label class="radio-inline">
	                  <input class="selector" type="radio" name="gender" id="female" value="F">Female
	              </label>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Date of Birth<font color="red">*</font></label>
								<div class="col-sm-8">
									<div class="input-group date form_datetime"  data-date-format="MM dd, yyyy" data-link-field="dtp_input1">
										<input class="form-control" size="16" type="text" value="" readonly name="dob" id="dob" onchange="dobChanged(this)">
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-th"></span>
										</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Age</label>
								<div class="col-sm-8">
									<input required type="text" id="age" class="form-control" name="age" disabled="">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Street<font color="red">*</font></label>
								<div class="col-sm-8">
									<input required type="text" class="form-control " name="street">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Barangay<font color="red">*</font></label>
								<div class="col-sm-8">
									<input required type="text" class="form-control " name="barangay">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">City<font color="red">*</font></label>
								<div class="col-sm-8">
									<input required type="text" class="form-control " name="city">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Position<font color="red">*</font></label>
								<div class="col-sm-8">
									<select required name="position_id" class="form-control">
										@foreach($position as $positions)
										<option value="{{$positions->id}}">{{$positions->positionName}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-md-4 control-label">Contact<font color="red">*</font></label>
								<div class="col-md-8" style="padding-right: 0px; padding-left: 0px; ">
									<div class="col-md-6" style="padding-right: 0px;">
										<select name="contactType" id="contactType" class="selector form-control" style="padding: 0px; width: 80%;" onchange="contactTypeChanged(this)">
				                <option selected value="mobile">Mobile No.</option>
				                <option value="tel">Landline No.</option>
				            </select>
			            </div>
			            <div class="col-md-6" id="contactC" style="padding-left: 0px;">
										<input type="text" id="contact" class="selector cp form-control placeholder" name="contact" placeholder="0999 9999 999">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Email<font color="red">*</font></label>
								<div class="col-sm-8">
									<input required name="email" type="email" class="form-control">
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

<!-------------------------------Update Modal------------------------------------------ -->
		@foreach($employee as $employees)
		<div class="modal fade in" id="update{{$employees->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
			<div class="modal-dialog modal-xl">
				<div class="modal-content">
					<form  action="/employee/update" method="post" class="form-horizontal">
						{{csrf_field()}}
						<div class="modal-header btn-primary">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title">Update Employee</h4>
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
								<div class="col-md-6">
									<input type="hidden" name="id" value="{{$employees->id}}">
									<input type="hidden" name="user_id" value="{{$employees->user_id}}">
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-4 control-label">First Name<font color="red">*</font></label>
										<div class="col-sm-8">
											<input required type="text" value="{{$employees->firstName}}" class="form-control " name="firstName">
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-4 control-label">Middle Name</label>
										<div class="col-sm-8">
											<input type="text" value="{{$employees->middleName}}" class="form-control " name="middleName">
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-4 control-label">Last Name<font color="red">*</font></label>
										<div class="col-sm-8">
											<input required type="text" value="{{$employees->lastName}}" class="form-control " name="lastName">
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-4 control-label">Gender<font color="red">*</font></label>
										<div class="col-sm-8">
											@if($employees->gender == 'M')
												<label class="radio-inline " for="example-inline-radio1">
												<label class="radio-inline">
					                  <input class="selector" type="radio" name="gender" required id="male" value="M" checked>Male
					              </label>
					              <label class="radio-inline">
					                  <input class="selector" type="radio" name="gender" required id="female" value="F">Female
					              </label>
											@else
												<label class="radio-inline">
					                  <input class="selector" type="radio" name="gender" required id="male" value="M">Male
					              </label>
					              <label class="radio-inline">
					                  <input class="selector" type="radio" name="gender" required id="female" value="F" checked>Female
					              </label>
											@endif
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-4 control-label">Date of Birth<font color="red">*</font></label>
										<div class="col-sm-8">
											<input required type="date" value="{{$employees->dob}}" name="dob" class="form-control" onchange="dobChanged(this)">
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-4 control-label">Street<font color="red">*</font></label>
										<div class="col-sm-8">
											<input required type="text" value="{{$employees->street}}" class="form-control " name="street">
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-4 control-label">Barangay<font color="red">*</font></label>
										<div class="col-sm-8">
											<input required type="text" value="{{$employees->barangay}}" class="form-control " name="barangay">
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-4 control-label">City<font color="red">*</font></label>
										<div class="col-sm-8">
											<input required type="text" value="{{$employees->city}}" class="form-control " name="city">
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-4 control-label">Position<font color="red">*</font></label>
										<div class="col-sm-8">
											<select required name="position_id" class="form-control">
												@foreach($position as $positions)
												@if($positions->positionName == $employees->user->position->positionName)
												<option selected value="{{$positions->id}}">{{$positions->positionName}}</option>
												@else
												<option value="{{$positions->id}}">{{$positions->positionName}}</option>
												@endif
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-md-4 control-label">Contact<font color="red">*</font></label>
										<div class="col-md-8" style="padding-right: 0px; padding-left: 0px; ">
											<div class="col-md-6" style="padding-right: 0px;">
												<select name="contactType" id="contactType{{$employees->id}}" class="selector form-control" style="padding: 0px; width: 80%;" onchange="contactTypeChanged1({{$employees->id}})">
						                @if(strlen($employees->contact) >= 11)
							                <option selected value="mobile">Mobile No.</option>
							                <option value="tel">Landline No.</option>
							              @else
							              	<option  value="mobile">Mobile No.</option>
							                <option selected value="tel">Landline No.</option>
							              @endif
						            </select>
					            </div>
					            <div class="col-md-6" id="contactC{{$employees->id}}" style="padding-left: 0px;">
					            	@if(strlen($employees->contact) >= 11)
					                <input type="text" id="contact" class="selector cp form-control placeholder" value="{{$employees->contact}}" name="contact" placeholder="0999 9999 999">
					              @else
					              	<input type="text" id="contact" name="contact" class="tel form-control placeholder" value="{{$employees->contact placeholder="999 9999">
							          @endif 	

											</div>
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


		@endforeach
		@endsection
		@section('js')
		<script type="text/javascript" src="/vendors/datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
		<script type="text/javascript" src="/js/moment.min.js" charset="UTF-8"></script>
    <script src="/js/icheck.js" type="text/javascript"></script>
		<script src="/vendors/iCheck/icheck.js" type="text/javascript"></script>
		<script src="/vendors/input-mask/jquerymask.js" type="text/javascript"></script>

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
		</script> 

		<script type="text/javascript">
      $('.tel').mask('000 0000',
      {
            "placeholder": "--- ----"
      });

      $('.cp').mask('0000 0000 000',
      {
            "placeholder": "---- ---- ---"
      });
		</script>

		<script type="text/javascript">
			function dobChanged(dob){
				var age = moment(dob.value,"MMM D, YYYY").fromNow(true);
				$('#age').val(age+' old');
			}
		</script>

		<script>
			$(document).ready( function(){
				var table = $('#table1').DataTable();
			});

			$(document).ready(function(){
			  $('input').iCheck({
			    checkboxClass: 'icheckbox_flat-blue',
			    radioClass: 'iradio_flat-blue'
			  });
			});
		</script>

		<script type="text/javascript">
    
    function contactTypeChanged(contactType){
      if(contactType.value == "tel"){
        $("#contactC").empty();
        $("#contactC").append('<input type="text" id="contact" name="contact" class="tel form-control placeholder" placeholder="999 9999">')
        
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
        
        $("#contactC").empty();
        $("#contactC").append('<input type="text" id="contact" name="contact" class="cp form-control placeholder" placeholder="0999 9999 999">')
        
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

    function contactTypeChanged1(id){
      if($('#contactType'+id).val() == "tel"){
        $("#contactC"+id).empty();
        $("#contactC"+id).append('<input type="text" id="contact" name="contact" class="tel form-control placeholder" placeholder="999 9999">')
        
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
        
        $("#contactC"+id).empty();
        $("#contactC"+id).append('<input type="text" id="contact" name="contact" class="cp form-control placeholder" placeholder="0999 9999 999">')
        
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