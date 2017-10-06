@extends('admin.layouts.default')

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
					<table class="table table-striped table-bordered" id="table1">
						<thead>
							<tr>
								<th width="25%">Name</th>
								<th width="40%">Address</th>
								<th width="10%">Gender</th>
								<th width="5%">Age</th>
								<th width="10%"></th>
							</tr>
						</thead>
						<tbody>
							@foreach($tofficer as $tofficers)
							<tr>
								<td>{{$tofficers->firstName . ' ' . $tofficers->middleName . ' '. $tofficers->lastName}}</td>
								<td>{{$tofficers->street . ' ' . $tofficers->barangay . ' ' . $tofficers->city}}</td>
								<td>@if($tofficers->gender == 'F')Female @else Male @endif</td>
								<td>{{Carbon\Carbon::createFromFormat('Y-m-d',$tofficers->dob)->age}}</td>
								<td align="center"><form action="/tofficer/activate" method="post">{{csrf_field()}}<input type="hidden" name="id" value="{{$tofficers->id}}"><button type="submit" class="btn btn-info">Reactivate</button></form></td>
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


	$("#maintenance").last().addClass( "active" );
	$("#tofficer").last().addClass( "active" );
</script>
@endsection