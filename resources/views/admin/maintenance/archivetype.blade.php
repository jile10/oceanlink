@extends('admin.layouts.default')

@section('content')
<!-- Content Header (Page header) --><section class="content-header">
	<!--section starts-->
	<h1>Program Type Archive</h1>
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
			<a href="/maintenance/ptype">Program Type</a>
		</li>
		<li class="active">Program Type Archive</li>
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
								<th width="50%">Description</th>
								<th ></th>
							</tr>
						</thead>
						<tbody>
							@foreach($type as $types)
							<tr>
								<td>{{$types->typeName}}</td>
								<td>{{$types->typeDesc}}</td>
								<td align="center"><form action="/type/activate" method="post">{{csrf_field()}}<input type="hidden" name="id" value="{{$types->id}}"><button type="submit" class="btn btn-info">Reactivate</button></form></td>
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
	$("#programtype").last().addClass( "active" );
</script>
@endsection