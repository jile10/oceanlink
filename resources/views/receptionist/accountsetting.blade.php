@extends('receptionist.layouts.default')
@section("css")
<link href="/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen" />
<link href="/vendors/jasny-bootstrap/css/jasny-bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="\vendors\bootstrap3-editable\css\bootstrap-editable.css">
<link rel="stylesheet" type="text/css" href="{{ asset('/css/toastr.min.css') }}">
@endsection
@section('content')

<style type="text/css">
    a{
        cursor: pointer;
    }
	.buttons{
		margin-left: 87.2%;
		margin-bottom: 2.5%;
	}
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
	<!--section starts-->
<h1>Account Setting</h1>
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
                    <ul class="nav  nav-tabs ">
                        <li class="active">
                            <a href="#tab1" data-toggle="tab">
                               <i class="livicon" data-name="user" data-size="16" data-c="#000" data-hc="#000" data-loop="true"></i>
                            User Profile</a>
                        </li>
                        <li>
                            <a href="#tab2" data-toggle="tab">
                         <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                            Change Password</a>
                        </li>
                    </ul>
                    <div  class="tab-content mar-top">
                        <div id="tab1" class="tab-pane fade active in">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div style="margin-top: 20px;">
                                        <div class="col-md-4">
					                        <div class="fileinput fileinput-new" data-provides="fileinput">
					                            <div class="fileinput-new thumbnail img-file">
					                                <img src="/display_image/{{Auth::user()->employee->image}}" width="300px" height="250px" alt="..."></div>
					                            <div class="fileinput-preview fileinput-exists thumbnail img-max"></div>
					                            <div>
                                                    <form id="uploadForm" action="/receptionist/update-image" method="POST" enctype="multipart/form-data">
                                                        {{csrf_field()}}
                                                        <span class="btn btn-primary btn-file">
                                                            <span class="fileinput-new"><i class="glyphicon glyphicon-paperclip"></i>&ensp;Upload image</span>
                                                            <span class="fileinput-exists"><i class="glyphicon glyphicon-repeat"></i>&ensp;Change</span>
                                                            <input type="file" id="imagefile" name="image">
                                                        </span>
                                                        <button type="submit" class="btn btn-info fileinput-exists"><i class="glyphicon glyphicon-floppy-save"></i>&ensp;Save</button>
                                                        <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"><i class="glyphicon glyphicon-remove"></i>&ensp;Remove</a>
                                                    </form>
                                                </div>
					                        </div>
					                    </div>
                                        <div class="col-md-8">
                                            <div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped" id="users">
                                                    <tr>
                                                        <td width="30%">Full Name</td>
                                                        <td width="55%" id="fieldFN">{{Auth::user()->employee->firstName . ' ' . Auth::user()->employee->middleName . ' ' . Auth::user()->employee->lastName}}</td>
                                                        <td width="15%" id="buttonFN"><button onclick="update('FN')" type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="30%">Address</td>
                                                        <td width="55%" id="fieldAD">{{Auth::user()->employee->street . ' ' . Auth::user()->employee->barangay . ' ' . Auth::user()->employee->city}}</td>
                                                        <td width="15%" id="buttonAD"><button onclick="update('AD')" type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="30%">Email Address</td>
                                                        <td width="55%" id="fieldEM">{{Auth::user()->email}}</td>
                                                        <td width="15%" id="buttonEM"><button onclick="update('EM')" type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="30%">Date of Birth</td>
                                                        <td width="55%" id="fieldDOB">{{Carbon\Carbon::parse(Auth::user()->employee->dob)->format('F d, Y')}}</td>
                                                        <td width="15%" id="buttonDOB"><button onclick="update('DOB')" type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil"></i></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="30%">Contact No.</td>
                                                        <td width="55%" id="fieldCO">{{Auth::user()->employee->contact}}</td>
                                                        <td width="15%" id="buttonCO"><button onclick="update('CO')" type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil"></i></button></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab2" class="tab-pane fade">
                            <div class="row">
                                <div class="col-md-12 pd-top">
                                    <form action="#" class="form-horizontal">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label for="inputpassword" class="col-md-3 control-label">
                                                    Password
                                                    <span class='require'>*</span>
                                                </label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                        </span>
                                                        <input type="password" placeholder="Password" class="form-control"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputnumber" class="col-md-3 control-label">
                                                    Confirm Password
                                                    <span class='require'>*</span>
                                                </label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                        </span>
                                                        <input type="password" placeholder="Password" class="form-control"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                &nbsp;
                                                <button type="button" class="btn btn-danger">Cancel</button>
                                                &nbsp;
                                                <input type="reset" class="btn btn-default hidden-xs" value="Reset">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('js')
<script  src="/vendors/jasny-bootstrap/js/jasny-bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="\vendors\bootstrap3-editable\js\bootstrap-editable.js"></script>
<script type="text/javascript" src="/vendors/datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
        <script src="/vendors/input-mask/jquerymask.js" type="text/javascript"></script>
<script src="/js/toastr.min.js"></script>
<script>

    $.fn.editable.defaults.mode = 'popup';
    $.fn.editable.defaults.params = function (params) {
        params._token = $("#_token").data("token");
        return params;
    };

    $("#firstName").editable({
        placement: 'right',
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

    $("#middleName").editable({
        placement: 'right',
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

    $("#lastName").editable({
        placement: 'right',
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

    $("#email").editable({
        placement: 'right',
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

    $("#bday").editable({
        placement: 'right',
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

	$(document).ready( function(){
		var table = $('#table1').DataTable();
	});
	$('.sel-time-am').clockface();
	$('#attendance').addClass( "active" );
</script>
<script type="text/javascript">
    function update(name)
    {
        switch(name)
        {
            case 'FN':
                $('#field'+name).empty();
                $('#field'+name).append('<input type="text" id="firstName" class="form-control col-md-4" value="{{Auth::user()->employee->firstName}}"><input type="text" id="middleName" class="form-control col-md-4" value="{{Auth::user()->employee->middleName}}"><input type="text" id="lastName" class="form-control col-md-4" value="{{Auth::user()->employee->lastName}}">');
                $('#button'+name).empty();
                $('#button'+name).append('<button onclick="save('+"'"+name+"'"+')" type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-ok"></i></button>&ensp;<button onclick="remove('+"'"+name+"'"+')" type="button" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-remove"></i></button>');
                break;
            case 'AD':
                $('#field'+name).empty();
                $('#field'+name).append('<input type="text" id="street" class="form-control col-md-4" value="{{Auth::user()->employee->street}}"><input type="text" id="barangay" class="form-control col-md-4" value="{{Auth::user()->employee->barangay}}"><input type="text" id="city" class="form-control col-md-4" value="{{Auth::user()->employee->city}}">');
                $('#button'+name).empty();
                $('#button'+name).append('<button onclick="save('+"'"+name+"'"+')" type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-ok"></i></button>&ensp;<button onclick="remove('+"'"+name+"'"+')" type="button" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-remove"></i></button>');
                break;
            case 'DOB': 
                $('#field'+name).empty();
                $('#field'+name).append('<div class="input-group date form_datetime" data-link-field="dtp_input1"><input class="form-control hasDatepicker" size="16" type="text" value="{{Carbon\Carbon::parse(Auth::user()->employee->dob)->format("F d,Y")}}" id="dob" name="dob" readonly><span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span></div>');
                $('#button'+name).empty();
                $('#button'+name).append('<button onclick="save('+"'"+name+"'"+')" type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-ok"></i></button>&ensp;<button onclick="remove('+"'"+name+"'"+')" type="button" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-remove"></i></button>');
                $(".form_datetime").datetimepicker({
                    format: "MM d,yyyy",
                    endDate: "{{Carbon\Carbon::today()}}",
                    weekStart: 1,
                    todayBtn:  1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 2,
                    minView: 2,
                    maxView: 3,
                    forceParse: 0,
                    viewSelect:'month'
                });
                break;
            case 'CO': 
                $('#field'+name).empty();
                $('#field'+name).append('<div class="col-md-6"><select name="contactType" id="contactType" class="selector form-control" style="padding: 0px; width: 80%;" onchange="contactTypeChanged(this)">@if(strlen(Auth::user()->employee->contact)>8)<option selected value="mobile">Mobile No.</option><option value="tel">Landline No.</option>@else<option value="mobile">Mobile No.</option><option selected value="tel">Landline No.</option> @endif<select></div><div class="col-md-6" id="contactC" style="margin-left: -40px;"><input type="text" value="{{Auth::user()->employee->contact}}" id="contact" class="selector cp form-control placeholder" name="contact" placeholder="0999 9999 999"></div>');
                $('#button'+name).empty();
                $('#button'+name).append('<button onclick="save('+"'"+name+"'"+')" type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-ok"></i></button>&ensp;<button onclick="remove('+"'"+name+"'"+')" type="button" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-remove"></i></button>');
                $('.tel').mask('000 0000',
              {
                    "placeholder": "--- ----"
              });

              $('.cp').mask('0000 0000 000',
              {
                    "placeholder": "---- ---- ---"
              });
                break;
            case 'EM': 
                $('#field'+name).empty();
                $('#field'+name).append('<input type="email" id="email" class="form-control col-md-4" value="{{Auth::user()->email}}">');
                $('#button'+name).empty();
                $('#button'+name).append('<button onclick="save('+"'"+name+"'"+')" type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-ok"></i></button>&ensp;<button onclick="remove('+"'"+name+"'"+')" type="button" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-remove"></i></button>');
                break;

        }
    }
    function remove(name){
        switch(name)
        {
            case 'FN':
                $('#field'+name).empty();
                $('#field'+name).append('{{Auth::user()->employee->firstName . ' ' . Auth::user()->employee->middleName . ' ' . Auth::user()->employee->lastName}}');
                $('#button'+name).empty();
                $('#button'+name).append('<button onclick="update('+"'"+name+"'"+')" type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil"></i></button>');
                break;
            case 'AD':
                $('#field'+name).empty();
                $('#field'+name).append('{{Auth::user()->employee->street . ' ' . Auth::user()->employee->barangay . ' ' . Auth::user()->employee->city}}');
                $('#button'+name).empty();
                $('#button'+name).append('<button onclick="update('+"'"+name+"'"+')" type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil"></i></button>');
                break;
            case 'DOB':
                $('#field'+name).empty();
                $('#field'+name).append('{{Carbon\Carbon::parse(Auth::user()->employee->dob)->format("F d, Y")}}');
                $('#button'+name).empty();
                $('#button'+name).append('<button onclick="update('+"'"+name+"'"+')" type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil"></i></button>');
                break;
            case 'CO': 
                $('#field'+name).empty();
                $('#field'+name).append('{{Auth::user()->employee->contact}}');
                $('#button'+name).empty();
                $('#button'+name).append('<button onclick="update('+"'"+name+"'"+')" type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil"></i></button>');
                break;
            case 'EM': 
                $('#field'+name).empty();
                $('#field'+name).append('{{Auth::user()->email}}');
                $('#button'+name).empty();
                $('#button'+name).append('<button onclick="update('+"'"+name+"'"+')" type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil"></i></button>');
                break;
        }
    }
    function save(name){
        switch(name)
        {
            case 'FN':
                var firstName = String($('#firstName').val()).valueOf();
                var middleName = String($('#middleName').val()).valueOf();
                var lastName = String($('#lastName').val()).valueOf();
                $.ajax({
                    type:'get',
                    url:'{!!URL::to('/employee/update-firstname')!!}',
                    data:{'firstName':firstName,'middleName':middleName,'lastName':lastName},
                    success:function(data){
                        $('#field'+name).empty();
                        $('#field'+name).append(firstName + ' ' + middleName + ' ' + lastName);  
                        $('#button'+name).empty();
                        $('#button'+name).append('<button onclick="update('+"'"+name+"'"+')" type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil"></i></button>');
                        switch(data['alert-type']){
                            case 'success':
                                toastr.success(data['message']);
                                break;

                            case 'error':
                                toastr.error(data['message']);
                                break;
                        }
                    },
                    error:function(){

                    },
                });
                break;
            case 'AD':
                var street = String($('#street').val()).valueOf();
                var barangay = String($('#barangay').val()).valueOf();
                var city = String($('#city').val()).valueOf();
                $.ajax({
                    type:'get',
                    url:'{!!URL::to('/employee/update-address')!!}',
                    data:{'street':street,'barangay':barangay,'city':city},
                    success:function(data){
                        $('#field'+name).empty();
                        $('#field'+name).append(street + ' ' + barangay+ ' ' + city);  
                        $('#button'+name).empty();
                        $('#button'+name).append('<button onclick="update('+"'"+name+"'"+')" type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil"></i></button>');
                        switch(data['alert-type']){
                            case 'success':
                                toastr.success(data['message']);
                                break;

                            case 'error':
                                toastr.error(data['message']);
                                break;
                        }
                    },
                    error:function(){

                    },
                });
                break;
            case 'EM':
                var email = String($('#email').val()).valueOf();
                $.ajax({
                    type:'get',
                    url:'{!!URL::to('/employee/update-email')!!}',
                    data:{'email':email},
                    success:function(data){
                        $('#field'+name).empty();
                        $('#field'+name).append(email);  
                        $('#button'+name).empty();
                        $('#button'+name).append('<button onclick="update('+"'"+name+"'"+')" type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil"></i></button>');
                        switch(data['alert-type']){
                            case 'success':
                                toastr.success(data['message']);
                                break;

                            case 'error':
                                toastr.error(data['message']);
                                break;
                        }
                    },
                    error:function(){

                    },
                });
                break;
            case 'DOB':
                var dob = String($('#dob').val()).valueOf();
                $.ajax({
                    type:'get',
                    url:'{!!URL::to('/employee/update-dob')!!}',
                    data:{'dob':dob},
                    success:function(data){
                        $('#field'+name).empty();
                        $('#field'+name).append(dob);  
                        $('#button'+name).empty();
                        $('#button'+name).append('<button onclick="update('+"'"+name+"'"+')" type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil"></i></button>');
                        switch(data['alert-type']){
                            case 'success':
                                toastr.success(data['message']);
                                break;

                            case 'error':
                                toastr.error(data['message']);
                                break;
                        }
                    },
                    error:function(){

                    },
                });
                break;
            case 'CO':
                var contact = String($('#contact').val()).valueOf();
                $.ajax({
                    type:'get',
                    url:'{!!URL::to('/employee/update-contact')!!}',
                    data:{'contact':contact},
                    success:function(data){
                        $('#field'+name).empty();
                        $('#field'+name).append(contact);  
                        $('#button'+name).empty();
                        $('#button'+name).append('<button onclick="update('+"'"+name+"'"+')" type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil"></i></button>');
                        switch(data['alert-type']){
                            case 'success':
                                toastr.success(data['message']);
                                break;

                            case 'error':
                                toastr.error(data['message']);
                                break;
                        }
                    },
                    error:function(){

                    },
                });
                break;
        }
    }

    function contactTypeChanged(contactType){
      if(contactType.value == "tel"){
        $("#contactC").empty();
        @if(strlen(Auth::user()->employee->contact)<=8)
        $("#contactC").append('<input type="text" id="contact" value="{{Auth::user()->employee->contact}}" name="contact" class="tel form-control placeholder" placeholder="999 9999">')
        @else
        $("#contactC").append('<input type="text" id="contact" name="contact" class="tel form-control placeholder" placeholder="999 9999">')
        @endif
        $('.tel').mask('000 0000',
        {
            "placeholder": "--- ----"
        });

        $('.cp').mask('0000 0000 000',
        {
            "placeholder": "---- ---- ---"
        });
      }
      else{
        
        $("#contactC").empty();
        @if(strlen(Auth::user()->employee->contact)>8)
        $("#contactC").append('<input type="text" id="contact" value="{{Auth::user()->employee->contact}}" name="contact" class="cp form-control placeholder" placeholder="0999 9999 999">')
        @else
        $("#contactC").append('<input type="text" id="contact" name="contact" class="cp form-control placeholder" placeholder="0999 9999 999">')
        @endif
        
        $('.tel').mask('000 0000',
        {
            "placeholder": "--- ----"
        });

        $('.cp').mask('0000 0000 000',
        {
            "placeholder": "---- ---- ---"
        });
      }
    }
</script>

<script type="text/javascript">
@if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;
        
        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
@endif

</script>
@endsection