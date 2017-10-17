@extends('admin.layouts.default')
@section('content')
<section class="content-header">
	<!--section starts-->
	<h1>Holiday Maintenance</h1>
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
		<li > <a href="/maintenance/holiday">Holiday</a></li>
		<li class="active">Archive</li>
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
							<th width="40%">Name</th>
							<th width="20%">Date Start</th>
							<th width="20%">Date End</th>
							<th width="20%">Action</th>
						</thead>
						<tbody>
							@foreach($holiday as $holidays)
							<tr>
								<td>{{$holidays->holidayName}}</td>
								<td>{{Carbon\Carbon::parse($holidays->dateStart)->format("F d, Y")}}</td>
								<td>{{Carbon\Carbon::parse($holidays->dateEnd)->format("F d, Y")}}</td>
								<td><form action="/holiday/activate" method="post">{{csrf_field()}}<input type="hidden" name="id" value="{{$holidays->id}}"><button type="submit" class="btn btn-primary">Reactivate</button></form></td>
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
<script type="text/javascript">
	$("#maintenance").last().addClass( "active" );
	$('#holiday').last().addClass(" active ");

	$(document).ready( function(){
		var table = $('#table1').DataTable({
			"order":[[1,"desc"]]
		});
	});
</script>
@endsection