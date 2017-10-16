<!DOCTYPE html>
<html>
<head>
	<title>Oceanlink</title>
	<style type="text/css">
		.header,
		.footer {
		    width: 100%;
		    position: fixed;
		}
		.header {
		    top: -50px;
		    left: -47px;
		}
		.footer {
		    bottom: 0px;
		}
	</style>
</head>
<body>
	<div class="header">
		<img src="images/header.jpg" width="820px;">
	</div>
	<div style="margin-top: 100px;">
		<h3 style="padding: none;">Course : {{$tclass->scheduledprogram->rate->program->programName . ' ('. $tclass->scheduledprogram->rate->duration .' Hours)'}}</h3>
		<h3 style="padding: -10px;">Class Name : {{$tclass->class_name}}</h3>
	</div>
	<h2 style="text-align: center;">Attendance Report</h2>
	<div style="width: 100%; border-bottom: 2px solid black;"></div>
	<table width="100%"  style="border: 1px solid black; border-collapse: collapse;">
		<thead >
			<tr>
				<th width="5%" style="border: 1px solid black; height: 30px; padding-left: 5px;"> No.</th>
				<th width="50%" style="border: 1px solid black; height: 30px; padding-left: 5px;"> Name</th>
				<th width="15%" style="border: 1px solid black; height: 30px; padding-left: 5px;"> Present <br> (Total)</th>
				<th width="15%" style="border: 1px solid black; height: 30px; padding-left: 5px;"> Absent <br> (Total)</th>
				<th width="15%" style="border: 1px solid black; height: 30px; padding-left: 5px;"> Late <br> (Total)</th>
			</tr>
		</thead>
		<tbody>
			@if(count($tclass->classdetail)>0)
				@foreach($tclass->classdetail as $details)
					<tr style="border: 1px solid black;">
						<td style="border: 1px solid black; height: 25px;  padding-left: 5px;">{{++$x}}</td>
						<td style="border: 1px solid black; height: 25px;  padding-left: 5px;">{{$details->enrollee->firstName . ' ' . $details->enrollee->middleName . ' ' .$details->enrollee->lastName }}</td>
						<td style="border: 1px solid black; height: 25px; padding-left: 5px;">{{count($details->attend->where('status','=',1))}}</td>
						<td style="border: 1px solid black; height: 25px; padding-left: 5px;">{{count($details->attend->where('status','=',2))}}</td>
						<td style="border: 1px solid black; height: 25px; padding-left: 5px;">{{count($details->attend->where('status','=',3))}}</td>
					</tr>
				@endforeach
			@else
			@foreach($tclass->groupclassdetail as $details)
					<tr style="border: 1px solid black;">
						<td style="border: 1px solid black; height: 25px;  padding-left: 5px;">{{++$x}}</td>
						<td style="border: 1px solid black; height: 25px;  padding-left: 5px;">{{$details->groupenrollee->studentNumber}}</td>
						<td style="border: 1px solid black; height: 25px;  padding-left: 5px;">{{$details->groupenrollee->firstName . ' ' . $details->groupenrollee->middleName . ' ' .$details->groupenrollee->lastName }}</td>
						<td style="border: 1px solid black; height: 25px; padding-left: 5px;">{{$details->groupgrade->grade}}</td>
						<td style="border: 1px solid black; height: 25px;  padding-left: 5px;">{{$details->groupgrade->remark}}</td>
					</tr>
				@endforeach
			@endif
		</tbody>
	</table>
	<div style="width: 40%; float: left;">
		<div style="text-align: center;">
			<h4 style="padding-bottom: 20px;">Prepared By:</h4>
			@if(count(Auth::user()->trainingofficer)>0)
			<h4><u>{{Auth::user()->trainingofficer->firstName . ' ' . Auth::user()->trainingofficer->middleName . ' ' . Auth::user()->trainingofficer->lastName}}</u></h4>
			<p style="padding-top: -20px;">Training Officer</p>
			@endif
		</div>
	</div>
	<div style="clear: both;"></div>
	<div style="position: absolute; bottom: -50px;">
		<h5>Date Printed : {{Carbon\Carbon::today()->format('F d, Y')}}</h5>
	</div>
</body>
</html>