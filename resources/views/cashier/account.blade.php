@extends('cashier.layouts.default')
@section("css")

    <link href="/css/all.css?v=1.0.2" rel="stylesheet">
    <link href="/css/flat/blue.css" rel="stylesheet">
    <link href="/css/table.css" rel="stylesheet">
    <link href="/vendors/touchspin/dist/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css" media="all" />
    <style type="text/css">
    	.colorCell{
    		color: #E0E0E0;
    	}
    	.modalNext{
				opacity: 0.9;
				filter: alpha(opacity=90);
        	}
    </style>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<!--section starts-->
	<h1>Detailed Account</h1>
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
		<li class="active">Account</li>
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
				<div class="panel-body">
					<table class="">
						<thead>
							<tr>
								<th width="5%" style="text-align: center;"><input type="checkbox" id="checkAll" name=""></th>
								<th width="30%">Course</th>
								<th width="15%">Payment Mode</th>
								<th width="15%">Status</th>
								<th width="20%" style="text-align: center;"><input type="checkbox" id="overrideAll" name="">&ensp;Override Payment Mode</th>
								<th width="10%" style="text-align: right">Fee (Php)</th>
							</tr>
						</thead>
						<tbody>
							@foreach($account->accountdetail as $accounts)
								@if($accounts->status != 3)
									@if($accounts->balance >0 && count($accounts->account->groupapplication)==0)
										<tr>
											<td style="text-align: center;"><input id="{{$accounts->id}}" type="checkbox" name="check"></td>								<td>{{$accounts->scheduledprogram->rate->program->programName . ' (' . $accounts->scheduledprogram->rate->duration .' Hours)'}}</td>
											<td>@if($accounts->paymentMode == 1)Partial Payment @else Full Payment @endif</td>
											<td>@if($accounts->status != 3 && $accounts->status !=2)Not yet Paid @elseif($accounts->status == 2)Partially Paid @endif</td>
											<td style="text-align: center;" id="cell{{$accounts->id}}">@if($accounts->paymentMode == 1) <input type="checkbox" name="" id="overridePaymentMode{{$accounts->id}}">&ensp;Full Payment @endif</td>
											<td style="text-align: right">{{number_format($accounts->balance,2)}}</td>
										</tr>
									@else
										@if($accounts->scheduledprogram->trainingclass->groupapplicationdetail->application_status == 2)
										<tr>
											<td style="text-align: center;"><input id="{{$accounts->id}}" type="checkbox" name="check"></td>								<td>{{$accounts->scheduledprogram->rate->program->programName . ' (' . $accounts->scheduledprogram->rate->duration .' Hours)'}}</td>
											<td>@if($accounts->paymentMode == 1)Partial Payment @else Full Payment @endif</td>
											<td>@if($accounts->status != 3 && $accounts->status !=2)Not yet Paid @elseif($accounts->status == 2)Partially Paid @endif</td>
											<td style="text-align: center;" id="cell{{$accounts->id}}">@if($accounts->paymentMode == 1) <input type="checkbox" name="" id="overridePaymentMode{{$accounts->id}}">&ensp;Full Payment @endif</td>
											<td style="text-align: right">{{number_format($accounts->balance,2)}}</td>
										</tr>
										@endif
									@endif
								@endif
							@endforeach
						</tbody>
					</table>

					<div class="form-horizontal">
						<div class="col-md-12">
							<div style="margin-right: 10px;" class="form-group pull-right">
								<label class="control-label col-md-6">Total: &ensp;</label>
								<label class="control-label col-md-3" id="total">0</label>
							</div>
						</div>
						<div class="form-group col-md-12">
							<div class="col-md-4"><button class="btn btn-primary" data-toggle="modal" onclick="makePayment()">Make Payment</button></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Make Payment -->
<form id="collection-form" action="/cashier/insert" method="post" class="form-horizontal">
	<div class="modal fade in" id="makepayment" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
		<div class="modal-dialog modal-lg ">
			<div class="modal-content" id="makepaymentContent">
				{{ csrf_field() }}
				<input type="hidden" name="account_id" value="{{$account->id}}">
				@if(count($account->enrollee)>0)
					<input type="hidden" name="enrollee_id" value="{{$account->enrollee->id}}">
				@elseif(count($account->groupapplication))
					<input type="hidden" name="groupapplication_id" value="{{$account->groupapplication->id}}">
				@endif
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Make Payment</h4>
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
								<label for="inputEmail3" class="col-sm-3 control-label">Transaction Number&ensp;:</label>
								<div class="col-sm-5">
									<input type="hidden" name="paymentNumber" value="TN-{{Carbon\Carbon::today()->format('Y')}}-000{{count($payment)+1}}">
									<input disabled value="TN-{{Carbon\Carbon::today()->format('Y')}}-000{{count($payment)+1}}" name="paymentNumber" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Account Number&ensp;:</label>
								<div class="col-sm-5">						
									<input disabled value="{{$account->accountNumber}}" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Total Selected Fee&ensp;:</label>
								<div class="col-sm-5" id="totalfee">						
									<input id="fee" disabled value="" class="form-control text-right">
								</div>
							</div>
						</div>
						<div id="dynamic_program">
							
						</div>
						<div id="dynamic_scheduledprogram">
							
						</div>
						<div class="col-md-12" id="divs">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Payment in &#8369;&ensp;:</label>
								<div class="col-sm-5" id="inputs">
									<input required onkeyup="amountChange()" class="form-control text-right" type="text" id="amounts" name="amount">
								</div>
							</div>
						</div>
						<div id="dynamic_course">
							
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="buttonSubmit()" id="submit" name="change" value="yes" class="btn btn-primary">Submit</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade in" id="change" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header btn-info">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Confirmation</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<h5>Do you want to keep the change? </h5>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-danger" name="change" value="no">NO</button>
					<button type="submit" class="btn btn-primary" name="change" value="yes">YES</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade in" id="maybe" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header btn-info">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Confirmation</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<h5>Do you want to pay the total selected fee?</h5>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-danger" name="change" value="yes">NO</button>
					<button type="submit" class="btn btn-primary" name="change" value="maybe">YES</button>
				</div>
			</div>
		</div>
	</div>
</form>
@endsection
@section('js')
<script src="/js/icheck.js" type="text/javascript"></script>
<script src="/vendors/iCheck/icheck.js" type="text/javascript"></script>
<script>
    $("#transaction").last().addClass( "active" );
    $("#collection").last().addClass( "active" );
    $("#individual_collection").last().addClass( "active" );
</script>
<script type="text/javascript">
function buttonSubmit(){
	if(parseFloat($('#amounts').val())>parseFloat($('#amountToPay').val()) && parseFloat($('#amounts').val()) < parseFloat($('#feeTotal').val()))
	{
		$('#submit').attr('type','button');
		$('#submit').attr('data-toggle',"modal");
		$('#divs').removeClass("has-error");
		$('#change').modal().show();
	}
	else if(parseFloat($('#amounts').val()) >= parseFloat($('#feeTotal').val()) && parseFloat($('#amounts').val()) != parseFloat($('#amountToPay').val()) && parseFloat($('#feeTotal').val()) != parseFloat($('#amountToPay').val()))
	{
		$('#submit').attr('type','button');
		$('#submit').attr('data-toggle',"modal");
		$('#divs').removeClass("has-error");
		$('#maybe').modal().show();
	}
	else if((parseFloat($('#amounts').val()) >= parseFloat($('#amountToPay').val()) && parseFloat($('#feeTotal').val()) == parseFloat($('#amountToPay').val())) ||(parseFloat($('#amounts').val()) == parseFloat($('#amountToPay').val())))
	{
		$('#submit').attr('type','submit');
		$('#collection-form').submit();
	}
	else{
		$('#divs').addClass("has-error");
		if($('#amounts').val() == "")
			toastr.error('Amount field is required');
		else
			toastr.error('Amount must be greater than amount to pay');
	}
}

function amountChange(){
	if(parseFloat($('#amounts').val())>=parseFloat($('#amountToPay').val()))
	{
		$('#divs').removeClass("has-error");
	}
}

$.validator.addMethod("check", function(value, element,param) {          
    //return this.optional(element) || $('#amount'+id).val() > $('#pay'+id).val();
    if(parseInt($('#amounts').val()) >= parseInt($('#amountToPay').val()))
    {
        return true;
    }
}, "Not enough gold");

$.validator.addMethod("regx2", function(value, element, regexpr) {          
    return regexpr.test(value);
}, "Invalid amount");

	var total=0;
	var totalfee=0;
  	$(document).ready(function(){
	  $('input').iCheck({
	    checkboxClass: 'icheckbox_flat-blue',
	    radioClass: 'iradio_flat-blue'
	  })
	  $('#overrideAll').iCheck('disable');
	  $('#overrideAll').iCheck('uncheck');
	  $('#checkAll').iCheck('uncheck');
	  total =0;
	  totalfee=0;
	  $('#total').text(total);
	  @foreach($account->accountdetail as $accounts)
	  $('#overridePaymentMode{{$accounts->id}}').iCheck('disable');
	  $('#overridePaymentMode{{$accounts->id}}').iCheck('uncheck');
	  $('#{{$accounts->id}}').iCheck('uncheck');
	  $('#cell{{$accounts->id}}').addClass(" colorCell ");
	  @endforeach
	});

    $('#checkAll').on('ifChecked', function(event){
    	@foreach($account->accountdetail as $accounts)
	    		$('#{{$accounts->id}}').iCheck('check');
    	@endforeach
	  	$('#overrideAll').iCheck('enable');
    });
    $('#checkAll').on('ifUnchecked', function(event){
    	@foreach($account->accountdetail as $accounts)
    		$('#{{$accounts->id}}').iCheck('uncheck');
    	@endforeach
		$('#total').text(total);
	  	$('#overrideAll').iCheck('disable');
    });
    $('#overrideAll').on('ifChecked', function(event){
    	@foreach($account->accountdetail as $accounts)
    		if({{$accounts->paymentMode}} !=2){
    				$('#overridePaymentMode{{$accounts->id}}').iCheck('check');
    		}
    	@endforeach
    });
    $('#overrideAll').on('ifUnchecked', function(event){
    	@foreach($account->accountdetail as $accounts)
    		$('#overridePaymentMode{{$accounts->id}}').iCheck('uncheck');
    	@endforeach
		$('#total').text(total);
    });
    @foreach($account->accountdetail as $accounts)
    	$('#{{$accounts->id}}').on('ifChecked',function(event) {
	    	totalfee +={{$accounts->balance}};
    		if({{$accounts->paymentMode}}==1){	
	    		total+=	{{$accounts->balance}}/2;
	    		$('#total').text(total);
				$('#overridePaymentMode{{$accounts->id}}').iCheck('enable');
				$('#cell{{$accounts->id}}').removeClass(" colorCell ");
    		}
    		else if({{$accounts->paymentMode}} == 2 && {{$accounts->status}} == 2){
	    		total+=	{{$accounts->balance}};
	    		$('#total').text(total);
    		}
    		else{
	    		total+=	{{$accounts->balance}};
	    		$('#total').text(total);
    		}
    		$('#dynamic_scheduledprogram').append('<div id="row_sprog{{$accounts->id}}"><input type="hidden" name="scheduledprogram_id[]" value="{{$accounts->scheduledprogram_id}}"/><input type="hidden" name="accountdetail_id[]" value="{{$accounts->id}}"/><input type="hidden" id="paymentModeOverride{{$accounts->id}}" name="paymentMode[]" value="{{$accounts->paymentMode}}"/></div>')
    	});
    	$('#overridePaymentMode{{$accounts->id}}').on('ifChecked',function(event) {
    		if({{$accounts->paymentMode}}==1){	
	    		total-=	{{$accounts->balance}}/2;
	    		total+=	{{$accounts->balance}};
	    		$('#paymentModeOverride{{$accounts->id}}').val('2');
	    		$('#total').text(total);
    		}
    	});
    	$('#overridePaymentMode{{$accounts->id}}').on('ifUnchecked',function(event) {
    		if({{$accounts->paymentMode}}==1){	
	    		total-=	{{$accounts->balance}};
	    		total+=	{{$accounts->balance}}/2;
	    		$('#paymentModeOverride{{$accounts->id}}').val('1');
	    		$('#total').text(total);
    		}
    	});
    	$('#{{$accounts->id}}').on('ifUnchecked',function(event) {
    		totalfee-={{$accounts->balance}};
    		if({{$accounts->paymentMode}}==1){	
	    		total-=	{{$accounts->balance}}/2;
	    		$('#total').text(total);
				$('#overridePaymentMode{{$accounts->id}}').iCheck('uncheck');
				$('#overridePaymentMode{{$accounts->id}}').iCheck('disable');
				$('#cell{{$accounts->id}}').addClass(" colorCell ");
    		}
    		else if({{$accounts->paymentMode}} == 2 && {{$accounts->status}} == 2){
	    		total-=	{{$accounts->balance}};
	    		$('#total').text(total);
    		}
    		else{
	    		total-=	{{$accounts->balance}};
	    		$('#total').text(total);
    		}
    		$('#row_sprog{{$accounts->id}}').remove();
    	});
    @endforeach
    function makePayment(){
    	$('#row').remove();
		$("#dynamic_program").append('<div class="col-md-12" id="row"><div class="form-group"><label for="inputEmail3" class="col-sm-3 control-label">Amount to Pay&ensp;:</label><div class="col-sm-5"><input  disabled  value="'+total+'" class="form-control text-right"><input type="hidden" id="amountToPay" name="amountPay" value="'+total+'"></div></div></div>');
		$('#fee').val(""+totalfee+"");
		$('#totalfee').append('<input type="hidden" id="feeTotal" name="totalFee" value="'+totalfee+'" />');
        $('#collection-form').validate({
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
    	if(total>0){
    		$('#makepayment').modal('show');
    	}
    }
    $('#makepayment').on('hidden.bs.modal',function(){
    	$('#row').remove();
    });

    $('#change').on('show.bs.modal',function(){
		$('#makepaymentContent').addClass(" modalNext");
		$('#change').css('margin-top','40px')
    });
    $('#change').on('hidden.bs.modal',function(){
		$('#makepaymentContent').removeClass(" modalNext");
    });

</script>
@endsection
