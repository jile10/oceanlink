@extends('admin.layouts.default')
@section('css')
	<link rel="stylesheet" type="text/css" href="/css/table.css">
  <link href="{{ asset('/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>

@endsection
@section('content')

<style type="text/css">
.first{
	background-color: #2F8DB3;
	color: white;
	font-size: 17px;
	font-weight: bold;
}
.second{
	background-color: #5BA5C2;
	color: white;
	font-size: 16px;
}
.third{
	background-color: #8DC6D9;
	color: white;
	font-size: 15px;
}
thead{
	background-color: #0E9F92;
	color: white;
	font-size: 15px;
}
th{
	border-bottom: 2px solid black;
	border-left: 2px solid white;
	border-right: 2px solid white;
}
</style>

<section class="content-header">
	<!--section starts-->
	<h1>Queries</h1>
	<ol class="breadcrumb">
		<li>
			<a href="{{url('/admin')}}">
				<i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
				Home
			</a> 
		</li>
		<li class="active">Queries</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default filterable" style="overflow:auto;">
				<div class="panel-heading">
					<h3 class="panel-title">
					</h3>
				</div>
				<div class="panel-body table-responsive">
					<div class="form-horizontal">
						<div class="col-md-8">
							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label" for="query">Query</label>
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<select name="query" id="query" class="form-control" onchange="queryChanged(this)">
										<option selected disabled>--Select a Query--</option>
										<option value="1">Most enrolled course</option>
										<option value="2">Accounts with balance</option>
										<option value="3">Most Recent Cancelled Schedule</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<table id="queryTable">
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('js')
	
  <script src="{{ asset('/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>

	<script type="text/javascript">
		function queryChanged(query){
			switch(query.value){
				case "1":
					$('#queryTable').empty();
					$('#queryTable').append('<thead><tr><th width="30%">Program Type</th><th width="40%">Course Name</th><th width="30%">Number of Enrolled Students</th></tr></thead><tbody id="tableBody"></tbody>');
					$.ajax({
		            type:'get',
		            url:'{!!URL::to('ajax-query-course-enrolled')!!}',
		            data:{},
		            success:function(data){
									for(var i = 0; i< data.length; i++){
										var count = data[i]['counter'];
											$('#tableBody').append('<tr><td>'+data[i]['program_type']+'</td><td>'+data[i]['course_name']+'</td><td>'+data[i]['counter']+'</td></tr>')
									}
									$("#tableBody tr:nth-child(1)").addClass('first');
									$("#tableBody tr:nth-child(2)").addClass('second');
									$("#tableBody tr:nth-child(3)").addClass('third');
		            },
		            error:function(){
		            }
		          });
					break;

				case "2":
					$('#queryTable').empty();
					$('#queryTable').append('<thead><tr><th width="25%">Account Number</th><th width="40%">Account Owner Name</th><th width="20%">Balance</th><th width="15%">Action</th></tr></thead><tbody id="tableBody"></tbody>');
					$.ajax({
		            type:'get',
		            url:'{!!URL::to('ajax-query-account-balance')!!}',
		            data:{},
		            success:function(data){
						for(var i = 0; i< data.length; i++){
							$('#tableBody').append('<tr><td>'+data[i]['accountNumber']+'</td><td>'+data[i]['accountName']+'</td><td>'+data[i]['balance']+'</td><td><button type="button" class="btn btn-success">Print Notification</button></td></tr>')
						}
						$("#tableBody tr:nth-child(1)").addClass('first');
						$("#tableBody tr:nth-child(2)").addClass('second');
						$("#tableBody tr:nth-child(3)").addClass('third');
		            },
		            error:function(){
		            }
		          });
					break;
			}
		}

		//$('#queryTable').DataTable();
	</script>
@endsection