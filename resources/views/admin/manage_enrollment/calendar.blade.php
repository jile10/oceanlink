@extends('admin.layouts.default')
@section("css")
    <link href="/css/fullcalendar.css" rel="stylesheet" type="text/css" />
    <link href="/css/calendar_custom.css" rel="stylesheet" type="text/css" />
  <link href="/css/all.css?v=1.0.2" rel="stylesheet">
  <link href="/css/flat/blue.css" rel="stylesheet">
    <link href="vendors/touchspin/dist/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css" media="all" />
@endsection
@section('content')
<section class="content-header">
	<h1>Oceanlink Calendar</h1>
	<ol class="breadcrumb">
		<li>
			<a href="/">
				<i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
				Home
			</a>
		</li>
		<li>Transaction</li>
		<li><a href="manage_enrollment">Manage Schedule</a></li>
		<li class="active">Calendar</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-md-4">
			<div class="box">
				<div class="box-title">
					<h3>Legends</h3>
				</div>
				<div class="box-body">
					<div >
						<div class='external-event palette-primary'>Available</div>
						<div class='external-event palette-warning'>Unknown</div>
						<div class='external-event palette-danger'>Close Enrollment</div>
					</div>
				</div>
			</div>
			<!-- /.box --> 
		</div>
        <div class="col-md-2">
            <button class="btn btn-lg btn-primary" data-toggle="modal" data-href="#responsive" href="#responsive"  style="margin-top: 30%;"><i class="glyphicon glyphicon-plus"></i>&ensp;New Schedule</button>
        </div>
		<div class="col-md-12">
			<div class="box">
				<div class="box-body">
					<div id="calendar"></div>
				</div>
			</div>
			<!-- /.box --> 
		</div>
		<!-- /.col --> 
	</div>
	<!-- Modal -->
</section>
<!--Create Modal-->
<div class="modal fade in" id="responsive" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="/manage_enrollment/insert" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<input type="hidden" name="calendar" value="1">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">New Schedule</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Course Name &ensp;*</label>
								<div class="col-sm-8">
									<select required name="rate_id" class="form-control">
									@foreach($rate as $rates)
										<option value="{{$rates->id}}">{{$rates->program->programName . ' ( ' . $rates->duration . ' Hours )'}}</option>
									@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Training Officer&ensp;*</label>
								<div class="col-sm-8">
									<select required name="officer_id" class="form-control">
									@foreach($officer as $officers)
										<option value="{{$officers->id}}">{{$officers->firstName . ' ' . $officers->middleName . ' ' . $officers->lastName}}</option>
									@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Date Start &ensp;*</label>
								<div class="col-sm-8">
									<input value="{{Carbon\Carbon::now()->format('Y-m-d')}}" required type="date" class="form-control" name="dateStart">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Building &ensp;*</label>
								<div class="col-sm-8">
									<select id="building" onchange="changes()" name="building_id" class="form-control">
										@foreach($building as $buildings)
											<option value="{{$buildings->id}}">{{$buildings->buildingName}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Floor &ensp;*</label>
								<div class="col-sm-8">
									<select id="floor" onchange="floorchange()" name="floor_id" class="form-control">
										@foreach($firsts as $firsts)
											<option>{{$firsts->floorName}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Room &ensp;*</label>
								<div class="col-sm-8">
									<select required id="rooms" name="room_id" class="form-control">
									@foreach($room as $rooms)
										<option value="{{$rooms->id}}">{{$rooms->room_no}}</option>
									@endforeach
									</select>
								</div>
							</div>
							<div class="text-center">
								<h2>Schedule</h2>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<div style="margin-left: 10%;">
										<input tabindex="13" type="checkbox" id="check">
		                  				<label for="flat-checkbox-1">Date Range</label>
									</div>
								</div>
								<div>
									<table class="table table-striped table-bordered" id="dynamic_table">
										<thead>
											<th width="30%">Day<font color="red">*</font></th>
											<th width="20%">Morning<font color="red">*</font></th>
											<th width="20%">Afternoon<font color="red">*</font></th>
											<th width="20%">Break Time</th>
											<th width="10%"></th>
										</thead>
										<tbody id="row">
											<tr >
												<td><select id="day1" onchange="days(1)" class="form-control" name="day[]">
												@foreach($day as $days)
													<option value="{{$days->id}}">{{$days->dayName}}</option>
												@endforeach</select>
												</td>
												<td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="morning[]" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($i<17) @if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option>@endif @endif @if($i==17 && $a==0)<option value="{{$i}}:00">{{$i}}:00</option>@endif @endfor @endfor</select></div></td>
												<td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="afternoon[]" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($i<17) @if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option>@endif @endif @if($i==17 && $a==0)<option value="{{$i}}:00">{{$i}}:00</option>@endif @endfor @endfor</select></div></td>
												<td><select name="breaktime[]" class="form-control" >@for($a=1;$a<5;$a++)<option value="{{$a*15}}">{{$a*15}}</option>@endfor</select></td>
												<td><button type="button" onclick="clicks()" class="btn btn-primary"><i class="glyphicon glyphicon-plus" ></i></button></td>
											</tr>
										</tbody>
									</table>
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
@endsection
@section("js")
	<script src="/js/fullcalendar.min.js" type="text/javascript"></script>
	<script src="/js/calendarcustom.min.js" type="text/javascript"></script>
	<script src="js/metisMenu.js" type="text/javascript"></script>
    <script src="js/icheck.js" type="text/javascript"></script>
	<script src="vendors/iCheck/icheck.js" type="text/javascript"></script>
  	<script src="/js/custom.js"></script>
    <script src="vendors/touchspin/dist/jquery.bootstrap-touchspin.js"></script>
<script>
	$(document).ready(function(){
	  $('input').iCheck({
	    checkboxClass: 'icheckbox_flat-blue',
	    radioClass: 'iradio_flat'
	  });
	});
	function days(id){
		console.log($("#day"+id).val());
	}
	$('input').on('ifChecked', function(event){
		$("#dynamic_table").empty();
	  	$("#dynamic_table").append('<thead><th width="20%">From<font color="red">*</font</th><th width="20%">To</th><th width="20%">Start<font color="red">*</font</th><th width="20%">End<font color="red">*</font</th><th width="20">Break Time</th></thead><tbody><tr><td><select class="form-control" name="start">@foreach($day as $days)<option value="{{$days->id}}">{{$days->dayName}}</option>@endforeach</select></td><td><select class="form-control" name="end">@foreach($day as $days)@if($days->dayName == "Tuesday") <option selected value="{{$days->id}}">{{$days->dayName}}</option> @else <option value="{{$days->id}}">{{$days->dayName}}</option> @endif @endforeach</select></td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="morning" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($i<17) @if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option>@endif @endif @if($i==17 && $a==0)<option value="{{$i}}:00">{{$i}}:00</option>@endif @endfor @endfor</select></div></td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="afternoon" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($i<17) @if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option>@endif @endif @if($i==17 && $a==0)<option value="{{$i}}:00">{{$i}}:00</option>@endif @endfor @endfor</select></div></td><td><select name="breaktime" class="form-control" >@for($a=1;$a<5;$a++)<option value="{{$a*15}}">{{$a*15}}</option>@endfor</select></td></tr></tbody>');
	  	$("input[name='demo_vertical']").TouchSpin({
	  		initval: 00,
	  		min: 0,
            max: 59,
            step: 15,
	      verticalbuttons: true,
	    });
	});
	$('input').on('ifUnchecked', function(event){
		$("#dynamic_table").empty();
		$("#dynamic_table").append('<thead><th width="30%">Day<font color="red">*</font</th><th width="20%">Morning<font color="red">*</font</th><th width="20%">Afternoon<font color="red">*</font</th></th><th width="20">Break Time</th><th width="10%"></thead><tbody id="row"><tr><td><select class="form-control" name="day[]">@foreach($day as $days)<option value="{{$days->id}}">{{$days->dayName}}</option>@endforeach</td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="morning[]" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option> @endif @endfor @endfor</select></div></td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="afternoon[]" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($i<17) @if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option>@endif @endif @if($i==17 && $a==0)<option value="{{$i}}:00">{{$i}}:00</option>@endif @endfor @endfor</select></div></td><td><select name="breaktime[]" class="form-control" >@for($a=1;$a<5;$a++)<option value="{{$a*15}}">{{$a*15}}</option>@endfor</select></td><td><button type="button" onclick="clicks()" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i></button></td></tr></tbody>');
	});
	var i=1;
	function clicks(){
		$("#row").append('<tr id="row'+i+'"><td><select class="form-control" name="day[]">@foreach($day as $days)<option value="{{$days->id}}">{{$days->dayName}}</option>@endforeach</td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="morning[]" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option> @endif @endfor @endfor</select></div></td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="afternoon[]" class="form-control" >@for($i=8;$i<18;$i++)@for($a=0;$a<4;$a++)@if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option>@endif @endfor @endfor</select></div></td><td><input type="text" class="form-control" name="breaktime[]"/></td><td><button type="button" onclick="removes('+i+')" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></button></td></tr>');
	}
	function removes(id){
		$("#row"+id).remove();
		i--;
	}
</script>
<script>
	$(document).ready( function(){
		var table = $('#table1').DataTable();
	});
	$("#transaction").last().addClass( "active" );
	$("#manage_enrollment").last().addClass( "active" );
	function changes(){
		var building_id = $('#building').val();
		var floor_id = 0;
		$.ajax({
			type:'get',
			url:'{!!URL::to('ajax-floor')!!}',
			data:{'id':building_id},
			success:function(data){
				$('#floor').empty();
				floor_id = data[0].id;
				for(var i=0;i<data.length;i++){
					$('#floor').append('<option value="'+data[i].id+'">'+data[i].floorName+'</option>');
				}

				$.ajax({
					type:'get',
					url:'{!!URL::to('ajax-floor-and-room')!!}',
					data:{'building_id':building_id,'floor_id':floor_id},
					success:function(data){
						$('#rooms').empty();
						for(var i=0;i<data.length;i++){
							$('#rooms').append('<option value="'+data[i].id+'">'+data[i].room_no+'</option>');

						}
					},
				});
			},
		});
	}
	function floorchange(){
		var floor_id = $("#floor").val();
		$.ajax({
			type:'get',
			url:'{!!URL::to('ajax-room')!!}',
			data:{'floor_id':floor_id},
			success:function(data){
				console.log('success');
				$('#rooms').empty();
						console.log(data.length);
				for(var i=0;i<data.length;i++){
					$('#rooms').append('<option value="'+data[i].id+'">'+data[i].room_no+'</option>');
				}
			},
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
	<script>
		$(document).ready(function() {
     /* initialize the external events
                 -----------------------------------------------------------------*/
        function ini_events(ele) {
            ele.each(function() {

                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim($(this).text()) // use the element's text as the event title
                };

                // store the Event Object in the DOM element so we can get to it later
                $(this).data('eventObject', eventObject);

                // make the event draggable using jQuery UI

            });
        }
        ini_events($('#external-events div.external-event'));

        /* initialize the calendar
                 -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date();
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear();
        $('#calendar').fullCalendar({
			
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month'
            },
            buttonText: {
                prev: "<span class='fa fa-caret-left'></span>",
                next: "<span class='fa fa-caret-right'></span>",
                today: 'today',
                month: 'month',
                week: 'week',
                day: 'day'
            },
            //Random events
			
            events: [
				@foreach($tclass as $tclasses)
				{
				id: "{{$tclasses['course_name']}}",
                title: "{{$tclasses['course_name']}}",
                start: '{{Carbon\Carbon::parse($tclasses['dateStart'])->format('Y-m-d')}}',
                backgroundColor: "#F89A14"
            	}, 
				@endforeach
				@foreach($holiday as $holidays){
					id: "{{$holidays->id}}",
					title: '{{$holidays->holidayName}}',
					start: "{{Carbon\Carbon::parse($holidays->dateStart)->format('Y-m-d')}}",
					end: "{{Carbon\Carbon::parse($holidays->dateEnd)->format('Y-m-d')}}"
				},
				@endforeach
				
			],
			eventClick: function(event, jsEvent, view){
				console.log(event.start);
			},
            drop: function(date, allDay) { // this function is called when something is dropped

                // retrieve the dropped element's stored Event Object
                var originalEventObject = $(this).data('eventObject');

                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);

                // assign it the date that was reported
                copiedEventObject.start = date;
                copiedEventObject.allDay = allDay;
                copiedEventObject.backgroundColor = $(this).css("background-color");
                copiedEventObject.borderColor = $(this).css("border-color");

                // render the event on the calendar
                // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

            }
        });

        /* ADDING EVENTS */
        var currColor = "#418BCA"; //default
        //Color chooser button
    });
	</script>
@endsection
