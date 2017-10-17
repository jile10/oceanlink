@extends('admin.layouts.default')
@section("css")
<link rel="stylesheet" type="text/css" href="{{ asset('/css/toastr.min.css') }}">
<link rel="stylesheet" type="text/css" href="\vendors\bootstrap3-editable\css\bootstrap-editable.css">
@endsection
@section('content')
<section class="content-header">
	<!--section starts-->
	<h1>Utilities</h1>
	<ol class="breadcrumb">
		<li>
			<a href="{{url('/admin')}}">
				<i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
				Home
			</a> 
		</li>
		<li>
			<a >Utilities</a>
		</li>
		<li>
			<a >Company Information</a>
		</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">
            <form id="traineeInfoForm" action="#">
                <div class="row">
                    <div class="col-md-4" style="margin-bottom:">
                        <div class="panel panel-lightgreen">
                            <div class="panel-heading">
                                <h4 class="panel-title"><em>Note: <font color="red">*</font> fields are required</em></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-md-12">
                        <div class="panel panel-primary" style="margin-top: 0px;">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="livicon" data-name="user" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
                                    Company Information
                                </h3>
                                <span class="pull-right clickable">
                                    <i class="glyphicon glyphicon-chevron-up"></i>
                                </span>
                            </div>
                            <div class="panel-body">
                                <div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
                                <h4><b>Company Name : &ensp;<a id="text" data-type="text" data-pk="{{$companyinfo->id}}" data-url="/update-company-name" data-title="Edit Company Name">{{$companyinfo->name}}</a>
                                <h4 style="margin-top: 20px;"><b>Company Address : &ensp;<a id="textarea" data-type="textarea" data-pk="{{$companyinfo->id}}" data-url="/update-company-address" data-title="Edit Company Address">{{$companyinfo->address}}</a>
                                <h4 style="margin-top: 20px;"><b>Training Director : &ensp;<a id="tdirector" data-type="text" data-pk="{{$companyinfo->id}}" data-url="/update-company-tdirector" data-title="Edit Training Director Name">{{$companyinfo->director}}</a>
                                <h4 style="margin-top: 20px;"><b>Chief Operating Officer : &ensp;<a id="cofficer" data-type="text" data-pk="{{$companyinfo->id}}" data-url="/update-company-cofficer" data-title="Edit Chief Training Officer Name">{{$companyinfo->chiefofficer}}</a>
                                <h4 style="margin-top: 20px;"><b>Registrar : &ensp;<a id="registrar" data-type="text" data-pk="{{$companyinfo->id}}" data-url="/update-company-registrar" data-title="Edit Registrar Name">{{$companyinfo->registrar}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
@section('js')
    <script src="/js/toastr.min.js"></script>
    <script type="text/javascript" src="\vendors\bootstrap3-editable\js\bootstrap-editable.js"></script>
    <script type="text/javascript">
        $.fn.editable.defaults.mode = 'popup';
        $.fn.editable.defaults.params = function (params) {
            params._token = $("#_token").data("token");
            return params;
        };

        $("#text").editable({
            placement: 'top',
            validate: function(value) {
                if($.trim(value) == '') 
                    return 'This Field is required.';
            },
            ajaxOptions:{
                success:function(data){
                    if(data['alert-type'] == "error")
                    {
                        toastr.error(data['message']);
                    }
                    else
                    {
                        toastr.success(data['message']);
                    }
                }
            },
        });
        $("#textarea").editable({
            placement: 'top',
            validate: function(value) {
                if($.trim(value) == '') 
                    return 'This Field is required.';
            },
            ajaxOptions:{
                success:function(data){
                    if(data['alert-type'] == "error")
                    {
                        toastr.error(data['message']);
                    }
                    else
                    {
                        toastr.success(data['message']);
                    }
                }
            },
        });
        $("#tdirector").editable({
            placement: 'top',
            validate: function(value) {
                if($.trim(value) == '') 
                    return 'This Field is required.';
            },
            ajaxOptions:{
                success:function(data){
                    if(data['alert-type'] == "error")
                    {
                        toastr.error(data['message']);
                    }
                    else
                    {
                        toastr.success(data['message']);
                    }
                }
            },
        });
        $("#cofficer").editable({
            placement: 'top',
            validate: function(value) {
                if($.trim(value) == '') 
                    return 'This Field is required.';
            },
            ajaxOptions:{
                success:function(data){
                    if(data['alert-type'] == "error")
                    {
                        toastr.error(data['message']);
                    }
                    else
                    {
                        toastr.success(data['message']);
                    }
                }
            },
        });
        $("#registrar").editable({
            placement: 'top',
            validate: function(value) {
                if($.trim(value) == '') 
                    return 'This Field is required.';
            },
            ajaxOptions:{
                success:function(data){
                    if(data['alert-type'] == "error")
                    {
                        toastr.error(data['message']);
                    }
                    else
                    {
                        toastr.success(data['message']);
                    }
                }
            },
        });



    </script>
@endsection