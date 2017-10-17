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
				<th width="20%" style="border: 1px solid black; height: 30px; padding-left: 5px;"> Account Number</th>
				<th width="40%" style="border: 1px solid black; height: 30px; padding-left: 5px;"> Account Name</th>
				<th width="20%" style="border: 1px solid black; height: 30px; padding-left: 5px;"> Payment Date</th>
				<th width="20%" style="border: 1px solid black; height: 30px; padding-right: 5px; text-align: right;"> Amount (Php)</th>
			</tr>
		</thead>
		<tbody>
			@foreach($report as $reports)
			<tr style="border: 1px solid black;">
				<td style="border: 1px solid black; height: 25px;  padding-left: 5px;">{{$reports->account->accountNumber}}</td>
        		@if(count($reports->account->enrollee)>0)
				<td style="border: 1px solid black; height: 25px;  padding-left: 5px;">{{$reports->account->enrollee->firstName .' '. $reports->account->enrollee->middleName . ' ' . $reports->account->enrollee->lastName}}</td>
				@else
				<td style="border: 1px solid black; height: 25px;  padding-left: 5px;">{{$reports->account->groupapplication->orgName}}</td>
				@endif
				<td style="border: 1px solid black; height: 25px;  padding-left: 5px;">{{$reports->paymentDate}}</td>
				<td style="border: 1px solid black; height: 25px;  padding-right: 5px; text-align: right;">{{number_format($reports->amount,2)}}</td>
			</tr>
			@endforeach
			<tr>
				<td colspan="4" style="border: 1px solid black; height: 25px;  padding-right: 5px; text-align: right; border-top: 2px solid black;">Total : Php {{number_format($reports->sum('amount'),2)}}</td>
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