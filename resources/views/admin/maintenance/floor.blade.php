@extends('admin.layouts.default')

@section('css')

<link href="/vendors/panel/panel.css" rel="stylesheet" type="text/css"/>
@endsection
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
	<h1>Floor Maintenance</h1>
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
		<li class="active">Floor</li>
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
					<div class="col-md-6">
						<button class="buttons btn btn-success" data-toggle="modal" data-href="#responsive" href="#responsive"><i class="glyphicon glyphicon-plus"></i>&ensp;New Floor</button>
					</div>
					<div class="col-md-6 text-right">
						<a href="/maintenance/floor/archive" class="buttons btn btn-success"><i class="glyphicon glyphicon-folder-open"></i>&ensp;Archive</a>
					</div>
					
					<table class="table table-striped table-bordered" id="table1">
						<thead>
							<tr>
								<th width="25%">Name</th>
								<th width="40%">Building</th>
								<th width="35%">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($floor as $floors)
							<tr>
								<td>{{$floors->floorName}}</td>
								<td>{{$floors->building->buildingName}}</td>
								<td align="center">
									<button class="btn btn-primary" data-toggle="modal" data-href="#update{{$floors->id}}" onclick="clicks({{$floors->id}})" href="#update{{$floors->id}}">Update
									</button>
									<button type="submit" data-toggle="modal" data-href="#static{{$floors->id}}" href="#static{{$floors->id}}" class="btn btn-danger">Deactivate</button>
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
			<form id="create-form" action="/floor/insert" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<div class="modal-header btn-primary">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">New Floor</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="row">
							<div class="col-md-12">
								<div class="alert alert-success">
										<p><em>Note: <font color="red">*</font> fields are required</em></p>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Building<font color="red">*</font></label>
								<div class="col-sm-8">
									<select required name="building_id" class="form-control">
										@foreach($building as $buildings)
										<option value="{{$buildings->id}}">{{$buildings->buildingName}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Floor Name<font color="red">*</font></label>
								<div class="col-sm-8">
									<input required type="text" class="form-control" name="floorName" id="floorName">
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
@foreach($floor as $floors)
<div class="modal fade in" id="update{{$floors->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<form id="update-form{{$floors->id}}" action="/floor/update" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<input type="hidden" name="id" value="{{$floors->id}}">
				<div class="modal-header btn-primary">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Update Floor</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="row">
							<div class="col-md-12">
								<div class="alert alert-success">
										<p><em>Note: <font color="red">*</font> fields are required</em></p>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Building<font color="red">*</font></label>
								<div class="col-sm-8">
									<select required name="building_id" class="form-control">
										@foreach($building as $buildings)
										@if($buildings->id == $floors->building->id)
										<option selected value="{{$buildings->id}}">{{$buildings->buildingName}}</option>
										@else
										<option value="{{$buildings->id}}">{{$buildings->buildingName}}</option>
										@endif
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Floor Name<font color="red">*</font></label>
								<div class="col-sm-8">
									<input required type="text" value="{{$floors->floorName}}" class="form-control" name="floorName">
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
<!--Confirmation modal-->
@foreach($floor as $floors)
<form action="/floor/delete" method="post">
	{{csrf_field()}}
	<input type="hidden" name="id" value="{{$floors->id}}">
	<div data-toggle="modal" class="modal fade in" id="static{{$floors->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	    <div class="modal-dialog modal-md">
	        <div class="modal-content">
	        	<div class="modal-header btn-danger">
        			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        		<div class="modal-title">Deactivate</div>
        		</div>
	            <div class="modal-body">
                <span>&ensp;&ensp;Are you sure sure you want to deactivate <b>{{$floors->floorName}} {{$floors->building->buildingName}}</b>?</span>
	            </div>
	            <div class="modal-footer">
	                <button type="button" data-dismiss="modal" class="btn">No</button>
	                <button type="submit" class="btn btn-primary">Yes</button>
	            </div>
	        </div>
	    </div>
	</div>
</form>
@endforeach
@endsection
@section('js')
<script>
	$(document).ready( function(){
		var table = $('#table1').DataTable();
	});

	$("#maintenance").last().addClass( "active" );
	$("#floors").last().addClass( "active" );
</script>
<script type="text/javascript">
	 @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;
        
        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
  @endif
</script>

<script type="text/javascript">
	$('#responsive').on('hidden.bs.modal', function (e) {
  		$('#floorName').val("");
	})
</script>

<script type="text/javascript">

$.validator.addMethod("regx", function(value, element, regexpr) {          
    return regexpr.test(value);
}, "No special characters and white spaces");

	$(function(){
		$('#create-form').validate({
			rules:{
				floorName:{
					required: true,
					regx: /(^[a-zA-Z0-9 ]+$)/i,
					space: true,
					maxlength: 50
				}
			}
		});
	});

	function clicks(id){
		$('#update-form'+id).validate({
			rules:{
				floorName:{
					required: true,
					regx: /(^[a-zA-Z0-9 ]+$)/i,
					space: true,
					maxlength: 50
				}
			}
		});
	};
</script>

<script type="text/javascript">

		@foreach($floor as $floors)

			$('#update{{$floors->id}}').on('hidden.bs.modal', function (e) {

	  		$('#update-form{{$floors->id}}').trigger('reset');
  			$('#update-form{{$floors->id}}').validate().resetForm();
	  		$('#update-form{{$floors->id}}').find('.error').removeClass('error');
  		});
		@endforeach

		$('#responsive').on('hidden.bs.modal', function (e) {
    	$('#create-form').trigger('reset');
  		$('#create-form').validate().resetForm();
    	$('#create-form').find('.error').removeClass('error');
		});
</script>
@endsection