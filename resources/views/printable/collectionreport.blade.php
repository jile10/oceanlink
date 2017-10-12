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
	<h3 style="text-align: center; padding-top: -20px">(Year 2017)</h3>
	<div style="width: 100%; border-bottom: 2px solid black;"></div>
	<table width="100%"  style="border: 1px solid black; border-collapse: collapse;">
		<thead >
			<tr>
				<th width="20%" style="border: 1px solid black; height: 30px; padding-left: 5px;"> Account Number</th>
				<th width="40%" style="border: 1px solid black; height: 30px; padding-left: 5px;"> Account Name</th>
				<th width="20%" style="border: 1px solid black; height: 30px; padding-left: 5px;"> Payment Date</th>
				<th width="20%" style="border: 1px solid black; height: 30px; padding-left: 5px; text-align: right;"> Amount (Php)</th>
			</tr>
			@foreach($report as $reports)
			<tr style="border: 1px solid black;">
				<td style="border: 1px solid black; height: 25px;  padding-left: 5px;">{{$reports->account->accountNumber}}</td>
				<td style="border: 1px solid black; height: 25px;  padding-left: 5px;">{{$reports->account->accountNumber}}</td>
				<td style="border: 1px solid black; height: 25px;  padding-left: 5px;">{{$reports->paymentDate}}</td>
				<td style="border: 1px solid black; height: 25px;  padding-right: 5px; text-align: right;">{{number_format($reports->amount,2)}}</td>
			</tr>
			@endforeach
		</thead>
		<tbody>
		</tbody>
	</table>
</body>
</html>