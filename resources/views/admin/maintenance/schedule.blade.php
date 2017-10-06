@extends('admin.layouts.default')

@section('content')
<style type="text/css">
	.buttons{
		margin-top: 10px;
		margin-bottom: 20px;
	}
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
	<!--section starts-->
	<h1>Schedule Maintenance</h1>
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
		<li class="active">Schedule</li>
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
					<button class="buttons btn btn-success" data-toggle="modal" data-href="#responsive" href="#responsive"><i class="glyphicon glyphicon-plus"></i>&ensp;New Schedule</button>
					<table class="table table-striped table-bordered" id="table1">
						<thead>
							<tr>
								<th width="30%">Program Name</th>
								<th width="20%">Day</th>
								<th width="15%">Time Start</th>
								<th width="15%">Time End</th>
								<th ></th>
								<th ></th>
							</tr>
						</thead>
						<tbody>
							@foreach($schedule as $schedules)
							<tr>
								<td>{{$schedules->program->programName}}</td>
								<td>
								@foreach($schedules->detail as $detail)
									@if($schedules->detail->last() == $detail)
									{{$detail->day->dayName}}
									@else
									{{$detail->day->dayName}}-
									@endif
								@endforeach
								</td>
								<td>{{Carbon\Carbon::parse($schedules->start)->format('g:i A')}}</td>
								<td>{{Carbon\Carbon::parse($schedules->end)->format('g:i A')}}</td>
								<td align="center"><button class="btn btn-info" data-toggle="modal" data-href="#update{{$schedules->id}}" href="#update{{$schedules->id}}">Update</button></td>
								<td align="center"><form action="/room/delete" method="post">{{csrf_field()}}<input type="hidden" name="id" value="{{$schedules->id}}"><button type="submit" class="btn btn-danger">Deactivate</button></form></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<!--Create Modal-->
<div class="modal fade in" id="responsive" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="/schedule/insert" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">New Program Type</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Program Name</label>
								<div class="col-sm-6">
									<select name="program_id" class="form-control">
										@foreach($program as $programs)
											<option value="{{$programs->id}}">{{$programs->programName}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Day(s)</label>
								<div class="col-sm-8">
									<div class="col-md-12">
                                        <label class="checkbox-inline mar-left5" for="example-inline-checkbox1">
                                            <input type="checkbox" id="example-inline-checkbox1" name="check_id[]" value="1">Monday</label>
                                        <label class="checkbox-inline mar-left5" for="example-inline-checkbox2">
                                            <input type="checkbox" id="example-inline-checkbox2" name="check_id[]" value="2">Tuesday</label>
                                        <label class="checkbox-inline mar-left5" for="example-inline-checkbox3"><input type="checkbox" id="example-inline-checkbox3" name="check_id[]" value="3">Wednesday</label>
                                        <label class="checkbox-inline mar-left5" for="example-inline-checkbox4"><input type="checkbox" id="example-inline-checkbox4" name="check_id[]" value="4">Thursday</label>
                                        <label class="checkbox-inline mar-left5" for="example-inline-checkbox5"><input type="checkbox" id="example-inline-checkbox5" name="check_id[]" value="5">Friday</label>
                                        <label class="checkbox-inline mar-left5" for="example-inline-checkbox6"><input type="checkbox" id="example-inline-checkbox6" name="check_id[]" value="6">Saturday</label>
                                    </div>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Time Start</label>
								<div class="col-sm-2">
					                <input data-format="hh:mm A" class="form-control sel-time-am" type="text" name="start">
                                </div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Time End</label>
								<div class="col-sm-2">
					                <input data-format="hh:mm A" class="form-control sel-time-am" type="text" name="end">
                                </div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--Update Modal-->
@foreach($schedule as $schedules)
<div class="modal fade in" id="update{{$schedules->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="/schedule/update" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<input type="hidden" name="id" value="{{$schedules->id}}">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Update Schedule</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Program Name</label>
								<div class="col-sm-6">
									<select name="program_id" class="form-control">
										@foreach($program as $programs)
											@if($programs->programName == $schedules->program->programName)
											<option selected value="{{$programs->id}}">{{$programs->programName}}</option>
											@else
											<option value="{{$programs->id}}">{{$programs->programName}}</option>
											@endif
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Day(s)</label>
								<div class="col-sm-8">
									<div class="col-md-12">
										@foreach($day as $days)
											<?php $check = false; ?> 
	                                        @foreach($schedules->detail as $detail)
	                                        	@if($days->id == $detail->day->id)
	                                        		<?php $check = true; ?>
	                                        	@endif
	                                        @endforeach
	                                        @if($check)
	                                        	<label class="checkbox-inline mar-left5" for="example-inline-checkbox6"><input checked type="checkbox" id="example-inline-checkbox6" name="check_id[]" value="{{$days->id}}">{{$days->dayName}}</label>
	                                        @else
	                                        	<label class="checkbox-inline mar-left5" for="example-inline-checkbox6"><input type="checkbox" id="example-inline-checkbox6" name="check_id[]" value="{{$days->id}}">{{$days->dayName}}</label>
	                                        @endif
                                        @endforeach
                                    </div>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Time Start</label>
								<div class="col-sm-2">
					                <input data-format="hh:mm A" class="form-control sel-time-am" type="text" name="start" value="{{Carbon\Carbon::parse($schedules->start)->format('g:i A')}}" >
                                </div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Time End</label>
								<div class="col-sm-2">
					                <input data-format="hh:mm A" class="form-control sel-time-am" type="text" name="end" value="{{Carbon\Carbon::parse($schedules->end)->format('g:i A')}}">
                                </div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endforeach
@endsection
@section('js')
<script>
	$(document).ready( function(){
		var table = $('#table1').DataTable();
	});
	$('.sel-time-am').clockface();
</script>
@endsection