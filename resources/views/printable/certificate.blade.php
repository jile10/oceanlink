<!DOCTYPE html>
<html>
	<head>
		<title>Oceanlink Institute Inc.</title>
	</head>
	@if(count($tclass->groupclassdetail)>0)
	@foreach($tclass->groupclassdetail as $details)
	<body style="border:2px solid black;">
		<div style="float:right; margin-right: 30px; margin-top: 30px;">
			<h5 style="padding: 0px; margin: 5px;">Cert. No. {{$details->certificate->certificate_no}}</h5>
			<h5 style="padding: 0px; margin: 5px;">Reg. No. REG-3349</h5>
		</div>
		<div style="clear: both;"></div>
		<div style="text-align: center; position: relative; top: 20px;">
			<h1>Certificate of Completion</h1>
			<h4 style="font-weight: normal;"><em>This certificate is issued to</em></h4>
			<h1 style="margin: 0px;"><em><u>{{$details->groupenrollee->firstName . ' ' . strtoupper($details->groupenrollee->middleName[0]).'. ' . $details->groupenrollee->lastName}}</u></em></h1>
			<h4 style="font-weight: normal; margin:10px;">Date of Birth: {{Carbon\Carbon::parse($details->groupenrollee->dob)->format('F d, Y')}}</h4>
			<h4 style="font-weight: normal;"><em>for having successfully completed the training course in</em></h4>
			<h1 style="margin: 50px 50px 10px 50px; "><em>{{$tclass->scheduledprogram->rate->program->programName}}</em></h1>
			<h3 style="margin-top: 0px; font-weight: normal;">{{'( ' . $tclass->scheduledprogram->rate->duration . ' Hours )'}}</h3>
			<p style="margin: 50px; 40px;"><em>Conducted from {{Carbon\Carbon::parse($tclass->scheduledprogram->dateStart)->format('F d, Y')}} to {{Carbon\Carbon::parse($dateEnd)->format('F d, Y')}} in compliance with DOTC Department Order 2001-49 and MARINA Memorandum Circular 171 on the Recurrency Training for all Officers, Rating, and other Personnel engaged in the Domestic trade.</em></p>
			<div>Issued this {{Carbon\Carbon::parse($details->certificate->date_issued)->format('d')}}<sup>th</sup> day of {{Carbon\Carbon::parse($details->certificate->date_issued)->format('F')}} {{Carbon\Carbon::parse($details->certificate->date_issued)->format('Y')}} in the City of Manila</div>
		</div>
		<div style="margin-top: 150px;">
			<div style="float:left; margin-right: 20px; width: 50%; text-align: center;">
				<h4 style="margin:10px;"><u>MARIA LOURDES C. CAUDAL</u></h4>
				<p style="margin: 10px;">Chief Operating Officer</p>
			</div>
			<div style="float:right; margin-left: 20px; width: 50%; text-align: center;">
				<h4 style="margin:10px;"><u>CAPT. ESMERALDO B. ARRIESGADO</u></h4>
				<p style="margin: 10px;">Chief Operating Officer</p>
			</div>
		</div>
	</body>
	@endforeach
	@endif
</html>