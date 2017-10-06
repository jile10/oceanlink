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
	<h1>Floor Archive</h1>
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
			<a href="/maintenance/floor">Floor</a>
		</li>
		<li class="active">Floor Archive</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-8">
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
								<th width="40%">Building</th>
								<th ></th>
							</tr>
						</thead>
						<tbody>
							@foreach($floor as $floors)
							<tr>
								<td>{{$floors->floorName}}</td>
								<td>{{$floors->building->buildingName}}</td>
								<td align="center"><form action="/floor/activate" method="post">{{csrf_field()}}<input type="hidden" name="id" value="{{$floors->id}}"><button type="submit" class="btn btn-info">Reactivate</button></form></td
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
	$("#floor").last().addClass( "active" );
</script>
@endsection