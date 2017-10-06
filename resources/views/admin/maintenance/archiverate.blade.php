@extends('admin.layouts.default')

@section('content')
<!-- Content Header (Page header) -->
<style type="text/css">
	.buttons{
		margin-top: 10px;
		margin-bottom: 20px;
	}

	.buttonss{
		margin-left: 5px;
	}
</style>
<section class="content-header">
	<!--section starts-->
	<h1>Course Archive</h1>
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
			<a href="/maintenance/rate">Course</a>
		</li>
		<li class="active">Course Archive</li>
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
								<th width="30%">Program Name</th>
								<th width="10%">Duration</th>
								<th width="15%">Class Hour</th>
								<th align="right" width="15%">Price &ensp;&ensp;(Php)</th>
								<th width="20%">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($rate as $rates)
							<tr>
								<td>{{$rates->program->programName}}</td>
								<td>{{$rates->duration}} Hours</td>
								<td>{{$rates->classHour}} Hours</td>
								<td align="right">{{number_format($rates->price,2)}}</td>
								<td align="center"><form action="/rate/activate" method="post">{{csrf_field()}}<input type="hidden" name="id" value="{{$rates->id}}"><button  type="submit" class="buttonss btn btn-info">Reactivate</button></form></td>
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
	$("#course").last().addClass( "active" );
</script>
@endsection