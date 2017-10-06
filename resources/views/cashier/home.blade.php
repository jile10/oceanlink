@extends('cashier.layouts.default')

@section('content')
<section class="content">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-success filterable" style="overflow:auto;">
				<div class="panel-heading">
					<h3 class="panel-title">
					</h3>
				</div>
				<div class="panel-body table-responsive">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="active">
                    <a href="#single" data-toggle="tab">Single</a>
                </li>
                <li>
                    <a href="#group" data-toggle="tab">Group</a>
                </li>
                <li class="pull-right">
                  <a href="/collection/paymenthistory" class="text-muted">
                      <i class="ion-clock" style="font-size:20px;"></i>&ensp;Payment History
                  </a>
                </li>
            </ul>
            <div style="margin-bottom: 25px;"></div>
            <div id="myTabContent" class="tab-content">
              <div class="tab-pane fade active in" id="single">
                <table class="table table-striped table-bordered" id="table1">
					<thead>
						<tr>
							<th width="15%">Account Number</th>
							<th width="30%">Applicants Name</th>
							<th width="15%">&#8369; &ensp;&ensp;&ensp;&ensp;&ensp;Balance</th>
							<th width="30%">Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($account as $accounts)
							@if(count($accounts->enrollee)>0)
								@if($accounts->accountdetail->sum('balance') > 0)
								<tr>
									<td>{{$accounts->accountNumber}}</td>
									<td>{{$accounts->enrollee->firstName . ' ' . $accounts->enrollee->middleName . ' ' .$accounts->enrollee->lastName}}</td>
									<td align="right">{{number_format($accounts->accountdetail->sum('balance'),2)}}</td>
									<td><form action="/cashier/view_accounts/next" method="get"><input type="hidden" name="account_id" value="{{$accounts->id}}"><button class="btn btn-primary"><i class="glyphicon glyphicon-hand-up"></i>&ensp;Select</button></form></td>
								</tr>
								@endif
							@endif
						@endforeach
					</tbody>
				</table>
              </div>
              <div class="tab-pane fade" id="group">
                <table class="table table-striped table-bordered" id="table2">
					<thead>
						<tr>
							<th width="15%">Account Number</th>
							<th width="30%">Applicants Name</th>
							<th width="15%">&#8369; &ensp;&ensp;&ensp;&ensp;&ensp;Balance</th>
							<th width="30%">Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($acount as $accounts)
							@if($accounts['balance'] > 0 && $accounts['check'] == true)
								<tr>
									<td>{{$accounts['account_no']}}</td>
									<td>{{$accounts['account_name']}}</td>
									<td align="right">{{number_format($accounts['balance'],2)}}</td>
									<td><form action="/cashier/view_accounts/next" method="get"><input type="hidden" name="account_id" value="{{$accounts['id']}}"><button class="btn btn-primary"><i class="glyphicon glyphicon-hand-up"></i>&ensp;Select</button></form></td>
								</tr>
							@endif
						@endforeach
					</tbody>
				</table>	                        
			</div>
		</div>
	</div>
</section>
@endsection
@section('js')
<script>
	$(document).ready( function(){
		var table1 = $('#table1').DataTable();
		var table2 = $('#table2').DataTable();
	});
    $("#cashierHome").last().addClass( "active" );

    jQuery(document).ready(function(){
    	console.log('{{count(session('receipt'))}}');
    	if({{count(session('receipt'))}}>0)
    	{
	    	var win = window.open('/receipt/print/single', '_blank');
			if (win) {
			    //Browser has allowed it to be opened
			    win.focus();
			} else {
			    //Browser has blocked it
			    alert('Please allow popups for this website');
			}
    	}
    });
</script>
@endsection