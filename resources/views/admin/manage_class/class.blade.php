@extends('admin.layouts.default')
@section("css")
<style type="text/css">
	.btn{
		margin-left: 5px;
	}
</style>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<!--section starts-->
	<h1>Classes</h1>
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
		<li class="active">
			Manage Class
		</li>
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
					<table class="table table-striped table-bordered" id="table1">
						<thead>
							<tr>
								<th width="15%">Class Name</th>
								<th width="25%">Course Name</th>
								<th width="20%">Training Officer</th>
								<th width="15%">Class End</th>
								<th width="25%">Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($tclass as $tclasses)
								<tr>
									<td>{{$tclasses['class_name']}}</td>
									<td>{{$tclasses['course_name']}}</td>
									<td>{{$tclasses['officer']}}</td> 
									<td>{{$tclasses['dateEnd']}}</td>
									<td><div class="col-md-6" style="margin-left: -15px;"><form action="/manage_class/setgrade" method="post">{{csrf_field()}}<input type="hidden" name="id" value="{{$tclasses['id']}}"><button type="submit"  class="btn btn-primary">Set Grade</button></form></div><div class="col-md-6 " style="margin-left: -15px;"> <form action="/manage_class/setattendance" method="post">{{csrf_field()}}<input type="hidden" name="id" value="{{$tclasses['id']}}"><button type="submit" class="btn btn-primary">Set Attendance</button></form></div></td>
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
	$("#transaction").last().addClass( "active" );
	$("#manage_class").last().addClass( "active" );
</script>
@endsection