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
	<h2 style="text-align: center;">Enrollment Report</h2>
	<div style="width: 100%; border-bottom: 2px solid black;"></div>
	<table width="100%"  style="border: 1px solid black; border-collapse: collapse;">
		<thead >
			<tr>
				<th width="5%" style="border: 1px solid black; height: 30px; padding-left: 5px;"> No.</th>
				<th width="35%" style="border: 1px solid black; height: 30px; padding-left: 5px;"> Name</th>
				<th width="20%" style="border: 1px solid black; height: 30px; padding-left: 5px;"> Date of Birth</th>
				<th width="20%" style="border: 1px solid black; height: 30px; padding-left: 5px;"> Date of Enrolled</th>
				<th width="20%" style="border: 1px solid black; height: 30px; padding-left: 5px;"> Signature</th>
			</tr>
		</thead>
		<tbody>
			@if(count($tclass->classdetail)>0)
				@foreach($tclass->classdetail as $details)
					<tr style="border: 1px solid black;">
						<td style="border: 1px solid black; height: 25px;  padding-left: 5px;">{{++$x}}</td>
						<td style="border: 1px solid black; height: 25px;  padding-left: 5px;">{{$details->enrollee->firstName . ' ' . $details->enrollee->middleName . ' ' .$details->enrollee->lastName }}</td>
						<td style="border: 1px solid black; height: 25px; padding-left: 5px;">{{Carbon\Carbon::parse($details->enrollee->dob)->format('F d,Y')}}</td>
						<td style="border: 1px solid black; height: 25px;  padding-left: 5px;">{{Carbon\Carbon::parse($details->created_at)->format('F d,Y')}}</td>
						<td style="border: 1px solid black; height: 25px;  padding-left: 5px;"></td>
					</tr>
				@endforeach
			@else
			@foreach($tclass->groupclassdetail as $details)
					<tr style="border: 1px solid black;">
						<td style="border: 1px solid black; height: 25px;  padding-left: 5px;">{{++$x}}</td>
						<td style="border: 1px solid black; height: 25px;  padding-left: 5px;">{{$details->groupenrollee->firstName . ' ' . $details->groupenrollee->middleName . ' ' .$details->groupenrollee->lastName }}</td>
						<td style="border: 1px solid black; height: 25px; padding-left: 5px;">{{Carbon\Carbon::parse($details->groupenrollee->dob)->format('F d,Y')}}</td>
						<td style="border: 1px solid black; height: 25px;  padding-left: 5px;">{{Carbon\Carbon::parse($details->created_at)->format('F d,Y')}}</td>
						<td style="border: 1px solid black; height: 25px;  padding-left: 5px;"></td>
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
	<div style="width: 60%; float: right;">
		<h4 style="text-align: center;">Certified True and Correct:</h4>
		<div style="width: 50%; float: left">
				<h4 style="text-align: center;"><u>{{$cinfo->director}}</u></h4>
				<p style="text-align: center; padding-top: -20px;">Training Director</p>
		</div>
		<div style="width: 50%; float: right;">
				<h4 style="text-align: center;"><u>{{$cinfo->registrar}}</u></h4>
				<p style="text-align: center; padding-top: -20px;">Registrar</p>
		</div>
		<div style="clear: both;"></div>
	</div>
	<div style="clear: both;"></div>
</body>
</html>