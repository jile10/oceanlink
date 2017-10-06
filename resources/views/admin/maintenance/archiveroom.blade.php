@extends('admin.layouts.default')

@section('content')
<style type="text/css">
	.buttons{
		margin-top: 10px;
		margin-bottom: 20px;
	}
</style>
<section class="content-header">
	<!--section starts-->
	<h1>Training Room Maintenance</h1>
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
			<a href="/maintenance/room">Training Room</a>
		</li>
		<li class="active">Training Room Archive</li>
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
								<th width="20%">Room Number</th>
								<th width="10%">Capacity</th>
								<th width="25%">Building</th>
								<th width="25%">Floor</th>
								<th ></th>
							</tr>
						</thead>
						<tbody>
							@foreach($room as $rooms)
							<tr>
								<td width="15%">{{$rooms->room_no}}</td>
								<td width="10%">{{$rooms->capacity}}</td>
								<td width="25%">{{$rooms->building->buildingName}}</td>
								<td width="25%">{{$rooms->floor->floorName}}</td>
								<td align="center"><form action="/room/activate" method="post">{{csrf_field()}}<input type="hidden" name="id" value="{{$rooms->id}}"><button type="submit" class="btn btn-info">Reactivate</button></form></td>
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
	$("#room").last().addClass( "active" );
</script>
@endsection