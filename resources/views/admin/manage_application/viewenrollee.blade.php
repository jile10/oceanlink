@extends('admin.layouts.default')
@section("css")
<link rel="stylesheet" type="text/css" href="{{ asset('/css/toastr.min.css') }}">
@endsection
@section('content')
<style type="text/css">
	.buttons{
		margin-bottom: 20px;
		margin-right: 15px;
	}

	.divs{
		margin-bottom: 20px;
	}
	.unpaid{
		background-color: #f2dede!important;
	}
	.paid{
		background-color: #dff0d8!important;
	}
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
	<!--section starts-->
	<h1>Applicants</h1>
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
			<a >Manage Applications</a>
		</li>
		<li class="active">Single Application</li>
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
					<form action="/manage_app/enrollee/application" method="post">
					{{csrf_field()}}
					<input type="hidden" name="trainingclass_id" value="{{$tclass->id}}">
					<button type="submit" class="buttons btn btn-success" ><i class="glyphicon glyphicon-plus"></i>&ensp;New Individual Application</button>
					</form>
					<div class="divs col-md-12">
						<div class="col-md-6">
							<div class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-4 control-label">Class Name&ensp;:</label>
									<div class="col-sm-7">
										<input type="text" disabled value="{{$tclass->class_name}}" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Program Name&ensp;:</label>
									<div class="col-sm-7">
										<input type="text" disabled value="{{$tclass->scheduledprogram->rate->program->programName}}" class="form-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 pull-right">
							<fieldset>
              	<legend>Legend</legend>
              	<span class="badge unpaid">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;Unpaid enrollee<br>
              	<span class="badge paid">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;Paid enrollee
              </fieldset>
            </div>
					</div>
					<table class="table table-striped table-bordered" id="table1">
						<thead>
							<tr>
								<th width="15%">Number</th>
								<th width="25%">Name</th>
								<th width="30%">Address</th>
								<th width="15%">Age</th>
								<th width="15%">Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($tclass->classdetail as $tclass)
								@if($tclass->status == 1)
								<tr class="unpaid">
									<td>{{$tclass->enrollee->studentNumber}}</td>
									<td>{{$tclass->enrollee->firstName . ' ' . $tclass->enrollee->middleName . ' '. $tclass->enrollee->lastName}}</td>
									<td>{{$tclass->enrollee->street . ' ' . $tclass->enrollee->barangay . ' '. $tclass->enrollee->city}}</td>
									<td>{{Carbon\Carbon::createFromFormat('Y-m-d',$tclass->enrollee->dob)->age}}</td>
									<td>
										<button type="button" class="btn btn-danger" data-toggle="modal" data-href="#dialog{{$tclass->id}}" href="#dialog{{$tclass->id}}"> Cancel</button>
									</td>
								</tr>
								@elseif($tclass->status == 2 || $tclass->status == 3)
								<tr class="paid">
									<td>{{$tclass->enrollee->studentNumber}}</td>
									<td>{{$tclass->enrollee->firstName . ' ' . $tclass->enrollee->middleName . ' '. $tclass->enrollee->lastName}}</td>
									<td>{{$tclass->enrollee->street . ' ' . $tclass->enrollee->barangay . ' '. $tclass->enrollee->city}}</td>
									<td>{{Carbon\Carbon::createFromFormat('Y-m-d',$tclass->enrollee->dob)->age}}</td>
									<td>
										<button type="button" class="btn btn-danger" data-toggle="modal" data-href="#dialog{{$tclass->id}}" href="#dialog{{$tclass->id}}">Cancel Enrollment</button>
									</td>
								</tr>
								@endif
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Confirmation Dialog -->
@foreach($tclas->classdetail as $tclass)
<div class="modal fade in" id="dialog{{$tclass->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="/manage_app/cancel" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<input type="hidden" name="classdetail_id" value="{{$tclass->id}}"/>
				<div class="modal-header btn-danger">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Cancel Enrollment</h4>
				</div>
				<div class="modal-body">
				 <span>Are you sure you want to cancel <b>{{$tclass->enrollee->firstName . ' ' . $tclass->enrollee->middleName . ' '. $tclass->enrollee->lastName}}</b>'s enrollment?</span><br><br>
				 <span><em>Note: This action can't be undone.</em></span>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn">No</button>
					<button type="submit" class="btn btn-primary">Yes</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endforeach

@endsection
@section('js')

<script src="/js/toastr.min.js"></script>
<script>
	$(document).ready( function(){
		var table = $('#table1').DataTable();
		@if(count(session('voucher'))>0)
			window.open('/voucher', '_blank');
		@endif
		@if(count(session('message'))>0)
			toastr.error("{{session('message')}}");
		@endif
	});
	$("#transaction").last().addClass( "active" );
	$("#manage_app").last().addClass( "active" );
	$("#individual_app").last().addClass( "active" );
	@if(count(session('exist_class'))>0)
		toastr.error("{{session('exist_class')}}");
	@endif
</script>
@endsection