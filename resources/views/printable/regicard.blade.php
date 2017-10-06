<!DOCTYPE html>
<html>
	<head>
		<title>Oceanlink Institute Inc.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	</head>
	<body >
		<div>
			<img style="margin-left: 20px; float: left;" src="images/oceanlogo.png" width="50px" height="50px">
			<h5 style="margin-left: 5px; line-height: 0.5em; float: left;">OCEANLINK INSTITUTE INC.</h5>
			<h5 style="float:left; line-height: 0.5em; margin-left: 30px;">CERTIFICATE OF REGISTRATION</h5>
		</div>
		<div style="clear: both;"></div>
		<div style="width: 25%;float: left; height: 40px; border-top: 1px solid black; border-left:1px solid black; border-bottom: 1px solid black;" >
			<h5 style="margin-left: 5px; line-height: -04em">Studen No: {{$data->studentNumber}}</h5>
		</div>
		<div style="width: 40%;float: left; height: 40px; border-top: 1px solid black; border-left:1px solid black; border-bottom: 1px solid black;" >
			<h5 style="margin-left: 5px; line-height: -04em">Name: {{$data->firstName . ' ' . $data->middleName . ' ' .$data->lastName}}</h5>
		</div>
		<div style="width: 15%;float: left; height: 40px; border-top: 1px solid black; border-left:1px solid black; border-bottom: 1px solid black;" >
			<h5 style="margin-left: 5px; line-height: -04em">Sex: @if($data->gender == "M")Male @else Female @endif</h5>
		</div>
		<div style="width: 20%;float: left; height: 40px; border: 1px solid black;" >
			<h5 style="margin-left: 5px; line-height: -04em">Date: 2017/06/12</h5>
		</div>
		<div style="clear: both;"></div>
		<div style="width: 50%;float: left; height: 40px; border-left: 1px solid black; border-bottom: 1px solid black;" >
			<p style="margin-left: 5px; line-height: -1em; font-size: 13px; font-weight: bold;">Address:</p>
			<p style="margin-left: 5px; line-height: 3em; font-size: 13px; font-weight: bold;">{{$data->street . ' ' . $data->barangay . ' ' . $data->city}}</p>
		</div>
		<div style="width: 15%;float: left; height: 40px; border-left: 1px solid black; border-bottom: 1px solid black;" >
			<p style="margin-left: 5px; line-height: -1em; font-size: 13px; font-weight: bold;">Contact:</p>
			<p style="margin-left: 5px; line-height: 3em; font-size: 13px; font-weight: bold;">{{$data->contact}}</p>
		</div>	
		<div style="width: 35%;float: left; height: 40px; border-left: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black;" >
			<p style="margin-left: 5px; line-height: -1em; font-size: 13px; font-weight: bold;">Email:</p>
			<p style="margin-left: 5px; line-height: 3em; font-size: 13px; font-weight: bold;">{{$data->email}}</p>
		</div>
		<div style="clear: both;"></div>
		<div style="width: 100.3%; border-bottom: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; height: 220px;">
			<div style="width: 100%; margin-left: 1%; margin-right: 1%;">
				<div style="width: 25%;float: left; border-bottom: 0.5px solid black; height: 40px;">
					<h5>Program Name</h5>
				</div>
				<div style="width: 15%;float: left; border-bottom: 0.5px solid black; height: 40px;">
					<h5 style=" text-align: center">Class Start</h5>
				</div>
				<div style="width: 15%;float: left; border-bottom: 0.5px solid black; height: 40px;">
					<h5 style=" text-align: center">Class End</h5>
				</div>
				<div style="width: 25%;float: left; border-bottom: 0.5px solid black; height: 40px;">
					<h5>Schedule</h5>
				</div>
				<div style="width: 20%;float: left; border-bottom: 0.5px solid black; height: 40px;">
					<h5>Training Room</h5>
				</div>
				<div style="clear: both;"></div>
				@foreach($course as $courses)
					@if($courses['id'] == 1)
						<div style="float: left; position: relative; top: -15px; width: 25%;">
							<h5>{{$courses['courseName']}}</h5>
						</div>
						<div style="float: left; position: relative; top: -15px; width: 15%; text-align: center;">
							<h5>{{$courses['dateStart']}}</h5>
						</div>
						<div style="float: left; position: relative; top: -15px; width: 15%; text-align: center;">
							<h5>{{$courses['dateEnd']}}</h5>
						</div>
						<div style="float: left; position: relative; top: -15px; width: 25%;">
							<h5>
								@if(count($courses['schedule'])>1)
									{{$courses['schedule']}}<br>
								@else
									{{$courses['schedule']}}
								@endif
							</h5>
						</div>
						<div style="float: left; position: relative; top: -15px; width: 20%;">
							<h5>{{$courses['trainingroom']}}</h5>
						</div>
					@else
						<div style="float: left; position: relative; top: -30px; width: 25%;">
							<h5>{{$courses['courseName']}}</h5>
						</div>
						<div style="float: left; position: relative; top: -30px; width: 15%; text-align: center;">
							<h5>{{$courses['dateStart']}}</h5>
						</div>
						<div style="float: left; position: relative; top: -30px; width: 15%; text-align: center;">
							<h5>{{$courses['dateEnd']}}</h5>
						</div>
						<div style="float: left; position: relative; top: -30px; width: 25%;">
							<h5>
								@if(count($courses['schedule'])>1)
									{{$courses['schedule']}}<br>
								@else
									{{$courses['schedule']}}
								@endif
							</h5>
						</div>
						<div style="float: left; position: relative; top: -30px; width: 20%;">
							<h5>{{$courses['trainingroom']}}</h5>
						</div>
					@endif
				@endforeach
			</div>
		</div>
	</body>
</html>