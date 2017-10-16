@extends('training_officer.layouts.default')

@section('content')

<style type="text/css">
	.buttons{
		margin-left: 87.2%;
		margin-bottom: 2.5%;
	}
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
	<!--section starts-->
	<h1>My Class</h1>
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
								<th width="20%">Class Name</th>
								<th width="30%">Course Name</th>
								<th width="15%">No. of Students</th>
								<th width="15%">Status</th>
								<th width="15">Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($officer->scheduledprogram as $sprog)
								@if($sprog->trainingclass->status != 5)
									<tr>
										<td>{{$sprog->trainingclass->class_name}}</td>
										<td>{{$sprog->rate->program->programName . ' (' . $sprog->rate->duration . ' Hours)'}}</td>
										@if(count($sprog->trainingclass->groupapplicationdetail)==0)
											<td>{{count($sprog->trainingclass->classdetail->where('status','!=',1))}}</td>
										@else
											<td>{{count($sprog->trainingclass->groupclassdetail)}}</td>
										@endif
										<td>
											@if($sprog->trainingclass->status == 0)
												Pending
											@elseif($sprog->trainingclass->status == 1)
												Not yet started 
											@elseif($sprog->trainingclass->status == 2) 
												Started 
											@elseif($sprog->trainingclass->status == 4)
												Ended
											@endif
										</td>
										<td><form  action="/tofficer/setclass" method="get"><input type="hidden" name="officer_id" value="{{$officer->id}}"><button style="margin-bottom: 5px;" type="submit" name="tclass_id" value="{{$sprog->trainingclass->id}}" class="btn btn-primary col-sm-8">View Class</button></form>@if($sprog->trainingclass->status == 2) <form action="/enrollmentreport" method="post" target="_blank">{{csrf_field()}}<button style="margin-bottom: 5px;" type="submit" name="tclass_id" value="{{$sprog->trainingclass->id}}" class="btn btn-info col-sm-12"><i class="glyphicon glyphicon-print"></i>&ensp;Print Enrollment Report</button></form>@endif
										@if(count($sprog->trainingclass->classdetail)>0)
										@if(count($sprog->trainingclass->classdetail->first()->grade)>0)
										<form action="/gradingreport" method="post" target="_blank">{{csrf_field()}}<button  type="submit" style="margin-bottom: 5px;" name="tclass_id" value="{{$sprog->trainingclass->id}}" class="btn btn-info col-sm-12"><i class="glyphicon glyphicon-print"></i>&ensp;Print Grade Report</button></form>
										@endif
										@else
										@if(count($sprog->trainingclass->groupclassdetail->first()->groupgrade)>0)
										<form action="/gradingreport" method="post" target="_blank">{{csrf_field()}}<button  type="submit" style="margin-bottom: 5px;" name="tclass_id" value="{{$sprog->trainingclass->id}}" class="btn btn-info col-sm-12"><i class="glyphicon glyphicon-print"></i>&ensp;Print Grade Report</button></form>
										@endif
										@endif
										@if(count($sprog->trainingclass->classdetail)>0)
										@if(count($sprog->trainingclass->attendance->attend)/count($sprog->trainingclass->classdetail) == $sprog->rate->duration / $sprog->rate->classHour)
										<form action="/attendancereport" method="post" target="_blank">{{csrf_field()}}<button style="margin-bottom: 5px;"  type="submit" name="tclass_id" value="{{$sprog->trainingclass->id}}" class="btn btn-info col-sm-12"><i class="glyphicon glyphicon-print"></i>&ensp;Print Attendance Report</button></form>
										@endif
										@else
										@if(count($sprog->trainingclass->attendance->groupattend)/count($sprog->trainingclass->groupclassdetail) == $sprog->rate->duration / $sprog->rate->classHour)
										<form action="/attendancereport" method="post" target="_blank">{{csrf_field()}}<button style="margin-bottom: 5px;" type="submit" name="tclass_id" value="{{$sprog->trainingclass->id}}" class="btn btn-info col-sm-12"><i class="glyphicon glyphicon-print"></i>&ensp;Print Attendance Report</button></form>
										@endif
										@endif
										</td>
									</tr>
								@endif
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
	$('.sel-time-am').clockface();
	$('#attendance').addClass( "active" );
</script>
@endsection