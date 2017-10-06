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
	<h1>Issuance of Certificate</h1>
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
			Issuance of Certificate
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
					<div class="nav-tabs-custom">
	                    <ul class="nav nav-tabs" style="margin-bottom: 15px;">
	                        <li class="active">
	                            <a href="#single" data-toggle="tab">Single</a>
	                        </li>
	                        <li>
	                            <a href="#group" data-toggle="tab">Group</a>
	                        </li>
	                        <li class="pull-right">
                                <a href="/collection/paymenthistory" class="text-muted">
                                    <i class="fa fa-gear">&ensp;Payment History</i>
                                </a>
                            </li>
	                    </ul>
	                    <div id="myTabContent" class="tab-content">
	                        <div class="tab-pane fade active in" id="single">
	                            <table class="table table-striped table-bordered" id="table1">
									<thead>
										<tr>
											<th width="20%">Class Name</th>
											<th width="30%">Course Name</th>
											<th width="15">No. of Students</th>
											<th width="15%">Actions</th>
										</tr>
									</thead>
									<tbody>
										@foreach($tclass as $tclasses)
											@if(count($tclasses->classdetail)!=0)
											<tr>
												<td>{{$tclasses->class_name}}</td>
												<td>{{$tclasses->scheduledprogram->rate->program->programName. ' (' . $tclasses->scheduledprogram->rate->duration . ' Hours)'}}</td>
												<td>{{count($tclasses->classdetail)}}</td>												<td><form action="/issuance/class" method="get"><input type="hidden" name="id" value="{{$tclasses->id}}"><button class="btn btn-primary"><i class="glyphicon glyphicon-hand-up"></i>&ensp;Select</button></form></td>
											</tr>
											@endif
										@endforeach
									</tbody>
								</table>
	                        </div>
	                        <div class="tab-pane fade" id="group">
	                            <table class="table table-striped table-bordered" id="table1">
									<thead>
										<tr>
											<th width="20%">Class Name</th>
											<th width="30%">Course Name</th>
											<th width="15">No. of Students</th>
											<th width="20">Status</th>
											<th width="15%">Actions</th>
										</tr>
									</thead>
									<tbody>
										@foreach($tclass as $tclasses)
											@if(count($tclasses->groupclassdetail)!=0)
											<tr>
												<td>{{$tclasses->class_name}}</td>
												<td>{{$tclasses->scheduledprogram->rate->program->programName. ' (' . $tclasses->scheduledprogram->rate->duration . ' Hours)'}}</td>
												<td>{{count($tclasses->groupclassdetail)}}</td>
												<td>
													@if($tclasses->groupapplicationdetail->application_status != 3)
													On Hold
													@else
													Ready
													@endif
												</td>
												<td>@if($tclasses->groupapplicationdetail->application_status != 3)<a disabled href="/certificate/{{$tclasses->id}}" class="btn btn-primary">Print</a>@else <a href="/certificate/{{$tclasses->id}}" class="btn btn-primary">Print</a>@endif</td>
											</tr>
											@endif
										@endforeach
									</tbody>
								</table>                        
							</div>
	                    </div>
	                </div>
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
	$("#issuance").last().addClass( "active" );
</script>
@endsection