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
	<h1 style="text-align: center; margin-top: 120px;">Collection Report</h1>
	<h3 style="text-align: center; padding-top: -20px">{{$timePeriod}}</h3>
	<div style="width: 100%; border-bottom: 2px solid black;"></div>
	<table width="100%"  style="border: 1px solid black; border-collapse: collapse;">
		<thead >
			<tr>
				<th width="25%" style="border: 1px solid black; height: 30px; padding-left: 5px;"> Account Number</th>
				<th width="50%" style="border: 1px solid black; height: 30px; padding-left: 5px;"> Account Name</th>
				<th width="25%" style="border: 1px solid black; height: 30px; padding-right: 5px; text-align: right;"> Amount (Php)</th>
			</tr>
		</thead>
		<tbody>
			@foreach($account as $accounts)
			<tr style="border: 1px solid black;">
				<td style="border: 1px solid black; height: 25px;  padding-left: 5px;">{{$accounts['accountNumber']}}</td>
				<td style="border: 1px solid black; height: 25px;  padding-left: 5px;">{{$accounts['accountName']}}</td>
				<td style="border: 1px solid black; height: 25px;  padding-right: 5px; text-align: right;">{{$accounts['balance']}}</td>
			</tr>
			@endforeach
			<tr>
				<td colspan="4" style="border: 1px solid black; height: 25px;  padding-right: 5px; text-align: right; border-top: 2px solid black;">Total : Php {{number_format($total,2)}}</td>
			</tr>
		</tbody>
		<div style="width: 35%; text-align: center;">
			<h4>Prepared By:</h4>
			<h4 style="padding-top: 10px;"><u>{{Auth::user()->employee->firstName . ' ' . Auth::user()->employee->middleName . ' ' . Auth::user()->employee->lastName}}</u></h4>
			<p style="padding-top: -20px;">{{Auth::user()->position->positionName}}</p>
		</div>
	</table>
</body>
</html>