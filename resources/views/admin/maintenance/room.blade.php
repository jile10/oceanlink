@extends('admin.layouts.default')

@section('css')
<link href="/vendors/panel/panel.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
<style type="text/css">
	.buttons{
		margin-top: 10px;
		margin-bottom: 20px;
	}
</style>
<section class="content-header">
	<!--section starts-->
	<h1>Training Room Maintenance</h1>
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
		<li class="active">Training Room</li>
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
						<button class="buttons btn btn-success" data-toggle="modal" data-href="#responsive" href="#responsive"><i class="glyphicon glyphicon-plus"></i>&ensp;New Training Room</button>
					</div>
					<div class="col-md-6 text-right">
						<a href="/maintenance/room/archive" class="buttons btn btn-success"><i class="glyphicon glyphicon-folder-open"></i>&ensp;Archive</a>
					</div>
					<table class="table table-striped table-bordered" id="table1">
						<thead>
							<tr>
								<th width="20%">Room Number</th>
								<th width="10%">Capacity</th>
								<th width="25%">Building</th>
								<th width="25%">Floor</th>
								<th width="20%">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($room as $rooms)
							<tr>
								<th width="15%">{{$rooms->room_no}}</th>
								<th width="10%">{{$rooms->capacity}}</th>
								<th width="25%">{{$rooms->building->buildingName}}</th>
								<th width="25%">{{$rooms->floor->floorName}}</th>
								<td align="center"><button class="btn btn-primary" data-toggle="modal" data-href="#update{{$rooms->id}}" onclick="clicks({{$rooms->id}})" href="#update{{$rooms->id}}">Update</button>
								<button type="submit" data-toggle="modal" data-href="#static{{$rooms->id}}" href="#static{{$rooms->id}}" class="btn btn-danger">Deactivate</button></td>
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
			<form id="create-form" action="/room/insert" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<div class="modal-header btn-primary">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">New Training Room</h4>
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
								<label for="inputEmail3" class="col-sm-3 control-label">Building Name<font color="red">*</font></label>
								<div class="col-sm-8">
									<select required id="building" name="building_id" class="form-control">
										@foreach($building as $buildings)
										<option value="{{$buildings->id}}" >{{$buildings->buildingName}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Floor Name<font color="red">*</font></label>
								<div class="col-sm-8">
									<select required id="floor" name="floor_id" class="form-control">
										@foreach($floorfirst as $floors)
												<option value="{{$floors->id}}">{{$floors->floorName}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Room Name<font color="red">*</font></label>
								<div class="col-sm-4">
									<input required type="text" class="form-control" name="room_no" maxlength="10">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Capacity (max)<font color="red">*</font></label>
								<div class="col-sm-4">
									<input required type="text" class="form-control" name="capacity" maxlength="5">
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
@foreach($room as $rooms)
<div class="modal fade in" id="update{{$rooms->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<form id="update-form{{$rooms->id}}" action="/room/update" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<input type="hidden" name="id" value="{{$rooms->id}}">
				<div class="modal-header btn-primary">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Update Training Room</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12" style="margin-bottom: 20px;">
							<h5><i>Note: </i><font color="red">&ensp;&ensp;* </font><i> fields are required</i></h5>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Building<font color="red">*</font></label>
								<div class="col-sm-8">
									<select required id="{{$rooms->id}}" name="building_id" class="form-control" onchange="change(this.id)">
										@foreach($building as $buildings)
											@if($buildings->buildingName == $rooms->building->buildingName)
												<option selected value="{{$buildings->id}}" >{{$buildings->buildingName}}</option>
											@else
												<option value="{{$buildings->id}}" >{{$buildings->buildingName}}</option>
											@endif
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Floor Name<font color="red">*</font></label>
								<div class="col-sm-8">
									<select required id="floor{{$rooms->id}}" name="floor_id" class="form-control">
										<option value="{{$rooms->floor->id}}">{{$rooms->floor->floorName}}</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Room Name<font color="red">*</font></label>
								<div class="col-sm-4">
									<input required type="text" value="{{$rooms->room_no}}" class="form-control" name="room_no" maxlength="10">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Capacity (max)<font color="red">*</font></label>
								<div class="col-sm-4">
									<input required type="text" value="{{$rooms->capacity}}" class="form-control" name="capacity"  maxlength="5">
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
@foreach($room as $rooms)
<form action="/room/delete" method="post">
	{{csrf_field()}}
	<input type="hidden" name="id" value="{{$rooms->id}}">
	<div data-toggle="modal" class="modal fade in" id="static{{$rooms->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	    <div class="modal-dialog modal-md">
	        <div class="modal-content">
	          <div class="modal-header btn-danger">
        			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        		<div class="modal-title">Deactivate</div>
        		</div>
            <div class="modal-body">
              <span>&ensp;&ensp;Are you sure sure you want to deactivate <b>Room {{$rooms->room_no}}</b>?</span>
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

	$("#maintenance").last().addClass( "active" );
	$("#room").last().addClass( "active" );

		$(document).on('change','#building',function(){
    		console.log('hmm its change');
    		var building_id = $(this).val();
    		var div = $(this).parent().parent();
   			var op=" ";
    		console.log(building_id);
    		$.ajax({
    			type:'get',
    			url:'{!!URL::to('ajax-floor')!!}',
    			data:{'id':building_id},
    			success:function(data){

					$('#floor').empty();
    				console.log('succes');
    				console.log(data);

    				console.log(data.length);
    				if(data.length>0){
	    				for(var i=0;i<data.length;i++){
	    					$('#floor').append('<option value="'+data[i].id+'">'+data[i].floorName+'</option>');
	    				}
    				}
    				else{
    					$('#floor').append('<option selected disabled>--No floors yet in this building--</option>');
    				}
    				
    			},
    			error:function(){

    			}
    		});
    	});
	});
	function change(id){
        var building_id = $('#'+id).val();
        $.ajax({
            type:'get',
            url:'{!!URL::to('ajax-floor')!!}',
            data:{'id':building_id},
            success:function(data){

                $('#floor'+id).empty();
                console.log('succes');
                console.log(data);

                console.log(data.length);
                for(var i=0;i<data.length;i++){
                    $('#floor'+id).append('<option value="'+data[i].id+'">'+data[i].floorName+'</option>');
                }
            },
            error:function(){

            }
        });
    }
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
}, "No special characters allowed");

$.validator.addMethod("regx1", function(value, element, regexpr) {          
    return regexpr.test(value);
}, "Numbers only");

	$(function(){
		$('#create-form').validate({
			rules:{
				room_no:{
					required: true,
					regx: /(^[a-zA-Z0-9]+$)/i,
					space: true,
				},
				capacity:{
					required: true,
					regx1: /(^[0-9]+$)/i,
					space: true,
				}
			}
		});
	});

	function clicks(id){
		$('#update-form'+id).validate({
			rules:{
				room_no:{
					required: true,
					regx: /(^[a-zA-Z0-9]+$)/i,
					space: true,
				},
				capacity:{
					required: true,
					regx1: /(^[0-9]+$)/i,
					space: true,
				}
			}
		});
	};
</script>

<script type="text/javascript">

		@foreach($room as $rooms)

			$('#update{{$rooms->id}}').on('hidden.bs.modal', function (e) {

	  		$('#update-form{{$rooms->id}}').trigger('reset');
  			$('#update-form{{$rooms->id}}').validate().resetForm();
	  		$('#update-form{{$rooms->id}}').find('.error').removeClass('error');
  		});
		@endforeach

		$('#responsive').on('hidden.bs.modal', function (e) {
    	$('#create-form').trigger('reset');
  		$('#create-form').validate().resetForm();
    	$('#create-form').find('.error').removeClass('error');
		});
</script>
@endsection