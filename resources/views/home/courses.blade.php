@extends("home.layouts.master2")
@section("css")
    <link rel="stylesheet" type="text/css" href="/home/css/tabbular.css">
    <link rel="stylesheet" type="text/css" href="/home/css/jquery.circliful.css">
    <link rel="stylesheet" type="text/css" href="/home/vendors/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="/home/vendors/owl-carousel/owl.theme.css">
    <link href="{{ asset('/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section("content")
<div class="row" style="margin-top: 20px;">
	<!-- Left Heading Section Start -->
	<div class="text-center" >
        <h3 class="border-primary" ><span class="heading_border bg-primary" id="aboutus">Available Courses</span></h3>
    </div>
    <div class="col-md-12">
		<table class="table table-striped table-bordered" id="table1">
			<thead>
				<tr>
					<th width="25%">Program Name</th>
					<th width="10">Duration</th>
					<th width="20%">Training Officer</th>
					<th width="17%">Schedule</th>
					<th width="15%">Date Start</th>
					<th width="13%" class="text-right">Price (&#x20B1;)</th>
				</tr>
			</thead>
			<tbody>
				@foreach($sprogram as $sprograms)
				<tr>
					<td>{{$sprograms->rate->program->programName}}</td>
					<td>{{$sprograms->rate->duration. ' ' .$sprograms->rate->unit->unitName}}</td>
					<td>{{$sprograms->trainingofficer->firstName . ' ' . $sprograms->trainingofficer->middleName . ' ' . $sprograms->trainingofficer->lastName}}</td>
					<td>
					@foreach($sprograms->rate->schedule->detail as $schedules)
                        {{Carbon\Carbon::parse($schedules->day->dayName)->format('D'). ' ' .Carbon\Carbon::parse($schedules->start)->format('g:i A') . '-' . Carbon\Carbon::parse($schedules->end)->format('g:i A')}}
                    @endforeach
					</td>
					<td>{{Carbon\Carbon::parse($sprograms->dateStart)->format('F d, Y')}}</td>
					<td align="right">{{number_format($sprograms->rate->price,2)}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection
@section("js")
<script src="{{ asset('/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
	$("#table1").DataTable();
</script>
@endsection