<!DOCTYPE html>
<html>
<head>

	<title></title>
	<link rel="stylesheet" type="text/css" href="css/app.css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style type="text/css">
		body{
			background-color: white;
		}
	</style>
</head>
<body>
	<div class="col-md-6 col-md-offset-3" style="margin-top: 30px; margin-left: 30px;" >
		<img src="images/oceanlogo.png" style="float: left;" width="130" height="130px">	
		<div class="text-center" style=" margin-top: -15px;" >
			<h1>OCEAN LINK INSTITUTE INC.</h1>
			<h5>5th Floor Park View Plaza Bldg, Taft Ave. Manila City, Philippines</h5>
			<h5>Tel Nos.: +63 (02) 353-7738; +63 (02) 353-5841</h5>
			<h5>Fax No.: +63 (02) 353-7739</h5>
		</div>
	</div>
	<div class="col-md-6 col-md-offset-3 text-center" style="margin-top: 25px;">
		<h4 style="font-weight: bolder;">OFFICIAL RECEIPT</h4>
	</div>
	<div style="margin-top: 25px;">
		<div style="margin-left: 75%;">
			<label class="control-label col-md-3">Date :</label>
			<div  style="width: 60%; border-bottom: 1px solid black; margin-top: -27px; margin-left: 60px;">{{Carbon\Carbon::now()->format('m-d-Y')}}</div>
		</div>
		<div >
			<label class="control-label col-md-2">Received from</label>
			<div style="width: 79%; border-bottom: 0.5px solid black; margin-top: -29px; margin-left: 140px;">{{$payment->account->groupapplication->orgName}}</div>
			<div style="position: relative;"><label class="control-label col-md-2" > and address at</label></div>
			<div style="width: 79.25%; border-bottom: 0.5px solid black; position: relative; top: -29px; margin-left: 19%;">{{$payment->account->groupapplication->orgAddress}}</div>
			<div style="position: relative; top: -20px;"><label class="control-label col-md-2" >the sum of</label></div>
			<div style="width: 84.25%; border-bottom: 0.5px solid black; position: relative; top: -50px; margin-left: 14%;">{{strtoupper($money)}}</div>
			<div style="position: relative; top: -40px;"><label class="control-label col-md-2" >in partial/full payment of ENROLLMENT</label></div>
			<div style="position: relative; margin-left: 70%;"><h4>No. {{$payment->paymentNumber}}</h4></div>
		</div>
	</div>
</body>
</html>