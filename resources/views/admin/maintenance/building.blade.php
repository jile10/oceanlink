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
	<h1>Building Maintenance</h1>
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
		<li class="active">Building</li>
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
						<button class="buttons btn btn-success" data-toggle="modal" data-href="#responsive" href="#responsive"><i class="glyphicon glyphicon-plus"></i>&ensp;New Building</button>	
					</div>
					<div class="col-md-6 text-right">
						<a href="/maintenance/building/archive" class="buttons btn btn-success"><i class="glyphicon glyphicon-folder-open"></i>&ensp;Archive</a>
					</div>
					<table class="table table-striped table-bordered" id="table1">
						<thead>
							<tr>
								<th width="30%">Name</th>
								<th width="50%">Address</th>
								<th width="20%">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($building as $buildings)
							<tr>
								<td>{{$buildings->buildingName}}</td>
								<td>{{$buildings->buildingLocation}}</td>
								<td align="center"><button class="btn btn-primary" data-toggle="modal" data-href="#update{{$buildings->id}}" onclick="clicks({{$buildings->id}})" href="#update{{$buildings->id}}">Update</button>
								<button type="submit" data-toggle="modal" data-href="#static{{$buildings->id}}" href="#static{{$buildings->id}}" class="btn btn-danger">Deactivate</button></td
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
			<form id="create-form" action="/building/insert" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<div class="modal-header btn-primary" >
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">New Building</h4>
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
								<label for="inputEmail3" class="col-sm-3 control-label">Name<font color="red">* </font></label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="buildingName" name="buildingName">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Address<font color="red">* </font></label>
								<div class="col-sm-8">
									<textarea type="text" class="form-control" rows="5" id="buildingLocation" name="buildingLocation"></textarea>
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
@foreach($building as $buildings)
<div class="modal fade in" id="update{{$buildings->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<form id="update-form{{$buildings->id}}" action="/building/update" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<input type="hidden" name="id" value="{{$buildings->id}}" >
				<div class="modal-header btn-primary">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Update Building</h4>
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
								<label for="inputEmail3" class="col-sm-3 control-label">Name <font color="red">* </font></label>
								<div class="col-sm-8">
									<input  type="text" value="{{$buildings->buildingName}}" class="form-control" name="buildingName">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Address<font color="red">* </font></label>
								<div class="col-sm-8">
									<textarea  type="text" class="form-control" rows="5" name="buildingLocation">{{$buildings->buildingLocation}}</textarea>
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
@foreach($building as $buildings)
<form action="/building/delete" method="post">
	{{csrf_field()}}
	<input type="hidden" name="id" value="{{$buildings->id}}">
	<div class="modal fade in" id="static{{$buildings->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	    <div class="modal-dialog modal-md">
	        <div class="modal-content">
	        		<div class="modal-header btn-danger">
        				<div class="modal-title">Deactivate</div>
        			</div>
	            <div class="modal-body">
                <span>&ensp;&ensp;Are you sure sure you want to deactivate <b>{{$buildings->buildingName}}</b>?</span>
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
	$("#buildings").last().addClass( "active" );
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
  		$('#buildingName').val("");
  		$('#buildingLocation').val("");
	})
</script>


<script type="text/javascript">

$.validator.addMethod("regx", function(value, element, regexpr) {          
    return regexpr.test(value);
}, "No special characters and white spaces");


	$(function(){
		$('#create-form').validate({
			rules:{
				buildingName:{
					required: true,
					regx: /(^[a-zA-Z0-9 -]+$)/i,
					space: true,
					maxlength: 50
				},
				buildingLocation:{
					maxlength: 150
				}
			}
		});
	});

	function clicks(id){
		$('#update-form'+id).validate({
			rules:{
				buildingName:{
					required: true,
					regx: /(^[a-zA-Z0-9 -]+$)/i,
					space: true,
					maxlength: 50
				},
				buildingLocation:{
					maxlength: 150,
					space: true
				}
			}
		});
	};
</script>

<script type="text/javascript">

		@foreach($building as $buildings)

			$('#update{{$buildings->id}}').on('hidden.bs.modal', function (e) {

	  		$('#update-form{{$buildings->id}}').trigger('reset');
  			$('#update-form{{$buildings->id}}').validate().resetForm();
	  		$('#update-form{{$buildings->id}}').find('.error').removeClass('error');
  		});
		@endforeach

		$('#responsive').on('hidden.bs.modal', function (e) {
    	$('#create-form').trigger('reset');
  		$('#create-form').validate().resetForm();
    	$('#create-form').find('.error').removeClass('error');
		});
</script>
@endsection