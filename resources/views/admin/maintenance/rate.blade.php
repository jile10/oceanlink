@extends('admin.layouts.default')

@section('css')
<link href="/vendors/panel/panel.css" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<style type="text/css">
	.buttons{
		margin-top: 10px;
		margin-bottom: 20px;
	}
	.buttonss{
		margin-left: 5px;
	}
</style>
<section class="content-header">
	<!--section starts-->
	<h1>Course Maintenance</h1>
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
		<li class="active">Course</li>
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
						<button class="buttons btn btn-success" data-toggle="modal" data-href="#responsive" href="#responsive"><i class="glyphicon glyphicon-plus"></i>&ensp;New Course</button>
					</div>
					<div class="col-md-6 text-right">
						<a href="/maintenance/rate/archive" class="buttons btn btn-success"><i class="glyphicon glyphicon-folder-open"></i>&ensp;Archive</a>
					</div>
					
					<table class="table table-striped table-bordered" id="table1">
						<thead>
							<tr>
								<th width="30%">Program Name</th>
								<th width="10%">Duration</th>
								<th width="15%">Class Hour</th>
								<th align="right" width="15%">Price &ensp;&ensp;(Php)</th>
								<th width="20%">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($rate as $rates)
							<tr>
								<td>{{$rates->program->programName}}</td>
								<td>{{$rates->duration}} Hours</td>
								<td>{{$rates->classHour}}</td>
								<td align="right">{{number_format($rates->price,2)}}</td>
								<td align="center"><button type="button" class="buttonss btn btn-primary" data-toggle="modal" data-href="#update{{$rates->id}}" onclick="clicks({{$rates->id}})" href="#update{{$rates->id}}">Update</button>
								<button  type="submit" data-toggle="modal" data-href="#static{{$rates->id}}" href="#static{{$rates->id}}" class="buttonss btn btn-danger">Deactivate</button></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<!--Create Modal-->
<div class="modal fade in" id="responsive" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form id="create-form" action="/rate/insert" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<div class="modal-header btn-primary">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">New Course</h4>
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
								<div class="col-md-12">
									<div class="form-group">
										<label for="inputEmail3" class="col-md-3 control-label">Program Type<font color="red">*</font></label>
										<div class="col-md-9">
											<div>
												<select required id="type" onchange="changes()" name="program_id" class="form-control">
													@foreach($type as $types)
													<option value="{{$types->id}}" >{{$types->typeName}}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="inputEmail3" class="col-md-3 control-label">Program Name<font color="red">*</font></label>
										<div class="col-md-9">
											<div>
												<select required id="programs" name="program_id" class="form-control">
												@foreach($first as $firsts)
													<option value="{{$firsts->id}}" >{{$firsts->programName}}</option>
												@endforeach
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="inputEmail3" class="col-md-6 control-label">Class Hours (per day)<font color="red">*</font></label>
										<div class="col-md-6">
											<div>
												<input required type="text" name="class_hours" id="class_hours" maxlength="1" class="form-control" maxlength="1">
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="inputEmail3" class="col-md-6 control-label">Total No. of Hours<font color="red">*</font></label>
										<div class="col-md-6">
											<div>
												<input required type="text" name="duration" id="duration" class="form-control" maxlength="11">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row" >
								<div class="col-md-6">
									<div class="form-group">
										<label for="inputEmail3" class="col-md-6 control-label">Minimum No. of Students<font color="red">*</font></label>
										<div class="col-md-6">
											<div>
												<input required type="text" name="min_students" id="min_students" class="form-control" maxlength="3">
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="inputEmail3" class="col-md-6 control-label">Maximum No. of Students<font color="red">*</font></label>
										<div class="col-md-6">
											<div>
												<input required type="text" name="max_students" id="max_students" class="form-control" maxlength="3">
											</div>
										</div>
									</div>
								</div>
							</div>
							<center><div class="row" id="minMax">
							</div></center>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="inputEmail3" class="col-md-6 control-label">Fee<font color="red">*</font></label>
										<div class="col-md-6">
											<div class="input-group">
											<span class="input-group-addon">Php</span>
												<input required type="text" name="price" id="price" class="price form-control text-right" maxlength="14">
											</div>
										</div>
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

<!--Update Modal-->
@foreach($rate as $rates)
<div class="modal fade in" id="update{{$rates->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form id="update-form{{$rates->id}}" action="/rate/update" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<input type="hidden" name="id" value="{{$rates->id}}">
				<div class="modal-header btn-primary">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Update Course</h4>
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
								<div class="col-md-12">
									<div class="form-group">
										<label for="inputEmail3" class="col-md-3 control-label">Program Type<font color="red">*</font></label>
										<div class="col-md-9">
											<div>
												<select required id="type{{$rates->id}}" onchange="change({{$rates->id}})" name="program_id" class="form-control">
													@foreach($type as $types)
													@if($types->id == $rates->program->programtype->id)
													<option selected value="{{$types->id}}" >{{$types->typeName}}</option>
													@else
													<option value="{{$types->id}}" >{{$types->typeName}}</option>
													@endif
													@endforeach
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="inputEmail3" class="col-md-3 control-label">Program Name<font color="red">*</font></label>
										<div class="col-md-9">
											<div>
												<select required id="programs{{$rates->id}}" name="program_id" class="form-control">
													<option value="{{$rates->program->id}}" >{{$rates->program->programName}}</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="inputEmail3" class="col-md-6 control-label">Class Hours (per day)<font color="red">*</font></label>
										<div class="col-md-6">
											<div>
												<input required type="text" name="class_hours" class="form-control" value="{{$rates->classHour}}"  maxlength="1">
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="inputEmail3" class="col-md-6 control-label">Total No. of Hours<font color="red">*</font></label>
										<div class="col-md-6">
											<div>
												<input required type="text" name="duration" class="form-control" value="{{$rates->duration}}" maxlength="11">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="inputEmail3" class="col-md-6 control-label">Minimum No. of Students<font color="red">*</font></label>
										<div class="col-md-6">
											<div>
												<input required type="text" name="min_students" id="min_students2" value="{{$rates->min_students}}" class="form-control" maxlength="3">
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="inputEmail3" class="col-md-6 control-label">Maximum No. of Students<font color="red">*</font></label>
										<div class="col-md-6">
											<div>
												<input required type="text" name="max_students" id="max_students2" value="{{$rates->max_students}}" class="form-control" maxlength="3">
											</div>
										</div>
									</div>
								</div>
							</div>
							<center><div class="row" id="minMax2">
							</div></center>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="inputEmail3" class="col-md-6 control-label">Fee<font color="red">*</font></label>
										<div class="col-md-6">
											<div class="input-group">
											<span class="input-group-addon">Php</span>
												<input  value="{{$rates->price}}" required type="text" name="price" id="price" class="price form-control text-right" maxlength="14">
											</div>
										</div>
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
@foreach($rate as $rates)
<form action="/rate/delete" method="post">
	{{csrf_field()}}
	<input type="hidden" name="id" value="{{$rates->id}}">
	<div data-toggle="modal" class="modal fade in" id="static{{$rates->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	    <div class="modal-dialog modal-md">
	        <div class="modal-content">
	          <div class="modal-header btn-danger">
        			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        		<div class="modal-title">Deactivate</div>
        		</div>
            <div class="modal-body">
              <span>&ensp;&ensp;Are you sure sure you want to deactivate <b>{{$rates->program->programName}}({{$rates->duration}}Hours)</b>?</span>
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

<script src="/vendors/inputmask_robinHerbots/inputmask.js" type="text/javascript"></script>
<script src="/vendors/inputmask_robinHerbots/inputmask.extensions.js" type="text/javascript"></script>
<script src="/vendors/inputmask_robinHerbots/jquery.inputmask.js" type="text/javascript"></script>
<script src="/vendors/inputmask_robinHerbots/inputmask.numeric.extensions.js" type="text/javascript"></script>


<script type="text/javascript">
	$(document).ready(function(){

  	$(".price").inputmask("currency");
	});
</script>

<script>
	$(document).ready( function(){
		var table = $('#table1').DataTable();
	});

	$("#maintenance").last().addClass( "active" );
	$("#course").last().addClass( "active" );
$('.sel-time-am').clockface();	
</script>

<script type="text/javascript">
	function changes(){
		var type_id = ($('#type').val());
		$.ajax({
    			type:'get',
    			url:'{!!URL::to('ajax-type')!!}',
    			data:{'id':type_id},
    			success:function(data){

					$('#programs').empty();
    				console.log(data.length);

    				for(var i=0;i<data.length;i++){
    					$('#programs').append('<option value="'+data[i].id+'">'+data[i].programName+'</option>');
    				}
    				
    			},
    			error:function(){

    			}
    		});
	}
	function change(id){
		var type_id = ($('#type'+id).val());
		$.ajax({
    			type:'get',
    			url:'{!!URL::to('ajax-type')!!}',
    			data:{'id':type_id},
    			success:function(data){

					$('#programs'+id).empty();
    				console.log(data.length);
    				for(var i=0;i<data.length;i++){
    					$('#programs'+id).append('<option value="'+data[i].id+'">'+data[i].programName+'</option>');
    				}
    				
    			},
    			error:function(){

    			}
    		});
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
}, "Invalid input amount");

$.validator.addMethod("regx3", function(value, element, regexpr) {          
    return regexpr.test(value);
}, "Numbers only");

$.validator.addMethod("regx4", function(value, element, regexpr) {          
    return regexpr.test(value);
}, "Invalid");
$.validator.addMethod("minMax", function(value, element) {          
	var min = $("#min_students").val();
	var max = $("#max_students").val();

	if((min!="")&&(max=="")){
		return true;
	}
	else if((max!="")&&(min=="")){
		return true;
	}
	else if(max!="" && min!=""){
			min = parseInt(min);
			max = parseInt(max);
		if(max>min){
			return true;
		}
		else if(min>=max){
			return false;
		}

		
	}
}, "Minimum no. of students must be less than the maximum.");
$.validator.addMethod("minMax2", function(value, element) {          
	var min = $("#min_students2").val();
	var max = $("#max_students2").val();

	if((min!="")&&(max=="")){
		return true;
	}
	else if((max!="")&&(min=="")){
		return true;
	}
	else if(max!="" && min!=""){
			min = parseInt(min);
			max = parseInt(max);
		if(max>min){
			return true;
		}
		else if(min>=max){
			return false;
		}

		
	}
}, "Minimum no. of students must be less than the maximum.");

	$(function(){
		$('#create-form').validate({
			rules:{
				duration:{
					required: true,
					regx3 : /^[0-9]+$/i,
					number: true
				},
				class_hours:{
					required: true,
					regx3 : /^[0-9]+$/i,
					maxlength: 1,
					range: [1,8],
					number: true
				},
				price:{
					required: true,
					regx2: /^(?:[0-9,])*(?:|\.[0-9]+)$/i,
					space: true,
					number: true
				},
				min_students:{
					regx3: /^[0-9]+$/i,
					required: true,
					number: true,
					minMax: true
				},
				max_students:{
					regx3: /^[0-9]+$/i,
					required: true,
					number: true,
					minMax: true
				}
			},
			messages:{
				duration:{
					number: "Input a valid number",
					maxlength: "Program can't take this long"
				},
				class_hours:{
					number: "Input a valid number",
					range: "Minimum of 1hr and maximum of 8hrs"
				},
				min_students:{
					maxlength: "Too many to be a minimum",
					number: "Input a valid number",
					required: "Fields are required"
				},
				max_students:{
					maxlength: "Too many to be a maximum",
					number: "Input a valid number",
					required: "Fields are required"
				}
			},
			groups:{
				minMax: "min_students max_students"
			},
			errorPlacement:function(error,element){
				 if (element.attr("name") == "min_students" || element.attr("name") =="max_students")
        		error.insertAfter("#minMax");
     		 else
					error.insertAfter(element.parent("div"));
			}
		});
	});

	function clicks(id){
		$('#update-form'+id).validate({
			rules:{
				duration:{
					required: true,
					regx3 : /^[0-9]+$/i,
					number: true
				},
				class_hours:{
					required: true,
					regx3 : /^[0-9]+$/i,
					maxlength: 1,
					range: [1,8],
					number: true
				},
				price:{
					required: true,
					regx2: /^(?:[0-9,])*(?:|\.[0-9]+)$/i,
					space: true,
					number: true
				},
				min_students:{
					regx3: /^[0-9]+$/i,
					required: true,
					number: true,
					minMax2: true
				},
				max_students:{
					regx3: /^[0-9]+$/i,
					required: true,
					number: true,
					minMax2: true
				}
			},
			messages:{
				duration:{
					number: "Input a valid number",
					maxlength: "Program can't take this long"
				},
				class_hours:{
					number: "Input a valid number",
					range: "Minimum of 1hr and maximum of 8hrs"
				},
				min_students:{
					maxlength: "Too many to be a minimum",
					number: "Input a valid number",
					required: "Fields are required"
				},
				max_students:{
					maxlength: "Too many to be a maximum",
					number: "Input a valid number",
					required: "Fields are required"
				}
			},
			groups:{
				minMax: "min_students max_students"
			},
			errorPlacement:function(error,element){
				 if (element.attr("name") == "min_students" || element.attr("name") =="max_students")
        		error.insertAfter("#minMax2");
     		 else
					error.insertAfter(element.parent("div"));
			}
		});
	};
</script>

<!-- <script>
	function round(fee){
		fee.value = parseFloat(fee.value).toFixed(2);
	}

</script> -->

<script type="text/javascript">

		@foreach($rate as $rates)

			$('#update{{$rates->id}}').on('hidden.bs.modal', function (e) {

	  		$('#update-form{{$rates->id}}').trigger('reset');
  			$('#update-form{{$rates->id}}').validate().resetForm();
	  		$('#update-form{{$rates->id}}').find('.error').removeClass('error');
  		});
		@endforeach

		$('#responsive').on('hidden.bs.modal', function (e) {
    	$('#create-form').trigger('reset');
  		$('#create-form').validate().resetForm();
    	$('#create-form').find('.error').removeClass('error');
		});

</script>

@endsection