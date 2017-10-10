@extends('admin.layouts.default')
@section('css')
<link href="/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen" />
<link href="/vendors/panel/panel.css" rel="stylesheet" type="text/css"/>
<link href="/css/flat/blue.css" rel="stylesheet">
<link href="/css/all.css?v=1.0.2" rel="stylesheet">
<style type="text/css">
    
	.buttons{
		margin-top: 10px;
		margin-bottom: 20px;
	}

	.buttonss{
		margin-left: 5px;

	}
	.picker-switch{
	display: none !important;
	}
	.capitalize{
		text-transform: capitalize;
	}

<input type='text' id='date'>
</style>
@endsection
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
		<li class="active">Holiday</li>
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
						<button class="buttons btn btn-success" data-toggle="modal" data-href="#responsive" href="#responsive"><i class="glyphicon glyphicon-plus"></i>&ensp;New Holiday</button>
					</div>
					<div class="col-md-6 text-right">
						<a href="/maintenance/holiday/archive" class="buttons btn btn-success"><i class="glyphicon glyphicon-folder-open"></i>&ensp;Archive</a>
					</div>
					
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
								<td><button class="btn btn-primary" data-toggle="modal" data-href="#update{{$holidays->id}}" onclick="clicks({{$holidays->id}})" href="#update{{$holidays->id}}">Update</button>
									<button type="button" data-toggle="modal" data-href="#static{{$holidays->id}}" href="#static{{$holidays->id}}" class="btn btn-danger">Deactivate</button></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Create Modal -->
<div class="modal fade in" id="responsive" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<form id="create-form" action="/holiday/insert" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<div class="modal-header btn-primary">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">New Holiday</h4>
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
								<label class="control-label col-sm-3">Name<font color="red">*</font></label>
								<div class="col-sm-9">
									<div style="margin-left: -4%;" class="col-sm-12">
										<input type="text" name="holidayName" id="holidayName" class="form-control capitalize">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3 col-md-offset-3">
									<input id="dateRange" type="checkbox" name="dateRange">&ensp;Date Range
								</div>
							</div>
							<div id="dates">
								<div class="form-group">
									<label class="control-label col-sm-3">Date<font color="red">*</font></label>
									<div class="col-md-8">
										<div class="input-group date form_datetime col-sm-7" data-link-field="dtp_input1">
											<input class="form-control hasDatepicker" size="16" type="text" value="{{Carbon\Carbon::now()->format('F d,Y')}}" id="start" name="date" readonly>
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-th"></span>
											</span>
										</div>
									</div>
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

<!-- Update -->
@foreach($holiday as $holidays)
<div class="modal fade in" id="update{{$holidays->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<form id="update-form{{$holidays->id}}" action="/holiday/update" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<input type="hidden" name="id" value="{{$holidays->id}}">
				<div class="modal-header btn-primary">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Update Holiday</h4>
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
								<label class="control-label col-sm-3">Name<font color="red">*</font></label>
								<div class="col-sm-9">
									<div style="margin-left: -4%;" class="col-sm-12">
										<input type="text" value="{{$holidays->holidayName}}" name="holidayName" class="form-control capitalize">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3 col-md-offset-3">
									<input id="dateRange{{$holidays->id}}" type="checkbox" name="dateRange">&ensp;Date Range
								</div>
							</div>
							<div id="dates{{$holidays->id}}">
								@if($holidays->dateStart == $holidays->dateEnd)
								<div class="form-group">
									<label class="control-label col-sm-3">Date<font color="red">*</font></label>
									<div class="col-md-8">
										<div class="input-group date form_datetime col-sm-7" data-link-field="dtp_input1">
											<input class="form-control hasDatepicker" size="16" type="text" value="{{Carbon\Carbon::parse($holidays->dateStart)->format('F d,Y')}}" id="start" name="date" readonly>
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-th"></span>
											</span>
										</div>
									</div>
								</div>
								@else
								<div class="form-group">
									<label class="control-label col-sm-3">Start Date<font color="red">*</font></label>
									<div class="col-md-8">
										<div class="input-group date form_datetime col-sm-7" data-link-field="dtp_input1">
											<input class="form-control hasDatepicker" size="16" type="text" value="{{Carbon\Carbon::parse($holidays->dateStart)->format('F d,Y')}}" id="start{{$holidays->id}}" name="dateStart" readonly>
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-th"></span>
											</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3">End Date<font color="red">*</font></label>
									<div class="col-md-8">
										<div class="input-group date form_datetime col-sm-7" data-link-field="dtp_input1">
											<input class="form-control" size="16" type="text" value="{{Carbon\Carbon::parse($holidays->dateEnd)->format('F d,Y')}}" id="end{{$holidays->id}}" name="dateEnd" readonly>
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-th"></span>
											</span>
										</div>
									</div>
								</div>
								@endif
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
@foreach($holiday as $holidays)
<form action="/holiday/delete" method="post">
	{{csrf_field()}}
	<input type="hidden" name="id" value="{{$holidays->id}}">
	<div data-toggle="modal" class="modal fade in" id="static{{$holidays->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	    <div class="modal-dialog modal-md">
	        <div class="modal-content">
	        	<div class="modal-header btn-danger">
        			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        			<div class="modal-title">Deactivate</div>
        		</div>
            <div class="modal-body">
              <span>&ensp;&ensp;Are you sure sure you want to deactivate <b>{{$holidays->holidayName}}</b>?</span>
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
<script type="text/javascript" src="/vendors/datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script src="/js/icheck.js" type="text/javascript"></script>
<script src="/vendors/iCheck/icheck.js" type="text/javascript"></script>
<script type="text/javascript">
	$("#maintenance").last().addClass( "active" );
	$('#holiday').last().addClass(" active ");

	$(document).ready( function(){
		var table = $('#table1').DataTable({
			"order":[[1,"desc"]]
		});
	});

	$(document).ready(function(){
	  $('input').iCheck({
	    checkboxClass: 'icheckbox_flat-blue',
	    radioClass: 'iradio_flat-blue'
	  });
	});

	$('#dateRange').on('ifChecked',function(){
		$('#dates').empty();
		$('#dates').append('<div class="form-group"><label class="control-label col-sm-3">Start Date<font color="red">*</font></label><div class="col-md-8"><div class="input-group date form_datetime col-sm-7" data-link-field="dtp_input1"><input class="form-control hasDatepicker" size="16" type="text" value="{{Carbon\Carbon::now()->format("F d,Y")}}" id="start" name="dateStart" readonly><span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span></div></div></div><div class="form-group"><label class="control-label col-sm-3">End Date<font color="red">*</font></label><div class="col-md-8"><div class="input-group date form_datetime col-sm-7" data-link-field="dtp_input1"><input class="form-control" size="16" type="text" value="{{Carbon\Carbon::now()->format("F d,Y")}}" id="end" name="dateEnd" readonly><span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span></div></div></div>');

		$(".form_datetime").datetimepicker({
	        format: "MM dd, yyyy",
	        weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			minView: 2,
			maxView: 3,
			forceParse: 0,
			viewSelect:'month'
	    });
	})

	$('#dateRange').on('ifUnchecked',function(){
		$('#dates').empty();
		$('#dates').append('<div class="form-group"><label class="control-label col-sm-3">Date<font color="red">*</font></label><div class="col-md-8"><div class="input-group date form_datetime col-sm-7" data-link-field="dtp_input1"><input class="form-control hasDatepicker" size="16" type="text" value="{{Carbon\Carbon::now()->format('F d,Y')}}" id="start" name="date" readonly><span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span></div></div></div>');

		$(".form_datetime").datetimepicker({
	        format: "MM dd, yyyy",
	        weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			minView: 2,
			maxView: 3,
			forceParse: 0,
			viewSelect:'month'
	    });
	});


	@foreach($holiday as $holidays)
		@if($holidays->dateStart != $holidays->dateEnd)
			$('#dateRange{{$holidays->id}}').iCheck('check');
		@endif
		$('#dateRange{{$holidays->id}}').on('ifChecked',function(){
				$('#dates{{$holidays->id}}').empty();
				$('#dates{{$holidays->id}}').append('<div class="form-group"><label class="control-label col-sm-3">Start Date<font color="red">*</font></label><div class="col-md-8"><div class="input-group date form_datetime col-sm-7" data-link-field="dtp_input1"><input class="form-control hasDatepicker" size="16" type="text" value="{{Carbon\Carbon::parse($holidays->dateStart)->format("F d,Y")}}" id="start{{$holidays->id}}" name="dateStart" readonly><span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span></div></div></div><div class="form-group"><label class="control-label col-sm-3">End Date<font color="red">*</font></label><div class="col-md-8"><div class="input-group date form_datetime col-sm-7" data-link-field="dtp_input1"><input class="form-control" size="16" type="text" value="{{Carbon\Carbon::parse($holidays->dateEnd)->format("F d,Y")}}" id="end{{$holidays->id}}" name="dateEnd" readonly><span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span></div></div></div>');

				$(".form_datetime").datetimepicker({
			        format: "MM dd, yyyy",
			        weekStart: 1,
			        todayBtn:  1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 2,
					minView: 2,
					maxView: 3,
					forceParse: 0,
					viewSelect:'month'
			    });
			});
		$('#dateRange{{$holidays->id}}').on('ifUnchecked',function(){
		$('#dates{{$holidays->id}}').empty();
		$('#dates{{$holidays->id}}').append('<div class="form-group"><label class="control-label col-sm-3">Date<font color="red">*</font></label><div class="col-md-8"><div class="input-group date form_datetime col-sm-7" data-link-field="dtp_input1"><input class="form-control hasDatepicker" size="16" type="text" value="{{Carbon\Carbon::parse($holidays->dateStart)->format('F d,Y')}}" id="start{{$holidays->id}}" name="date" readonly><span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span></div></div></div>');

		$(".form_datetime").datetimepicker({
	        format: "MM dd, yyyy",
	        weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			minView: 2,
			maxView: 3,
			forceParse: 0,
			viewSelect:'month'
	    });
	});
	@endforeach
</script>
<script type="text/javascript">
	    $(".form_datetime").datetimepicker({
	        format: "MM dd, yyyy",
	        weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			minView: 2,
			maxView: 3,
			forceParse: 0,
			viewSelect:'month'
	    });
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
$.validator.addMethod("regx1", function(value, element, regexpr) {          
    return regexpr.test(value);
}, "No special characters except hypen( - ), period( . ), ampersand(&) and apostrophe( ' )");

$.validator.addMethod("valid1", function(value, element) { 
	var start = Date.parse($("#start").val());
	var end =Date.parse($("#end").val());
    return this.optional(element) || end>=start;
}, "End Date must be greater than or equal to Start Date");


	$(function(){
		$('#create-form').validate({
			rules:{
				holidayName:{
					required: true,
					regx1: /(^[a-zA-Z0-9 \'-.&]+$)/i,
					space: true,
					maxlength: 50
				},
				dateStart:{
					required:true,
					valid1:true
				},
				dateEnd:{
					required: true,
					valid1:true
				},
			},
			errorPlacement:function(error,element){
         		error.insertAfter(element.parent("div"));
			}
		});
	});
	function clicks(id){
		$.validator.addMethod("valid3", function(value, element) { 
			var start = Date.parse($("#start"+id).val());
			var end =Date.parse($("#end"+id).val());
			console.log(start + end);
			return this.optional(element) || end>=start;
		}, "End Date must be greater than Start Date");
		
		$('#update-form'+id).validate({
			rules:{
				holidayName:{
					required: true,
					regx1: /(^[a-zA-Z0-9 \'-.&]+$)/i,
					space: true,
					maxlength: 50
				},
				dateStart:{
					required:true,
					valid3:true
				},
				dateEnd:{
					required: true,
					valid3:true
				},
			},
			errorPlacement:function(error,element){
				error.insertAfter(element.parent("div"));
			}
		});
	}
</script>

<script type="text/javascript">

		@foreach($holiday as $holidays)
			// $('#update{{$holidays->id}}').on('hidden.bs.modal', function (e) {
   //  		$('#update-form{{$holidays->id}}').find('.error').removeClass('error');
   //  		$('#update-form{{$holidays->id}}').validate().resetForm();
   //  		$('.form-error').remove();
			// });

			$('#update{{$holidays->id}}').on('hidden.bs.modal', function (e) {

	  		$('#update-form{{$holidays->id}}').trigger('reset');
  			$('#update-form{{$holidays->id}}').validate().resetForm();
	  		$('#update-form{{$holidays->id}}').find('.error').removeClass('error');
  		});
		@endforeach

		$('#responsive').on('hidden.bs.modal', function (e) {
    	$('#create-form').trigger('reset');
  		$('#create-form').validate().resetForm();
    	$('#create-form').find('.error').removeClass('error');
		});

</script>

@endsection