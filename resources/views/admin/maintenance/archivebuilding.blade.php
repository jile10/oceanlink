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
	<h1>Building Archive</h1>
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
		<li>
			<a href="/maintenance/building">Building</a>
		</li>
		<li class="active">Building Archive</li>
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
								<th width="30%">Name</th>
								<th width="50%">Location</th>
								<th ></th>
							</tr>
						</thead>
						<tbody>
							@foreach($building as $buildings)
							<tr>
								<td>{{$buildings->buildingName}}</td>
								<td>{{$buildings->buildingLocation}}</td>
								<td align="center"><form action="/building/activate" method="post">{{csrf_field()}}<input type="hidden" name="id" value="{{$buildings->id}}"><button type="submit" class="btn btn-info">Reactivate</button></form></td
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
	$("#building").last().addClass( "active" );
</script>
@endsection