@extends('admin.layouts.default')


@section('css')
<link href="/vendors/panel/panel.css" rel="stylesheet" type="text/css"/>
<link href="/css/all.css?v=1.0.2" rel="stylesheet">

<style type="text/css">
    
	.panelLabel{
		font-size: 12px;
	}
	.digits{
		font-size: 40px;
		font-weight: bold;
	}
</style>
@endsection
@section('content')
<section class="content-header">
	<!--section starts-->
	<h1>Dashboard</h1>
	<ol class="breadcrumb">
		<li>
			<a href="{{url('/admin')}}">
				<i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
				Home
			</a> 
		</li>
		<li class="active">
			Dashboard
		</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">
			<!-- 	----------------------------------------SCHEDULE--------------------------------------- -->
			<div class="col-lg-8">
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="panel-title"><span class="glyphicon glyphicon-calendar"></span>Schedule</div>
					</div>
					<div class="panel-body">
						
					</div>
				</div>
			</div>
			<!-- 	----------------------------------------PANELS--------------------------------------- -->
			<div class="col-lg-4">
				<div class="row">
					<div class="panel panel-blue">
						<div class="panel-body">
							<div class="col-lg-6">
								<center>
									<span class="digits">{{$enrolledStudents}}</span>
									<div class="row">
										<span class="pull left panelLabel">Currently Enrolled Students</span>
									</div>
								</center>
							</div>
							<div class="col-lg-6">
								<center>
									<i class="livicon" data-name="users" data-size="75" data-loop="true" data-c="#fff" data-hc="white"></i>
								</center>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="panel panel-orange">
						<div class="panel-body">
							<div class="col-lg-6">
								<center>
									<span class="digits">{{$ongoingCourses}}</span>
									<div class="row">
										<span class="pull left panelLabel">Ongoing Courses</span>
									</div>
								</center>
							</div>
							<div class="col-lg-6">
								<center>
									<i class="livicon" data-name="notebook" data-size="75" data-loop="true" data-c="#fff" data-hc="white"></i>
								</center>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="panel panel-red">
						<div class="panel-body">
							<div class="col-lg-6">
								<center>
									<span class="digits">{{$trainingOfficers}}</span>
									<div class="row">
										<span class="pull left panelLabel">Accounts that need notification</span>
									</div>
								</center>
							</div>
							<div class="col-lg-6">
								<center>
									<i class="livicon" data-name="user" data-size="75" data-loop="true" data-c="#fff" data-hc="white"></i>
								</center>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="panel panel-green">
						<div class="panel-body">
							<div class="col-lg-6">
								<center>
									<span class="digits">{{$enrolledStudents}}</span>
									<div class="row">
										<span class="pull left panelLabel">Ongoing Courses</span>
									</div>
								</center>
							</div>
							<div class="col-lg-6">
								<center>
									<i class="livicon" data-name="user" data-size="75" data-loop="true" data-c="#fff" data-hc="white"></i>
								</center>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection	