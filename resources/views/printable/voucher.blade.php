<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	</head>
	<body>
		<div>
			<div style="width: 60%;position: relative; float: left;">
				<h2 style="margin-top: -5px; margin-bottom: padding: 0px;">OCEANLINK INSTITUTE INC.</h2>
				<h5 style="position: relative; margin-top: -2px;">5th Floor Park View Plaza Bldg. Taft Avenue, cor. T.M. Kalaw St.</h5>
			</div>
			<div style="width: 40%; position: relative; float: left; border: 1px solid black; height: 100px;">
				<h3 style="margin-top: 20px; margin-left: 10px;"> Total Amount: </h3>
				<h2 style="margin-left: 10px; position: absolute; right: 10px;">Php {{number_format($data['total'],2)}}</h2>
			</div>
		</div>
		<div style="position: relative; top: 10px; border-bottom: 2px solid black; clear: both;"></div>
		<div style="position: relative; clear: both;">
			<h4 style="font-weight: bold;  ">Name : {{$data['name']}}</h4>
			<h4 style="font-weight: bold; line-height: -1em;">Account No : {{$data['account_no']}}</h4>
			<h4 style="font-weight: bold; line-height: 2em;"> Training Programs : </h4>
			@foreach($data['sprogram'] as $sprogs)
				@if(($sprogs['id'] %2) == 1)
					<p style="margin-left: 10px; line-height: -1em;">{{$sprogs['sprogram_name']}}</p>
				@else
					<p style="margin-left: 10px; line-height: 2em;">{{$sprogs['sprogram_name']}}</p>
				@endif
			@endforeach
		</div>
		<div style="position: relative; border-bottom: 2px solid black;"></div>
		<div>
			<p>This is your copy. Keep it in a safe place. This document is valid until {{Carbon\Carbon::now()->addYears(5)->format('F d, Y')}}. </p>
			<p style="text-indent: 40px; text-align: justify;">I expressly agree to the Terms of Use, have read and understand the Private Policy, confirm that the information that I have provided to the Training School are true and correct to the best of my knowledge. My submission of this form will constitute my consent to the collection and use of my information and the transfer of information for processing and storage by the Oceanlink Institute, Inc. Furthermore, I agree and understand that I am legally responsible for the information I entered in the Oceanlink Kiosk and if I violate its Terms of Service my enrollment may be revoked or I will be subjected to Disciplinary Action.</p>
		</div>
		<div style="position: relative;">
			<h3 style="float: left; width: 35%;">TRAINEE SIGNATURE</h3>
			<div style="margin-top: -7px; width: 65%; float: left; height: 40px; border: 1px solid black;"></div>
		</div>
	</body>
</html>