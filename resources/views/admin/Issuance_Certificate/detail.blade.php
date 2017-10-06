@extends('admin.layouts.default')
@section("css")
  <link href="/css/all.css?v=1.0.2" rel="stylesheet">
  <link href="/css/flat/blue.css" rel="stylesheet">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<!--section starts-->
	<h1>Issuance of Certificate</h1>
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
		<li class="active">Issuance of Certificate</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-success filterable" style="overflow:auto;">
				<div class="panel-heading">
					<h3 class="panel-title">
						<i class="livicon" data-name="responsive" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
					</h3>
				</div>
				<div class="panel-body table-responsive">
					<div class="col-md-12">
						
						<div class="form-vertical">
							<div class="form-group">
								<label class="control-label">Training Officer : &ensp;{{$tclass->scheduledprogram->trainingofficer->firstName . ' ' . $tclass->scheduledprogram->trainingofficer->middleName . ' ' .$tclass->scheduledprogram->trainingofficer->lastName}}</label> <br>
								<label class="control-label">Course : &ensp;{{$tclass->scheduledprogram->rate->program->programName . ' (' . $tclass->scheduledprogram->rate->duration . ' Hours)'}}</label>
							</div>
						</div>
					</div>
					<table class="table table-striped table-bordered" id="table1">
						<thead>
							<tr>
								<th width="15%"><input id="checkAll" type="checkbox" name="">&ensp;Select All</th>
								<th width="25%">Student Id</th>
								<th width="40%">Student Name</th>
								<th width="20%">Status</th>
							</tr>
						</thead>
						<tbody>
							@if(count($tclass->classdetail)!=0)
								@foreach($tclass->classdetail as $details)
									<tr>
										<td align="center"><input id="check{{$details->id}}" type="checkbox" name=""></td>
										<td>{{$details->enrollee->studentNumber}}</td>
										<td>{{$details->enrollee->firstName . ' ' . $details->enrollee->middleName . ' ' .$details->enrollee->lastName}}</td>
										<td>@if($details->status == 3 && count($details->grade)>0) Ready @else On Hold @endif</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
					<form action="/certificate/individual" method="post">
					{{csrf_field()}}
						<input type="hidden" name="trainingclass_id" value="{{$tclass->id}}">
						<div id="mark">
							
						</div>
						<div class="col-md-3"><button type="submit" class="btn btn-block btn-primary">Print Selected</button></div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('js')
<script src="/js/icheck.js" type="text/javascript"></script>
<script src="/vendors/iCheck/icheck.js" type="text/javascript"></script>
<script>
	$(document).ready( function(){
		var table = $('#table1').DataTable();
	});
	$("#transaction").last().addClass( "active" );
	$("#issuance").last().addClass( "active" );
	$('input').iCheck({
    	checkboxClass: 'icheckbox_flat-blue',
	});
	@foreach($tclass->classdetail as $details)
			@if($details->status != 3 || count($details->grade)==0)
				$('#check{{$details->id}}').iCheck('disable');
			@endif
		@endforeach
</script>
<script type="text/javascript">
	$('#checkAll').on('ifChecked',function(){
		@foreach($tclass->classdetail as $details)
			@if($details->status == 3 && count($details->grade)>0)
				$('#check{{$details->id}}').iCheck('check');
			@endif
		@endforeach
	});
	$('#checkAll').on('ifUnchecked',function(){
		@foreach($tclass->classdetail as $details)
			@if($details->status == 3 && count($details->grade)>0)
				$('#check{{$details->id}}').iCheck('uncheck');
			@endif
		@endforeach
	});
	@foreach($tclass->classdetail as $details)
		@if($details->status == 3 && count($details->grade)>0)
			$('#check{{$details->id}}').on('ifChecked',function(){
				$('#mark').append('<input type="hidden" name="classdetail_id[]" value="{{$details->id}}"/>')
			});
		@endif
	@endforeach
</script>
@endsection