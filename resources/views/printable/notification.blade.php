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
	<h1 style="text-align: center; margin-top: 120px;">Notice</h1>
	<h4>To : {{$account[0]['name']}}</h4>
	<h4 style="padding-top: -10px;">Address : {{$account[0]['address']}}</h4>
	<div style="margin-top: 30px;">
		<h4>Dear Sir/Madam</h4>
		<p style="text-indent: 40px; text-align: justify;">
			This is to inform you regarding your remaining balance towards <b>Oceanlink Institute</b> prior to the training course you attended. You are to clear the remaining balances, failing which, would cause the mentioned trainee's certification of completion would be put on hold. Your certificate will be given after you have cleared your remaining balance.
		</p>
		<div style="margin: 25px 0px;">
			<p style="text-indent: 100px; text-align: justify;">These is/are the balance(s) of training course(s) that you're enrolled in :
			</p>
			<ul style="margin-left: 75px;">
				@foreach($account[0]['courses'] as $courses)
				<li>{{$courses['course_name']}} - Php {{number_format($courses['balance'],2)}}</li>
				@endforeach
			</ul>
			<h4 style="margin-left: 100px;">Total : {{number_format($total,2)}}</h4>
		</div>
		<p style="text-indent: 40px; text-align: justify;">
			We hope you will clear your remaining balance at the earliest. Please contact <b>Oceanlink Institute</b> representative for clarification. Please ignore this letter in case you have already cleared these payments.
		</p>
	</div>
	<div style="margin-top: 50px;">
		<p>Regards,</p>
		<h4 style="padding-top: 30px;">Oceanlink Institute</h4>
	</div>
</body>
</html>