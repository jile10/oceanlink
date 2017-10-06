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
	<h1>Program Maintenance</h1>
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
			<a href="/maintenance/program">Program</a>
		</li>
		<li class="active">Program Archive</li>
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
								<th width="10%">Code</th>
								<th width="20%">Name</th>
								<th width="30%">Description</th>
								<th width="20%">Type</th>
								<th ></th>
							</tr>
						</thead>
						<tbody>
							@foreach($program as $programs)
							<tr>
								<td>{{$programs->programCode}}</td>
								<td>{{$programs->programName}}</td>
								<td>{{$programs->programDesc}}</td>
								<td>{{$programs->programtype->typeName}}</td>
								<td align="center"><form action="/program/activate" method="post">{{csrf_field()}}<input type="hidden" name="id" value="{{$programs->id}}"><button type="submit" class="btn btn-info">Reactivate</button></form></td>
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
	$("#program").last().addClass( "active" );
</script>
@endsection