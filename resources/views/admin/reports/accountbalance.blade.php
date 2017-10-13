@extends('admin.layouts.default')
@section('css')
<link href="/vendors/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" />
<link href="/css/table.css" rel="stylesheet" />
@endsection
@section('content')
<section class="content-header">
	<!--section starts-->
	<h1>Account with Balance Report</h1>
	<ol class="breadcrumb">
		<li>
			<a href="{{url('/admin')}}">
				<i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
				Home
			</a> 
		</li>
		<li>
			<a >Reports</a>
		</li>
		<li class="active">Account with Balance Report</li>
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
					<div class="form-horizontal">
						<form action="/reports/accountbalance/print" method="post" target="_blank">
							{{csrf_field()}}
							<button type="submit" class="btn btn-primary">
								<i class="livicon pull-left" data-name="printer" data-hc="#fff" data-c="#fff" data-size="25"></i>&ensp;Generate
							</button>
						</form>
						<table class="table table-striped table-bordered" style="margin-top: 20px;" id="table1">
                <thead>
                    <tr>
                        <th width="25%">Account Number</th>
                        <th width="30%">Account Name</th>
                        <th width="15%" style="text-align: right;">Balance (Php)</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                		@foreach($accountAll as $accounts)
                		<tr>
                				<td>{{$accounts['accountNumber']}}</td>
                				<td>{{$accounts['accountName']}}</td>
                				<td style="text-align: right;">{{number_format($accounts['balance'],2)}}</td>
                				<td><form>{{csrf_field()}}<button class="btn btn-primary"><i class="glyphicon glyphicon-print"></i>&ensp;Notify</button></form></td>
                		</tr>
                		@endforeach
                </tbody>
            </table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('js')
	@endsection