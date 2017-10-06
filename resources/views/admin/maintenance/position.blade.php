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
	<h1>Position</h1>
	<ol class="breadcrumb">
		<li>
			<a href="{{url('/admin')}}">
				<i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
				Home
			</a>
		</li>
		<li>
			<a >Utilities</a>
		</li>
		<li class="active">Position</li>
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
					<button class="buttons btn btn-success" data-toggle="modal" data-href="#responsive" href="#responsive"><i class="glyphicon glyphicon-plus"></i>&ensp;New Position</button>
					<table class="table table-striped table-bordered" id="table1">
						<thead>
							<tr>
								<th width="20%">Name</th>
								<th width="50%">Description</th>
								<th width="30%">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($position as $positions)
							<tr>
								<td>{{$positions->positionName}}</td>
								<td>{{$positions->positionDesc}}</td>
								<td>
									<button style="display: inline;" class="btn btn-primary" data-toggle="modal" data-href="#update{{$positions->id}}" onclick="clicks({{$positions->id}})" href="#update{{$positions->id}}">Update
									</button>
									<form action="/position/delete" method="post" style="margin: 0;padding: 0;">{{csrf_field()}}
										<input style="display: none;" name="id" value="{{$positions->id}}">
										<button style="display: inline;" type="submit" class="btn btn-danger">Deactivate</button>
									</form>
								</td>
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
	<div class="modal-dialog modal-md">
		<div class="modal-content"> 
			<form action="/position/insert" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<div class="modal-header btn-primary">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">New Position</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Name<font color="red">*</font></label>
								<div class="col-sm-9">
									<input required type="text" class="form-control" name="positionName">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Description</label>
								<div class="col-sm-9">
									<textarea id="example-textarea-input" name="positionDesc" rows="5" class="form-control"></textarea>
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
@foreach($position as $positions)
<div class="modal fade in" id="update{{$positions->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<form action="/position/update" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<input type="hidden" name="id" value="{{$positions->id}}" >
				<div class="modal-header btn-primary">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Update Position</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Name<font color="red">*</font></label>
								<div class="col-sm-9">
									<input value="{{$positions->positionName}}" type="text" class="form-control" name="positionName">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Description</label>
								<div class="col-sm-9">
									<textarea required id="example-textarea-input" name="positionDesc" rows="5" class="form-control">{{$positions->positionDesc}}</textarea>
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
</script>
@endsection