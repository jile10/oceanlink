@extends('admin.layouts.default')


@section('css')
<link href="/vendors/panel/panel.css" rel="stylesheet" type="text/css"/>
<link href="/css/all.css?v=1.0.2" rel="stylesheet">

    <link href="/css/fullcalendar.css" rel="stylesheet" type="text/css" />
    <link href="/css/calendar_custom.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    
	.panelLabel{
		font-size: 12px;
	}
	.digits{
		font-size: 40px;
		font-weight: bold;
	}
</style>
@endsection
@section('content')
<section class="content-header">
	<!--section starts-->
	<h1>Dashboard</h1>
	<ol class="breadcrumb">
		<li>
			<a href="{{url('/admin')}}">
				<i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
				Home
			</a> 
		</li>
		<li class="active">
			Dashboard
		</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">
			<!-- 	----------------------------------------SCHEDULE--------------------------------------- -->
			<div class="col-lg-8">
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="panel-title"><span class="glyphicon glyphicon-calendar"></span>&ensp; Calendar</div>
					</div>
					<div class="panel-body">
						<div class="col-md-8">
						<div class="box">
							<div class="box-title">
								<h3>Legends</h3>
							</div>
							<div class="box-body">
								<div >
									<div class='external-event palette-primary'>Days that have session</div>
									<div class='external-event palette-warning'>No session day</div>
									<div class='external-event palette-danger'>Holiday</div>
								</div>
							</div>
						</div>
						<!-- /.box --> 
					</div>
					<div class="col-md-12">
						<div class="box">
							<div class="box-body">
								<div id="calendar"></div>
							</div>
						</div>
						<!-- /.box --> 
					</div>
					</div>
				</div>
			</div>
			<!-- 	----------------------------------------PANELS--------------------------------------- -->
			<div class="col-lg-4">
				<div class="row">
					<div class="panel panel-blue">
						<div class="panel-body">
							<div class="col-lg-6">
								<center>
									<span class="digits">{{$enrolledStudents}}</span>
									<div class="row">
										<span class="pull left panelLabel">Currently Enrolled Students</span>
									</div>
								</center>
							</div>
							<div class="col-lg-6">
								<center>
									<i class="livicon" data-name="users" data-size="75" data-loop="true" data-c="#fff" data-hc="white"></i>
								</center>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="panel panel-orange">
						<div class="panel-body">
							<div class="col-lg-6">
								<center>
									<span class="digits">{{$ongoingCourses}}</span>
									<div class="row">
										<span class="pull left panelLabel">Ongoing Courses</span>
									</div>
								</center>
							</div>
							<div class="col-lg-6">
								<center>
									<i class="livicon" data-name="notebook" data-size="75" data-loop="true" data-c="#fff" data-hc="white"></i>
								</center>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="panel panel-red">
						<div class="panel-body">
							<div class="col-lg-6">
								<center>
									<span class="digits">{{$trainingOfficers}}</span>
									<div class="row">
										<span class="pull left panelLabel">Accounts that need notification</span>
									</div>
								</center>
							</div>
							<div class="col-lg-6">
								<center>
									<i class="livicon" data-name="user" data-size="75" data-loop="true" data-c="#fff" data-hc="white"></i>
								</center>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="panel panel-green">
						<div class="panel-body">
							<div class="col-lg-6">
								<center>
									<span class="digits">{{$enrolledStudents}}</span>
									<div class="row">
										<span class="pull left panelLabel">Ongoing Courses</span>
									</div>
								</center>
							</div>
							<div class="col-lg-6">
								<center>
									<i class="livicon" data-name="user" data-size="75" data-loop="true" data-c="#fff" data-hc="white"></i>
								</center>
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
<script src="/js/fullcalendar.min.js" type="text/javascript"></script>
<script src="/js/calendarcustom.min.js" type="text/javascript"></script>
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