@extends('training_officer.layouts.default')
@section("css")
<link rel="stylesheet" type="text/css" href="{{ asset('/css/toastr.min.css') }}">
<style type="text/css">
	.unpaid{
		background-color: #f2dede!important;
	}
	.paid{
		background-color: #dff0d8!important;
	}
</style>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<!--section starts-->
	<h1>Grades</h1>
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
		<li class="active">Set Grades</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<form action="/tofficer/grade/insert" method="post">
			{{csrf_field()}}
			<div class="col-lg-12">
				<div class="panel panel-success filterable" style="overflow:auto;">
					<div class="panel-heading">
						<h3 class="panel-title">
						</h3>
					</div>
					<div class="panel-body table-responsive">
						<div class="col-md-12">
							<div class="form-vertical">
								<div class="col-md-9">
									<div class="form-group">
										<label class="control-label">Training Officer : &ensp;{{$tclass->scheduledprogram->trainingofficer->firstName . ' ' . $tclass->scheduledprogram->trainingofficer->middleName . ' ' .$tclass->scheduledprogram->trainingofficer->lastName}}</label> <br>
										<label class="control-label">Course : &ensp;{{$tclass->scheduledprogram->rate->program->programName . ' (' . $tclass->scheduledprogram->rate->duration . ' Hours)'}}</label>
									</div>
								</div>

								<div class="pull-right col-md-3">
                    <fieldset>
                    	<legend>Legend</legend>
                    	<span class="badge" style="background-color: #dff0d8!important">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;Passed<br>
                    	<span class="badge" style="background-color: #f2dede!important;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;Failed
                    </fieldset>
                </div>
							</div>
						</div>
						<div class="col-md-12 table-responded" style="margin-top: 50px;">
							<table class="table table-bordered" id="table1">
								<thead>
									<tr>
										<th width="20%">Student Id</th>
										<th width="40%">Student Name</th>
										<th width="20%">Grade</th>
										<th width="20%">Remarks</th>
									</tr>
								</thead>
								<tbody id="tbody">
									@if(count($tclass->groupclassdetail)!=0)
										@foreach($tclass->groupclassdetail as $details)
											<tr>
												<td>{{$details->groupenrollee->studentNumber}}</td>
												<input type="hidden" name="groupclassdetail_id[]" value="{{$details->id}}">
												<td>{{$details->groupenrollee->lastName . ', ' .$details->groupenrollee->firstName}}</td>
												@if(count($details->groupgrade)==0)
												<td><input id="grade{{$details->id}}" onkeyup="upkey({{$details->id}})" type="text" name="grade[]" class="form-control"></td>
												<td id="remarks{{$details->id}}"></td><input type="hidden" name="remark[]" id="remark{{$details->id}}" value="">
												@else
												<td>{{$details->groupgrade->grade}}</td>
												<td id="remarks{{$details->id}}">{{$details->groupgrade->remark}}</td>
												@endif
											</tr>
										@endforeach
									@else
										@foreach($tclass->classdetail->where('status','!=',1) as $details)
											@if(count($details->grade)!= 0)
											<input type="hidden" name="updateGrade" value="{{$i=1}}">
											@if($details->grade->remark == "P")
											<tr class="paid">
											@else
											<tr class="unpaid">
											@endif
											@else
											<tr>
											@endif
												<td>{{$details->enrollee->studentNumber}}</td>
												<input type="hidden" name="classdetail_id[]" value="{{$details->id}}">
												<td>{{$details->enrollee->firstName . ' ' . $details->enrollee->middleName . ' ' .$details->enrollee->lastName}}</td>
												@if(count($details->grade)==0)
												<td><input id="grade{{$details->id}}" onkeyup="upkey({{$details->id}})" type="text" name="grade[]" class="form-control"></td>
												<td id="remarks{{$details->id}}"></td><input type="hidden" name="remark[]" id="remark{{$details->id}}" value="">
												@else
												<td>{{$details->grade->grade}}</td>
												<td id="remarks{{$details->id}}">{{$details->grade->remark}}</td>
												@endif
											</tr>
										@endforeach
									@endif
								</tbody>
							</table>
						</div>
						@if($i == 1)
						<div id="button" class="col-md-6 col-md-offset-3">
							<button id="update" type="button" class="btn col-md-6 col-md-offset-3 btn-primary"><i class="glyphicon glyphicon-edit"></i>&ensp;Update Grade</button>
						</div>
						@else
						<div class="col-md-2 col-md-offset-5">
							<button id="btn" class="btn btn-block btn-primary">Submit Grade</button>
						</div>
						@endif
					</div>
				</div>
			</div>
		</form>
	</div>
</section>
@endsection
@section('js')
<script src="/js/toastr.min.js"></script>
<script type="text/javascript">

	function cancelUpdate(){
		toastr.info("Update grade has been canceled");
		$('#button').empty();
		$('#button').append('<button type="button" onclick="tanga()" class="btn col-md-6 col-md-offset-3 btn-primary"><i class="glyphicon glyphicon-edit"></i>&ensp;Update Grade</button>');
		$('#tbody').empty();
		$('#tbody').append('@if(count($tclass->groupclassdetail)!=0)@foreach($tclass->groupclassdetail as $details)<tr><td>{{$details->groupenrollee->studentNumber}}</td><input type="hidden" name="groupclassdetail_id[]" value="{{$details->id}}"><td>{{$details->groupenrollee->lastName . ","  .$details->groupenrollee->firstName}}</td>@if(count($details->groupgrade)==0)<td><input id="grade{{$details->id}}" onkeyup="upkey({{$details->id}})" type="text" name="grade[]" class="form-control"></td><td id="remarks{{$details->id}}"></td><input type="hidden" name="remark[]" id="remark{{$details->id}}" value="">@else<td>{{$details->groupgrade->grade}}</td><td id="remarks{{$details->id}}">{{$details->groupgrade->remark}}</td>@endif</tr>@endforeach @else @foreach($tclass->classdetail->where("status",'!=',1) as $details)@if($details->grade->remark == "P")<tr class="paid"> @else <tr class="unpaid">@endif<td><input type="hidden" name="updateGrade" value="{{$i}}">{{$details->enrollee->studentNumber}}</td><input type="hidden" name="classdetail_id[]" value="{{$details->id}}"><td>{{$details->enrollee->firstName . " " . $details->enrollee->middleName . " " .$details->enrollee->lastName}}</td><td>{{$details->grade->grade}}</td><td id="remarks{{$details->id}}">{{$details->grade->remark}}</td></tr>@endforeach @endif');


	}
	function tanga()
	{
		toastr.info("You can now update grades in this class");
			$('#button').empty();
			$('#button').append('<button id="submit" class="btn col-md-5 btn-primary">Submit Grade</button><div id="div" class="col-md-2"></div><button id="cancel" type="button" onclick="cancelUpdate()" class="btn col-md-5 btn-danger"><i class="glyphicon glyphicon-remove"></i>&ensp;Cancel Update</button>');
			$('#tbody').empty();
			$('#tbody').append('@if(count($tclass->groupclassdetail)!=0)@foreach($tclass->groupclassdetail as $details)<tr><td>{{$details->groupenrollee->studentNumber}}</td><input type="hidden" name="groupclassdetail_id[]" value="{{$details->id}}"><td>{{$details->groupenrollee->lastName . ", " .$details->groupenrollee->firstName}}</td><td><input id="grade{{$details->id}}" onkeyup="upkey({{$details->id}})" type="text" name="grade[]" class="form-control"></td><td id="remarks{{$details->id}}"></td><input type="hidden" name="remark[]" id="remark{{$details->id}}" value=""></tr>@endforeach @else  @foreach($tclass->classdetail->where("status","!=",1) as $details)  <tr> <td><input type="hidden" name="updateGrade" value="{{$i}}">{{$details->enrollee->studentNumber}}</td><input type="hidden" name="classdetail_id[]" value="{{$details->id}}"><td>{{$details->enrollee->firstName . " " . $details->enrollee->middleName . ' ' .$details->enrollee->lastName}}</td><td><input id="grade{{$details->id}}" onkeyup="upkey({{$details->id}})" type="text" name="grade[]" value="{{$details->grade->grade}}" class="form-control"></td><td id="remarks{{$details->id}}">{{$details->grade->remark}}</td><input type="hidden" name="remark[]" id="remark{{$details->id}}" value="{{$details->grade->remark}}"></tr> @endforeach @endif');
	}
	$(document).ready(function(){
		$('#update').click(function(){
			toastr.info("You can now update grades in this class");
			$('#button').empty();
			$('#button').append('<button id="submit" class="btn col-md-5 btn-primary">Submit Grade</button><div id="div" class="col-md-2"></div><button id="cancel" type="button" onclick="cancelUpdate()" class="btn col-md-5 btn-danger"><i class="glyphicon glyphicon-remove"></i>&ensp;Cancel Update</button>');
			$('#tbody').empty();
			$('#tbody').append('@if(count($tclass->groupclassdetail)!=0)@foreach($tclass->groupclassdetail as $details)<tr><td>{{$details->groupenrollee->studentNumber}}</td><input type="hidden" name="groupclassdetail_id[]" value="{{$details->id}}"><td>{{$details->groupenrollee->lastName . ", " .$details->groupenrollee->firstName}}</td><td><input id="grade{{$details->id}}" onkeyup="upkey({{$details->id}})" type="text" name="grade[]" class="form-control"></td><td id="remarks{{$details->id}}"></td><input type="hidden" name="remark[]" id="remark{{$details->id}}" value=""></tr>@endforeach @else  @foreach($tclass->classdetail->where("status","!=",1) as $details)  <tr> <td><input type="hidden" name="updateGrade" value="{{$i}}">{{$details->enrollee->studentNumber}}</td><input type="hidden" name="classdetail_id[]" value="{{$details->id}}"><td>{{$details->enrollee->firstName . " " . $details->enrollee->middleName . ' ' .$details->enrollee->lastName}}</td><td><input id="grade{{$details->id}}" onkeyup="upkey({{$details->id}})" type="text" name="grade[]" value="{{$details->grade->grade}}" class="form-control"></td><td id="remarks{{$details->id}}">{{$details->grade->remark}}</td><input type="hidden" name="remark[]" id="remark{{$details->id}}" value="{{$details->grade->remark}}"></tr> @endforeach @endif');
		});

	});
</script>
<script>
	$(document).ready( function(){
		var table = $('#table1').DataTable();
	});
	$("#transaction").last().addClass( "active" );
	$("#manage_class").last().addClass( "active" );

	function upkey(id){
		console.log(id);
		if(parseFloat($("#grade"+id).val())<3.5 && parseFloat($("#grade"+id).val()) != "")
		{
			$("#remarks"+id).empty();
			$("#remarks"+id).append("P");
			$("#remark"+id).val("P");

		}
		else if(parseFloat($("#grade"+id).val())>=3.5)
		{
			$("#remarks"+id).empty();
			$("#remarks"+id).append("F");
			$("#remark"+id).val("F");
		}
		else if($("#grade"+id).val() == "")
		{
			$("#remarks"+id).empty();
		}
		else if($('#grade'+id).val().toUpperCase() == "P")
		{
			$("#remarks"+id).empty();
			$("#remarks"+id).append("P");
			$("#remark"+id).val("P");
		}
		else if($('#grade'+id).val().toUpperCase() == 'F')
		{
			$("#remarks"+id).empty();
			$("#remarks"+id).append("F");
			$("#remark"+id).val("F");
		}
		else
		{
			$("#remarks"+id).empty();
			$("#remark"+id).val("");
		}
	}


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
@endsection