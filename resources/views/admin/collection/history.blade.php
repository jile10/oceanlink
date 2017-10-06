@extends('admin.layouts.default')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<!--section starts-->
	<h1>Payment History</h1>
	<ol class="breadcrumb">
		<li>
			<a href="{{url('/admin')}}">
				<i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
				Home
			</a> 
		</li>
		<li>
			<a >Transaction</a>
		</li>
		<li>
			<a >Collections</a>
		</li>
		<li class="active">Payment History</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-success filterable" style="overflow:auto;">
				<div class="panel-heading">
					<h3 class="panel-title">
					</h3>
				</div>
				<div class="panel-body table-responsive">
					<table class="table table-striped table-bordered" id="table1">
						<thead>
							<tr>
								<th width="25%">Transaction Number</th>
								<th width="20%">Account Number</th>
								<th width="15%">&#8369; &ensp;&ensp;&ensp;&ensp;Amount</th>
								<th width="20%">Date</th>
							</tr>
						</thead>
						<tbody>
							@foreach($payment->reverse() as $payments)
							<tr>
								<td>{{$payments->paymentNumber}}</td>
								<td>{{$payments->account->accountNumber}}</td>
								<td class="text-right">{{number_format($payments->amount,2)}}</td>
								<td>{{Carbon\Carbon::parse($payments->created_at)->format('m-d-Y g:i:s A')}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('js')
<script type="text/javascript">
	$(document).ready( function(){
		var table = $('#table1').DataTable({
			"ordering": false,
		});

	});

    $("#transaction").last().addClass( "active" );
    $("#collection").last().addClass( "active" );
    $("#history").last().addClass( "active" );
</script>
@endsection