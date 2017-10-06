@extends('admin.layouts.default')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<!--section starts-->
	<h1>Group Collection</h1>
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
		<li class="active">Group Collection</li>
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
								<th width="15%">Account Number</th>
								<th width="30%">Organization Name</th>
								<th width="15%">&#8369; &ensp;&ensp;&ensp;&ensp;&ensp;Balance</th>
								<th width="30%">Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($gapp as $gapps)
							@if($gapps->account->balance > 0)
							<tr>
								<td>{{$gapps->account->accountNumber}}</td>
								<td>{{$gapps->orgName}}</td>
								<td align="right">{{number_format($gapps->account->balance,2)}}</td>
								<td>&ensp;<button class="btn btn-primary" data-toggle="modal" data-href="#incash{{$gapps->id}}" onclick="clicks({{$gapps->id}})" href="#incash{{$gapps->id}}"><i class="fa fa-money" aria-hidden="true"></i>&ensp;In Cash Payment</button>&ensp;<button class="btn btn-primary" data-toggle="modal" onclick="checkclicks({{$gapps->id}})" data-href="#check{{$gapps->id}}" href="#check{{$gapps->id}}"><i class="fa fa-money" aria-hidden="true"></i>&ensp;Check Payment</button></td>
							</tr>
							@endif
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<!--In Cash Modal-->
@foreach($gapp as $gapps)
<div class="modal fade in" id="incash{{$gapps->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<form id="collection-cash{{$gapps->id}}" action="/collection/group/incash/insert" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<input type="hidden" name="account_id" value="{{$gapps->account->id}}">
				<input type="hidden" name="groupapplication_id" value="{{$gapps->id}}">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">In Cash Payment</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<input type="hidden" name="paymentDate" value="{{Carbon\Carbon::today()->format('F d, Y')}}">
								<label class="col-md-12 control-label">{{Carbon\Carbon::today()->format('F d, Y')}}</label>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-5 control-label">Transaction Number&ensp;:</label>
								<div class="col-sm-5">
									<input type="hidden" name="paymentNumber" value="TN-{{Carbon\Carbon::today()->format('Y')}}-000{{count($payment)+1}}">
									<input disabled value="TN-{{Carbon\Carbon::today()->format('Y')}}-000{{count($payment)+1}}"  class="form-control">
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-5 control-label">Account Number&ensp;:</label>
								<div class="col-sm-5">						
									<input disabled value="{{$gapps->account->accountNumber}}" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-5 control-label">Balance&ensp;:</label>
								<div class="col-sm-5">				
									<input disabled value="&#8369; &ensp;&ensp;{{number_format($gapps->account->balance,2)}}" class="form-control text-right">
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-5 control-label">Mode of Payment&ensp;:</label>
								<div class="col-sm-5">
								@if($gapps->account->paymentMode == 2)
									<input disabled class="form-control" value="Full Payment">
								@else
									<input disabled class="form-control" value="Partial Payment">
								@endif
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-5 control-label">Amount to Pay&ensp;:</label>
								<div class="col-sm-5">
									@if($gapps->account->paymentMode == 2)			
									<input disabled value="&#8369; &ensp;&ensp;{{number_format($gapps->account->balance,2)}}" class="form-control text-right">
									<input type="hidden" id="pay{{$gapps->id}}" name="amountPay" value="{{$gapps->account->balance}}">
									@else
									<input disabled value="&#8369; &ensp;&ensp;{{number_format($gapps->account->balance/2,2)}}" class="form-control text-right">
									<input type="hidden" id="pay{{$gapps->id}}" name="amountPay" value="{{$gapps->account->balance/2}}">
									@endif
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-5 control-label">Payment in &#8369;&ensp;:</label>
								<div class="col-sm-5">				
									<input id="amount{{$gapps->id}}" name="amount" class="form-control text-right">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn">Close</button>
					<button type="submit" onclick="print()" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endforeach

<!--Check Modal-->
@foreach($gapp as $gapps)
<div class="modal fade in" id="check{{$gapps->id}}" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form id="collection-check{{$gapps->id}}" action="/collection/group/check/insert" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<input type="hidden" name="account_id" value="{{$gapps->account->id}}">
				<input type="hidden" name="groupapplication_id" value="{{$gapps->id}}">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Check Payment</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<input type="hidden" name="paymentDate" value="{{Carbon\Carbon::today()->format('F d, Y')}}">
								<label for="inputEmail3" class="col-md-12 control-label">{{Carbon\Carbon::today()->format('F d, Y')}}</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-5 control-label">Transaction Number&ensp;:</label>
								<div class="col-sm-5">
									<input type="hidden" name="paymentNumber" value="TN-{{Carbon\Carbon::today()->format('Y')}}-000{{count($payment)+1}}">
									<input disabled value="TN-{{Carbon\Carbon::today()->format('Y')}}-000{{count($payment)+1}}" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-7 control-label">Organization Account Number&ensp;:</label>
								<div class="col-sm-5">						
									<input disabled value="{{$gapps->account->accountNumber}}" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-5 control-label">Mode of Payment&ensp;:</label>
								<div class="col-sm-5">
								@if($gapps->account->paymentMode == 2)
									<input disabled class="form-control" value="Full Payment">
								@else
									<input disabled class="form-control" value="Partial Payment">
								@endif
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-7 control-label">Balance&ensp;:</label>
								<div class="col-sm-5">				
									<input disabled value="&#8369; &ensp;&ensp;{{number_format($gapps->account->balance,2)}}" class="form-control text-right">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-7 control-label">Amount to Pay&ensp;:</label>
								<div class="col-sm-5">
									@if($gapps->account->paymentMode == 2)			
									<input disabled value="&#8369; &ensp;&ensp;{{number_format($gapps->account->balance,2)}}" class="form-control text-right">
									<input id="checkpay{{$gapps->id}}" type="hidden" name="amountPay" value="{{$gapps->account->balance}}">
									@else
									<input disabled value="&#8369; &ensp;&ensp;{{number_format($gapps->account->balance/2,2)}}" class="form-control text-right">
									<input id="checkpay{{$gapps->id}}" type="hidden" name="amountPay" value="{{$gapps->account->balance/2}}">
									@endif
								</div>
							</div>
						</div>
						<div class="col-md-12 text-center">
							<div class="col-md-12">
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-4 control-label">Account Number&ensp;:</label>
									<div class="col-sm-5">				
										<input value="" name="accountNumber" class="form-control">
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-4 control-label">Account Name&ensp;:</label>
									<div class="col-sm-5">				
										<input value="" name="accountName" class="form-control">
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-4 control-label">Check Number&ensp;:</label>
									<div class="col-sm-5">				
										<input value="" name="checkNumber" class="form-control">
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-4 control-label">RT Number&ensp;:</label>
									<div class="col-sm-5">				
										<input value="" name="rtNumber" class="form-control">
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-4 control-label">Amount&ensp;:</label>
									<div class="col-sm-5">				
										<input required class="form-control text-right" type="text" id="checkamount{{$gapps->id}}" name="amount">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn">Close</button>
					<button type="submit" onclick="print()" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endforeach
@endsection
@section('js')
<script>
	$(document).ready( function(){
		var table = $('#table1').DataTable();
	});
	$("#transaction").last().addClass( "active" );
    $("#collection").last().addClass( "active" );
    $("#group_collection").last().addClass( "active" );
</script>
<script type="text/javascript">

$.validator.addMethod("regx2", function(value, element, regexpr) {          
    return regexpr.test(value);
}, "Invalid amount");

    function clicks(id){

        var pay = $('#pay'+id).val();
        console.log(pay);
        $.validator.addMethod("check", function(value, element,param) {          
            //return this.optional(element) || $('#amount'+id).val() > $('#pay'+id).val();
            if(parseInt($('#amount'+id).val()) >= parseInt($('#pay'+id).val()))
            {
                return true;
            }
        }, "Not enough gold");
        $('#collection-cash'+id).validate({
            rules:{
                amount:{
                    required: true,
                    regx2: /^(?:[0-9])*(?:|\.[0-9]+)$/i,
                    space: true,
                    maxlength: 12,
                    check: true,
                },
            }
        });
    };
    function checkclicks(id){

        var pay = $('#checkpay'+id).val();
        console.log(pay);
        $.validator.addMethod("check", function(value, element,param) {          
            //return this.optional(element) || $('#amount'+id).val() > $('#pay'+id).val();
            if(parseInt($('#checkamount'+id).val()) >= parseInt($('#checkpay'+id).val()))
            {
                return true;
            }
        }, "Not enough gold");
        $('#collection-check'+id).validate({
            rules:{
                amount:{
                    required: true,
                    regx2: /^(?:[0-9])*(?:|\.[0-9]+)$/i,
                    space: true,
                    maxlength: 12,
                    check: true,
                },
            }
        });
    };
</script>
<script type="text/javascript">
	function print(){
		var win = window.open('/receipt/print/group', '_blank');
		if (win) {
		    //Browser has allowed it to be opened
		    win.focus();
		} else {
		    //Browser has blocked it
		    alert('Please allow popups for this website');
		}
	}
</script>
@endsection
