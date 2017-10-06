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
	<h1>Program Maintenance</h1>
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
		<li class="active">Program</li>
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
						<button class="buttons btn btn-success" data-toggle="modal" data-href="#responsive" href="#responsive"><i class="glyphicon glyphicon-plus"></i>&ensp;New Program</button>
					</div>
					<div class="col-md-6 text-right">
						<a href="/maintenance/program/archive" class="buttons btn btn-success" ><i class="glyphicon glyphicon-folder-open"></i>&ensp;Archive</a>
					</div>
					<table class="table table-striped table-bordered" id="table1">
						<thead>
							<tr>
								<th width="10%">Code</th>
								<th width="20%">Name</th>
								<th width="30%">Description</th>
								<th width="20%">Type</th>
								<th width="20%">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($program as $programs)
							<tr>
								<td>{{$programs->programCode}}</td>
								<td>{{$programs->programName}}</td>
								<td>{{$programs->programDesc}}</td>
								<td>{{$programs->programtype->typeName}}</td>
								<td align="center"><button class="btn btn-primary" data-toggle="modal" onclick="clicks({{$programs->id}})" data-href="#update{{$programs->id}}" href="#update{{$programs->id}}">Update</button>
								<button data-toggle="modal"  data-href="#static{{$programs->id}}" href="#static{{$programs->id}}" class="btn btn-danger">Deactivate</button>
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
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form id="create-form" action="/program/insert" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<div class="modal-header btn-primary">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">New Program</h4>
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
								<label for="inputEmail3" class="col-sm-3 control-label">Type<font color="red">*</font></label>
								<div class="col-sm-8">
									<select required name="type_id" class="form-control">
										@foreach($type as $types)
										<option value="{{$types->id}}" >{{$types->typeName}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Name<font color="red">*</font></label>
								<div class="col-sm-8">
									<input required="" type="text" class="form-control" name="programName" id="programName">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Code<font color="red">*</font></label>
								<div class="col-sm-2">
									<input value="OL10{{count($program)+1}}" required type="text" class="form-control" name="programCode" id="programCode">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Description</label>
								<div class="col-sm-8">
									<textarea type="text" class="form-control" rows="5" name="programDesc" id="programDesc"></textarea>
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
@foreach($program as $programs)
<div class="modal fade in" id="update{{$programs->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form id="update-form{{$programs->id}}" action="/program/update" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<input type="hidden" name="id" value="{{$programs->id}}" >
				<div class="modal-header btn-primary">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Update Program</h4>
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
								<label for="inputEmail3" class="col-sm-3 control-label">Type<font color="red">*</font></label>
								<div class="col-sm-8">
									<select name="type_id" class="form-control">
										@foreach($type as $types)
											@if($types->typeName == $programs->programtype->typeName)
											<option selected value="{{$types->id}}" >{{$types->typeName}}</option>
											@else
											<option value="{{$types->id}}" >{{$types->typeName}}</option>
											@endif
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Name<font color="red">*</font></label>
								<div class="col-sm-8">
									<input type="text" value="{{$programs->programName}}" class="form-control" name="programName">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Code<font color="red">*</font></label>
								<div class="col-sm-2">
									<input type="text" value="{{$programs->programCode}}" class="form-control" name="programCode">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Description</label>
								<div class="col-sm-8">
									<textarea type="text" class="form-control" rows="5" name="programDesc">{{$programs->programDesc}}</textarea>
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
@foreach($program as $programs)
<form action="/program/delete" method="post">
	{{csrf_field()}}
	<input type="hidden" name="id" value="{{$programs->id}}">
	<div data-toggle="modal" class="modal fade in" id="static{{$programs->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	    <div class="modal-dialog modal-md">
	        <div class="modal-content">
	          <div class="modal-header btn-danger">
        			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        			<div class="modal-title">Deactivate</div>
        		</div>
            <div class="modal-body">
              <span>&ensp;&ensp;Are you sure sure you want to deactivate <b>{{$programs->programName}}</b>?</span>
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
	$("#program").last().addClass( "active" );
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
}, "No special characters except(hypen ( - ))");

$.validator.addMethod("regx1", function(value, element, regexpr) {          
    return regexpr.test(value);
}, "No special characters except(hypen ( - ) and apostrophe ( ' ))");

	$(function(){
		$('#create-form').validate({
			rules:{
				programCode:{
					required: true,
					regx: /(^[a-zA-Z0-9 -]+$)/i,
					space: true,
					maxlength: 15
				},
				programName:{
					required: true,
					regx1: /(^[a-zA-Z0-9 \'-]+$)/i,
					space: true,
					maxlength: 50
				},
				programDesc:{
					maxlength: 150
				}
			}
		});
	});
	function clicks(id){
		console.log(id);
		$('#update-form'+id).validate({
			rules:{
				programCode:{
					required: true,
					regx: /(^[a-zA-Z0-9 -]+$)/i,
					space: true,
					maxlength: 15
				},
				programName:{
					required: true,
					regx1: /(^[a-zA-Z0-9 \'-]+$)/i,
					space: true,
					maxlength: 50
				},
				programDesc:{
					maxlength: 150
				}
			}
		});
	};
</script>


@endsection