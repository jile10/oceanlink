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
	<h1>Program Type Maintenance</h1>
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
		<li class="active">Program Type</li>
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
						<button class="buttons btn btn-success" data-toggle="modal" data-href="#responsive" href="#responsive"><i class="glyphicon glyphicon-plus"></i>&ensp;New Program Type</button>
					</div>
					<div class="col-md-6 text-right">
						<a href="/maintenance/ptype/archive" class="buttons btn btn-success" ><i class="glyphicon glyphicon-folder-open"></i>&ensp;Archive</a>
					</div>
					<table class="table table-striped table-bordered" id="table1">
						<thead>
							<tr>
								<th width="30%">Name</th>
								<th width="50%">Description</th>
								<th width="50%">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($type as $types)
							<tr>
								<td>{{$types->typeName}}</td>
								<td>{{$types->typeDesc}}</td>
								<td align="center"><button class="btn btn-primary" data-toggle="modal" data-href="#update{{$types->id}}" onclick="clicks({{$types->id}})" href="#update{{$types->id}}">Update</button>
								<button type="button" data-toggle="modal" data-href="#static{{$types->id}}" href="#static{{$types->id}}" class="btn btn-danger">Deactivate</button></td>
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
			<form id="create-form" action="/type/insert" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<div class="modal-header btn-primary">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">New Program Type</h4>
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
								<label for="inputEmail3" class="col-sm-3 control-label">Name<font color="red">*</font></label>
								<div class="col-sm-8">
									<input required type="text" class="form-control" name="typeName">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Description</label>
								<div class="col-sm-8">
									<textarea type="text" class="form-control" rows="5" name="typeDesc"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer text-left">
					<button type="button" data-dismiss="modal" class="btn">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!--Update Modal-->

@foreach($type as $types)
<div class="modal fade in" id="update{{$types->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<form id="update-form{{$types->id}}" action="/type/update" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<input type="hidden" name="id" value="{{$types->id}}">
				<div class="modal-header btn-primary">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Update Program Type</h4>
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
								<label for="inputEmail3" class="col-sm-3 control-label">Name<font color="red">*</font></label>
								<div class="col-sm-8">
									<input required type="text" value="{{$types->typeName}}" class="form-control" name="typeName">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Description</label>
								<div class="col-sm-8">
									<textarea type="text" class="form-control" rows="5" name="typeDesc">{{$types->typeDesc}}</textarea>
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
@foreach($type as $types)
<form action="/type/delete" method="post">
	{{csrf_field()}}
	<input type="hidden" name="id" value="{{$types->id}}">
	<div data-toggle="modal" class="modal fade in" id="static{{$types->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	    <div class="modal-dialog modal-md">
	        <div class="modal-content">
	          <div class="modal-header btn-danger">
        			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        		<div class="modal-title">Deactivate</div>
        		</div>
            <div class="modal-body">
              <span>&ensp;&ensp;Are you sure sure you want to deactivate <b>{{$types->typeName}}</b>?</span>
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
	$("#programtype").last().addClass( "active" );
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

$.validator.addMethod("regx", function(value, element, regexpr) {          
    return regexpr.test(value);
}, "No special characters except(hypen ( - ) and apostrophe ( ' )");

	$(function(){
		$('#create-form').validate({
			rules:{
				typeName:{
					required: true,
					regx: /(^[a-zA-Z0-9 \'-()]+$)/i,
					space: true,
					maxlength: 50
				},
				typeDesc:{
					maxlength: 150
				}
			}
		});
	});

	function clicks(id){
		$('#update-form'+id).validate({
			rules:{
				typeName:{
					required: true,
					regx: /(^[a-zA-Z0-9 \'-()]+$)/i,
					space: true,
					maxlength: 50
				},
				typeDesc:{
					maxlength: 150
				}
			}
		});
	};
</script>

<script type="text/javascript">

		@foreach($type as $types)

			$('#update{{$types->id}}').on('hidden.bs.modal', function (e) {

	  		$('#update-form{{$types->id}}').trigger('reset');
  			$('#update-form{{$types->id}}').validate().resetForm();
	  		$('#update-form{{$types->id}}').find('.error').removeClass('error');
  		});
		@endforeach

		$('#responsive').on('hidden.bs.modal', function (e) {
    	$('#create-form').trigger('reset');
  		$('#create-form').validate().resetForm();
    	$('#create-form').find('.error').removeClass('error');
		});

</script>
@endsection