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
</style>
<section class="content-header">
	<!--section starts-->
	<h1>Training Officer Maintenance</h1>
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
		<li class="active">Training Officer</li>
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
						<button class="buttons btn btn-success" data-toggle="modal" data-href="#responsive" href="#responsive"><i class="glyphicon glyphicon-plus"></i>&ensp;New Training Officer</button>
					</div>
					<div class="col-md-6 text-right">
						<a href="/maintenance/tofficer/archive" class="buttons btn btn-success"><i class="glyphicon glyphicon-folder-open"></i>&ensp;Archive</a>
					</div>
					<table class="table table-striped table-bordered" id="table1">
						<thead>
							<tr>
								<th width="25%">Name</th>
								<th width="40%">Address</th>
								<th width="10%">Gender</th>
								<th width="5%">Age</th>
								<th width="20%">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($tofficer as $tofficers)
							<tr>
								<td>{{$tofficers->firstName . ' ' . $tofficers->middleName . ' '. $tofficers->lastName}}</td>
								<td>{{$tofficers->street . ' ' . $tofficers->barangay . ' ' . $tofficers->city}}</td>
								<td>@if($tofficers->gender == 'F')Female @else Male @endif</td>
								<td>{{Carbon\Carbon::createFromFormat('Y-m-d',$tofficers->dob)->age}}</td>
								<td align="center"><button class="btn btn-primary" data-toggle="modal" data-href="#update{{$tofficers->id}}" onclick="clicks({{$tofficers->id}})" href="#update{{$tofficers->id}}">Update</button>
								<button type="submit" data-toggle="modal" data-href="#static{{$tofficers->id}}" href="#static{{$tofficers->id}}" class="btn btn-danger">Deactivate</button></td>
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
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form id="create-form" action="/tofficer/insert" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<div class="modal-header btn-primary">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">New Training Officer</h4>
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
									<input required type="text" class="form-control" name="firstName" maxlength="50">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Middle Name</label>
								<div class="col-sm-8">
									<input type="text" class="form-control " name="middleName" maxlength="50">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Last Name<font color="red">*</font></label>
								<div class="col-sm-8">
									<input required type="text" class="form-control " name="lastName" maxlength="50">
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
									<input required type="text" id="age" class="form-control" name="age" readonly="readonly" maxlength="3">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Street<font color="red">*</font></label>
								<div class="col-sm-8">
									<input required type="text" class="form-control " name="street" maxlength="50">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Barangay<font color="red">*</font></label>
								<div class="col-sm-8">
									<input required type="text" class="form-control " name="barangay" maxlength="50">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">City<font color="red">*</font></label>
								<div class="col-sm-8">
									<input required type="text" class="form-control " name="city" maxlength="50">
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
									<input required type="email" class="form-control " name="email" required maxlength="100">
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
<!--Update Modal-->
@foreach($tofficer as $tofficers)
<div class="modal fade in" id="update{{$tofficers->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form  id="update-form{{$tofficers->id}}" action="/tofficer/update" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<div class="modal-header btn-primary">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">New Training Officer</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="alert alert-success">
									<p><em>Note: <font color="red">*</font> fields are required</em></p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">First Name<font color="red">*</font></label>
								<div class="col-sm-8">
									<input required type="text" value="{{$tofficers->firstName}}" class="form-control" name="firstName" maxlength="50">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Middle Name</label>
								<div class="col-sm-8">
									<input type="text" class="form-control " value="{{$tofficers->middleName}}" name="middleName" maxlength="50">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Last Name<font color="red">*</font></label>
								<div class="col-sm-8">
									<input required type="text" class="form-control " value="{{$tofficers->lastName}}" name="lastName" maxlength="50">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Gender<font color="red">*</font></label>
	              @if($tofficers->gender == 'M')
                    <label class="radio-inline " for="example-inline-radio1">
                        <input checked type="radio" name="gender" value="M">Male</label>
                    <label class="radio-inline" for="example-inline-radio1">
                        <input type="radio" name="gender" value="F">Female</label>
                  @else
                    <label class="radio-inline " for="example-inline-radio1">
                        <input  type="radio" name="gender" value="M">Male</label>
                    <label class="radio-inline" for="example-inline-radio1">
                        <input checked type="radio" name="gender" value="F">Female</label>
                  @endif
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Date of Birth<font color="red">*</font></label>
								<div class="col-sm-8">
									<div class="input-group date form_datetime"  data-date-format="MM dd, yyyy" data-link-field="dtp_input1">
										<input class="form-control" size="16" type="text" value="{{Carbon\Carbon::parse($tofficers->dob)->format('F d,Y')}}" readonly name="dob" id="dob" onchange="dobChanged(this)">
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-th"></span>
										</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Age</label>
								<div class="col-sm-8">
									<input required type="text" id="age" value="{{Carbon\Carbon::parse($tofficers->dob)->age}}" class="form-control" name="age" readonly="readonly">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Street<font color="red">*</font></label>
								<div class="col-sm-8">
									<input required type="text" class="form-control " value="{{$tofficers->street}}" name="street" maxlength="50">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Barangay<font color="red">*</font></label>
								<div class="col-sm-8">
									<input required type="text" class="form-control " value="{{$tofficers->barangay}}" name="barangay" maxlength="50">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">City<font color="red">*</font></label>
								<div class="col-sm-8">
									<input required type="text" class="form-control " value="{{$tofficers->city}}" name="city" maxlength="50">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-md-4 control-label">Contact<font color="red">*</font></label>
								<div class="col-md-8" style="padding-right: 0px; padding-left: 0px; ">
									<div class="col-md-6" style="padding-right: 0px;">
										<select name="contactType" id="contactType{{$tofficers->id}}" class="selector form-control" style="padding: 0px; width: 80%;" onchange="contactTypeChanged1({{$tofficers->id}})">
											@if(strlen($tofficers->contact) >= 11)
											<option selected value="mobile">Mobile No.</option>
											<option value="tel">Landline No.</option>
											@else
											<option  value="mobile">Mobile No.</option>
											<option selected value="tel">Landline No.</option>
											@endif
										</select>
									</div>
									<div class="col-md-6" id="contactC{{$tofficers->id}}" style="padding-left: 0px;">
										@if(strlen($tofficers->contact) >= 11)
										<input type="text" id="contact" class="selector cp form-control placeholder" name="contact" placeholder="0999 9999 999" value="{{$tofficers->contact}}" maxlength="11">
										@else
										<input type="text" id="contact" class="tel form-control placeholder" placeholder="999 9999" value="{{$tofficers->contact}}"  maxlength="11">
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

<!--Confirmation modal-->
@foreach($tofficer as $tofficers)
<form action="/tofficer/delete" method="post">
	{{csrf_field()}}
	<input type="hidden" name="id" value="{{$tofficers->id}}">
	<div data-toggle="modal" class="modal fade in" id="static{{$tofficers->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	    <div class="modal-dialog modal-md">
	        <div class="modal-content">
	           <div class="modal-header btn-danger">
        			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        		<div class="modal-title">Deactivate</div>
        		</div>
            <div class="modal-body">
              <span>&ensp;&ensp;Are you sure sure you want to deactivate <b>{{$tofficers->firstName}} {{$tofficers->lastName}}</b>?</span>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn">No</button>
                <button type="submit" class="btn btn-primary">Yes</button>
            </div>
	        </div>
	    </div>
	</div>
</form>
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
	$('#maintenance').addClass(' active');
	$('#tofficer').addClass(' active');
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
		// var age = moment(dob.value,"MMM D, YYYY").fromNow(true);
		// $('#age').val(age+' old');
		var bday=  moment(dob.value,"MMM D, YYYY");
		var today = moment();
		$('#age').val(today.diff(bday,"years"));
		$('#age').valid();
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
    $("#contactC").append('<input type="text" id="contact" class="tel form-control placeholder" placeholder="999 9999">')
    
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
    $("#contactC").append('<input type="text" id="contact" class="cp form-control placeholder" placeholder="0999 9999 999">')
    
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
    $("#contactC"+id).append('<input type="text" id="contact" class="tel form-control placeholder" placeholder="999 9999">')
    
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
    $("#contactC"+id).append('<input type="text" id="contact" class="cp form-control placeholder" placeholder="0999 9999 999">')
    
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

$.validator.addMethod("regx", function(value, element, regexpr) {          
    return regexpr.test(value);
}, "No special characters except(hypen ( - ))");

$.validator.addMethod("regx1", function(value, element, regexpr) {          
    return regexpr.test(value);
}, "No special characters except(hypen ( - ) and apostrophe ( ' ))");

$.validator.addMethod("regx2", function(value, element, regexpr) {          
    return regexpr.test(value);
}, "Invalid Input");

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
		$('#create-form').validate({
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
				dob:{
					required: true
				},
				age:{
					adult: true
				},
				street:{
					required: true,
					regx2: /(^[a-zA-Z0-9 \'\-\Ñ\ñ\#\.\,]+$)/i,
					space: true,
				},
				barangay:{
					required: true,
					regx2: /(^[a-zA-Z0-9 \'\-\Ñ\ñ\#\.\,]+$)/i,
					space: true,
				},
				city:{
					required: true,
					regx2: /(^[a-zA-Z ]+$)/i,
					space: true,
				},
				contact:{
					required: true
				}
			}
		});
	});

	function clicks(id){
		$('#update-form'+id).validate({
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
				dob:{
					required: true
				},
				age:{
					adult: true
				},
				street:{
					required: true,
					regx2: /(^[a-zA-Z0-9 \'\-\Ñ\ñ\#\.\,]+$)/i,
					space: true,
				},
				barangay:{
					required: true,
					regx2: /(^[a-zA-Z0-9 \'\-\Ñ\ñ\#\.\,]+$)/i,
					space: true,
				},
				city:{
					required: true,
					regx2: /(^[a-zA-Z ]+$)/i,
					space: true,
				},
				contact:{
					required: true
				}
			},
			errorPlacement:function(error,element){
         		error.insertAfter(element.parent("div"));
			}
		});
	};
</script>

<script type="text/javascript">

		@foreach($tofficer as $tofficers)

			$('#update{{$tofficers->id}}').on('hidden.bs.modal', function (e) {

	  		$('#update-form{{$tofficers->id}}').trigger('reset');
  			$('#update-form{{$tofficers->id}}').validate().resetForm();
	  		$('#update-form{{$tofficers->id}}').find('.error').removeClass('error');
  		});
		@endforeach

		$('#responsive').on('hidden.bs.modal', function (e) {
    	$('#create-form').trigger('reset');
  		$('#create-form').validate().resetForm();
    	$('#create-form').find('.error').removeClass('error');
		});
</script>
@endsection
