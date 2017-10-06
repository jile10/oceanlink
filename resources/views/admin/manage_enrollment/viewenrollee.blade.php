@extends('admin.layouts.default')

@section('content')

<style type="text/css">
	.divs{
		margin-top: 20px;
	}
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
	<!--section starts-->
	<h1>View Class</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-success filterable" style="overflow:auto;">
				<div class="panel-heading">
					<h3 class="panel-title">
						<i class="livicon" data-name="responsive" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>&ensp;&ensp;<big></big>
					</h3>
				</div>
				<div class="divs col-md-12">
					<div class="col-md-2">
						<form action="/manage_enrollment/set" method="post">
							{{csrf_field()}}
							<input type="hidden" name="id" value="{{$sprog->trainingclass->id}}">
							<button type="submit" class="buttons btn btn-success" ><i class="glyphicon glyphicon-remove-sign"></i>&ensp;Close Enrollment</button>
						</form>
					</div>
				</div>
				<div class="divs col-lg-12">
					<div class="col-lg-6">
						<div class="form-vertical">
							<div class="form-group">
								<label class="control-label">Class Name :</label>
								<input  readonly class="form-control" value="{{$sprog->trainingclass->class_name}}">
							</div>
							<div class="form-group">
								<label class="control-label">Course Name :</label>
								<input readonly class="form-control" value="{{$sprog->rate->program->programName . ' ( ' . $sprog->rate->duration . ' ' . $sprog->rate->unit->unitName . ' )'}}">
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-vertical">
							<div class="form-group">
								<label class="control-label">Class Start:</label>
								<input  readonly class="form-control" value="{{Carbon\Carbon::parse($sprog->dateStart)->format('F d, Y')}}">
							</div>
							<div class="form-group">
								<label class="control-label">Training Room :</label>
								<input readonly class="form-control" value="{{'Room ' . $sprog->trainingclass->trainingroom->room_no . ' ' . $sprog->trainingclass->trainingroom->building->buildingName . ' ' . $sprog->trainingclass->trainingroom->floor->floorName}}">
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body table-responsive">
					<table class="table table-striped table-bordered" id="table1">
						<thead>
							<tr>
								<th width="20%">Applicants Number</th>
								<th width="20%">Applicants Name</th>
								<th width="30%">Applicants Address</th>
								<th width="5%">Age</th>
								<th width="10%">Status</th>
								<th width="15">Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($detail as $tclass)
							<tr>
								<td>{{$tclass->enrollee->studentNumber}}</td>
								<td>{{$tclass->enrollee->firstName . ' ' . $tclass->enrollee->middleName . ' ' . $tclass->enrollee->lastName}}</td>
								<td>{{$tclass->enrollee->street . ' ' . $tclass->enrollee->barangay . ' ' . $tclass->enrollee->city}}</td>
								<td>{{Carbon\Carbon::createFromFormat('Y-m-d',$tclass->enrollee->dob)->age}}</td>
								@if($tclass->enrollee->status_id == 1)
								<td>Not Enrolled</td>
								@else
								<td>Enrolled</td>
								@endif
								<td><button class="btn btn-primary" >View</button></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('js')
<script>
	$(document).ready( function(){
		var table = $('#table1').DataTable();
	});
</script>
@endsection