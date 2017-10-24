@extends('home.layouts.master2')
@section("css")
    <link href="/vendors/fonts/ionicons/ionicons.css" rel="stylesheet" />
    <link href="/vendors/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="{{ asset('/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Color Panel -->
    <link href="/vendors/panel/panel.css" rel="stylesheet" type="text/css"/>
    <link href="/css/all.css?v=1.0.2" rel="stylesheet">
    <link href="/css/flat/blue.css" rel="stylesheet">
    <link href="/css/table.css" rel="stylesheet">
    <link href="vendors/touchspin/dist/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/toastr.min.css') }}">
@endsection
@section('content')
<style type="text/css">
    .badge-danger{
        background-color: #D89796!important;
    }
    .rowColor{
        background-color: #D89796!important;
        color: white;
    }

    .navs{
        height: 80px;
        background-color:#212121;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .divs{
        margin-bottom: 15px;
    }
    .capital{
        text-transform: capitalize;
    }
    label.error{
        color: red;
        margin: 0px;
        padding-bottom: 5px;
        padding-left: 10px;
        padding-top: 0px;
        font-size
    }
    SPAN.textbox
    {
        background-color: #FFF;
        color: #888;
        line-height:20px;
        height:20px;
        padding:3px;
        border:1px #888 solid;
        font-size:9pt;
    }
</style>

<section class="content">
    <!--main content-->
    <div class="row" >
        <div class="col-md-12">
            <div class="col-md-12"> 
            <!--main content-->
                <div class="row">
                    <div class="col-md-12">
                      <h1 class="text-center">Trainee Information Form</h1>
                      <br><br>
                      <!-- BEGIN FORM WIZARD WITH VALIDATION -->
                      <form id="apply-form" action="/iApply/insert" method="post">
                          {{csrf_field()}}
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="alert alert-success">
                                            <p><em>Note: <font color="red">*</font> fields are required</em></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach(session('sprogram_id') as $ids)
                        <input type="hidden" name="sprogram_id[]" value="{{$ids}}">
                        @endforeach
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="panel panel-primary" style="margin-top: 0px;">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <i class="livicon" data-name="user" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
                                            Select Payment Mode
                                        </h3>
                                        <span class="pull-right clickable">
                                            <i class="glyphicon glyphicon-chevron-up"></i>
                                        </span>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12 table-responded">
                                            <table class="striped bordered" id="table1">
                                                <thead>
                                                    <tr>
                                                        <th width="30%">Course</th>
                                                        <th width="15%">Date Start</th>
                                                        <th width="15%">Date End</th>
                                                        <th width="15%" style="text-align:right;">Fee &ensp;(Php)</th>
                                                        <th width="25%" style="text-align: center;">Payment Mode</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($tclass as $tclasses)
                                                    @foreach(session('sprogram_id') as $ids)
                                                    @if($tclasses['id'] == $ids)
                                                    <tr id="row{{$tclasses['id']}}">
                                                        <td>{{$tclasses['course_name']}}</td>
                                                        <td>{{$tclasses['dateStart']}}</td>
                                                        <td>{{$tclasses['dateEnd']}}</td>
                                                        <td style="text-align:right;">{{number_format($tclasses['fee'],2)}}</td>
                                                        <td id="col{{$tclasses['id']}}">
                                                            <label class="radio-inline">
                                                                <input id="PP{{$tclasses['id']}}" type="radio" name="paymentMode{{$tclasses['id']}}[]" value="1" checked>&ensp;Partial
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input id="FP{{$tclasses['id']}}" type="radio" name="paymentMode{{$tclasses['id']}}[]" value="2">&ensp;Full
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-horizontal" id="checks">
                                <div class="form-group" style="margin-left: 20px;">
                                    <input  type="checkbox" name="alumni">&ensp;I'm an Alumni/Trainee
                                    <input type="hidden" name="enrollee_id" id="enrollee_id" value="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="panel panel-primary" style="margin-top: 0px;">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <i class="livicon" data-name="user" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
                                            Personal Information
                                        </h3>
                                        <span class="pull-right clickable">
                                            <i class="glyphicon glyphicon-chevron-up"></i>
                                        </span>
                                    </div>
                                    <div class="panel-body">
                                        <h2 class="hidden">&nbsp;</h2>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div  class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">First Name<font color="red">*</font></span>
                                                        <input id="1firstName" type="text" class="selector form-control capital" name="firstName">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Middle Name</span>
                                                        <input id="1middleName" type="text" class="selector form-control capital" name="middleName">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Last Name<font color="red">*</font></span>
                                                        <input id="1lastName" type="text" class="selector form-control capital" name="lastName">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span>Gender<font color="red">*</font></span>
                                                        <label class="radio-inline">
                                                            <input class="selector" type="radio" name="gender" required id="male" value="M" checked>Male
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input class="selector" type="radio" name="gender" required id="female" value="F">Female
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Civil Status<font color="red">*</font></span>
                                                        <select name="civilStatus" id="civilStatus" class="selector form-control">
                                                            <option  id="option1" selected disabled>--Select Civil Status--</option>
                                                            @foreach($cstatus as $cstatuses)
                                                            <option value="{{$cstatuses->id}}">{{$cstatuses->statusName}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="input-group date form_datetime"  data-date-format="MM dd, yyyy" data-link-field="dtp_input1">
                                                    <span class="input-group-addon">Birthdate<font color="red">*</font></span>
                                                    <input class="form-control" size="16" type="text" value="" readonly name="dob" id="1dob" onchange="dobChanged(this)">
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-th"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">Age</span>
                                                            <input type="text" id="age" class="form-control" name="age" readonly="readonly" maxlength="3">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Birthplace<font color="red">*</font></span>
                                                        <input type="text" id="1dop" class="selector form-control" name="dop">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <i class="livicon" data-name="home" data-size="18" data-c="#fff" data-hc="white" data-loop="true"></i>
                                            Home Address
                                        </h3>

                                        <span class="pull-right clickable">
                                            <i class="glyphicon glyphicon-chevron-up"></i>
                                        </span>
                                    </div>
                                    <div class="panel-body">
                                        <h2 class="hidden">&nbsp;</h2>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Street<font color="red">*</font></span>
                                                        <input type="text" id="1street" class="selector form-control capital" name="street">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Barangay<font color="red">*</font></span>
                                                        <input type="text" id="1barangay" class="selector form-control capital" name="barangay">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">City<font color="red">*</font></span>
                                                        <input type="text" id="1city" class="selector form-control capital" name="city">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <span class="glyphicon glyphicon-earphone"></span>&ensp; Contact Information
                                        </h3>

                                        <span class="pull-right clickable">
                                            <i class="glyphicon glyphicon-chevron-up"></i>
                                        </span>
                                    </div>
                                    <div class="panel-body">
                                        <h2 class="hidden">&nbsp;</h2>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <span>Contact<font color="red">*</font></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <select name="contactType" id="contactType" class="selector form-control" onchange="changeContactType(this)">
                                                        <option selected value="mobile">Mobile No.</option>
                                                        <option value="tel">Landline No.</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div id="contactC">
                                                        <input type="text" id="1contactI" name="contact" class="cp form-control placeholder selector" placeholder="e.g: 0999 9999 999">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Email<font color="red">*</font></span>
                                                        <input type="email" id="1email" class="form-control selector" name="email">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- EMERGENCY CONTACT -->
                            <div class="col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <span class="glyphicon glyphicon-phone-alt"></span>&ensp;Contact In Case Of Emergency
                                        </h3>
                                        <span class="pull-right clickable">
                                            <i class="glyphicon glyphicon-chevron-up"></i>
                                        </span>
                                    </div>
                                    <div class="panel-body">
                                        <h2 class="hidden">&nbsp;</h2>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Name<font color="red">*</font></span>
                                                        <input type="text" id="1Ename" class="selector form-control capital" name="Ename">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Relationship<font color="red">*</font></span>
                                                        <input type="text" id="1Erel" class="selector form-control capital" name="Erel">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <span>Contact<font color="red">*</font></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <select name="EContactType" id="1EContactType" class="selector form-control" onchange="EchangeContactType(this)">
                                                        <option selected value="mobile">Mobile No.</option>
                                                        <option value="tel">Landline No.</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div id="contactE">
                                                        <input type="text" id="1EContact" name="Econtact" class="cp form-control placeholder selector" placeholder="e.g: 0999 9999 999">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Address<font color="red">*</font></span>
                                                        <textarea class="selector form-control" name="Eaddress" id="1Eaddress"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Educational Background -->
                            <div class="col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <span><i class="ion-university" style="font-size:20px;"></i></span>&ensp;Educational Background
                                        </h3>
                                        <span class="pull-right clickable">
                                            <i class="glyphicon glyphicon-chevron-up"></i>
                                        </span>
                                    </div>
                                    <div class="panel-body">
                                        <h2 class="hidden">&nbsp;</h2>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Attainment<font color="red">*</font></span>
                                                        <input type="text" id="1EBattainment" class="selector form-control capital" name="EBattainment">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">School<font color="red">*</font></span>
                                                        <input type="text" id="1EBschool" class="selector form-control capital" name="EBschool">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Course</span>
                                                        <input type="text" id="1EBcourse" class="selector form-control capital" name="EBcourse">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Sea Experience -->
                            <div class="col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <span><i class="ion-help-buoy" style="font-size:20px;"></i></span>&ensp;Sea Experience
                                        </h3>
                                        <span class="pull-right clickable">
                                            <i class="glyphicon glyphicon-chevron-up"></i>
                                        </span>
                                    </div>
                                    <div class="panel-body">
                                        <h2 class="hidden">&nbsp;</h2>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">No. of Years</span>
                                                        <input id="years" type="text" class="selector form-control" name="noYears">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Rank/Position</span>
                                                        <input id="rank" type="text" class="selector form-control capital" name="rank">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Trainings Attended  -->
                            <div class="col-md-12">
                                <div class="panel panel-primary filterable" style="overflow:auto;">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <span><i class="ion-ribbon-b" style="font-size:20px;"></i></span>&ensp;Trainings Attended
                                        </h3>
                                        <span class="pull-right clickable">
                                            <i class="glyphicon glyphicon-chevron-up"></i>
                                        </span>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12 table-responded">
                                            <table class="table table-striped table-bordered">
                                                <thead id="dynamic_head">
                                                    <tr>
                                                        <th width="35%">Training Title</th>
                                                        <th width="35%">Training Center</th>
                                                        <th width="25%">Date Taken</th>
                                                        <th width="5%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="dynamic_field">
                                                    <tr>
                                                        <td><div><input type="text" class="selector form-control capital training" name="trainingTitle[]" onblur="validateTraining(this)"></div></td>
                                                        <td><div><input type="text" class="selector form-control capital training" name="trainingCenter[]"  onblur="validateTraining(this)"></div></td>
                                                        <td>
                                                            <div class="input-group date form_datetime selector"  data-date-format="MM dd, yyyy" data-link-field="dtp_input1">
                                                                <input class="form-control selector training" size="16" type="text" value="" readonly name="dateTaken[]" id="dateTaken" onchange="validateTraining(this)">
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-remove selector"></span>
                                                                </span>
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-th selector"></span>
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td><button type="button" class="selector btn btn-success" onclick="clicks()" id="add"><span class="glyphicon glyphicon-plus"></span></button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-block btn-lg btn-info pull-right" style="margin-bottom: 15px;">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
@section("js")   
    <script src="/js/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/home/js/jquery.validate.min.js"></script>
    <!-- datetimepicker-->
    <script type="text/javascript" src="/vendors/datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <!-- InputMask -->
    <script src="/vendors/input-mask/jquerymask.js" type="text/javascript"></script>
    <script src="js/metisMenu.js" type="text/javascript"></script>
    <script src="js/icheck.js" type="text/javascript"></script>
	<script src="/vendors/iCheck/icheck.js" type="text/javascript"></script>
  	<script src="/js/custom.js"></script>
    <script src="vendors/touchspin/dist/jquery.bootstrap-touchspin.js"></script>
    <script src="{{ asset('/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="/js/toastr.min.js"></script>
    <script type="text/javascript" src="/js/moment.min.js" charset="UTF-8"></script>
    <script src="{{ asset('/js/nowhitespace.js') }}"></script>

    <script type="text/javascript">
    $(".form_datetime").datetimepicker({
        format: "MM dd, yyyy",
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        maxView: 4,
        forceParse: 0,
    });
    </script> 

    <script type="text/javascript">
        $('input[type=checkbox]').on('ifChecked', function(event){
            $('#checks').append('<div class="form-group" id="checked"><label class="control-label col-md-3" >Enter Trainee Number</label><div class="col-md-3"><input id="enrollee" type="text" class="form-control"/></div><div class="col-md-2"><button type="button" onclick="enrolleechange()" class="btn btn-block btn-primary">Enter</button></div></div>');

            $('#civilStatus').attr('disabled',false);
            $('#option1').attr('disabled',false);
            $('#option1').attr('value','0');
            $('#civilStatus option:selected').removeAttr('selected');
            $("#civilStatus option[value='0']").attr("selected", "selected");
            $('#option1').attr('disabled',true);
            $('.selector').attr("disabled",true);
            $('#male').iCheck('uncheck');
            $('#female').iCheck('uncheck');
            $('#dynamic_head').empty();
            $('#dynamic_field').empty();
            $('#dynamic_head').append('<tr><th width="35%">Training Title</th><th width="35%">Training Center</th><th width="25%">Date Taken</th><th width="5%">Action</th></tr>');
        });
        $('input[type=checkbox]').on('ifUnchecked', function(event){
            $('#checked').remove();
            $('.selector').attr("disabled",false);
            $('#male').iCheck('check');
            $('#enrollee_id').attr('value','');
            $('#1firstName').attr('value','');
            $('#1lastName').attr('value','');
            $('#1middleName').attr('value','');
            $('#male').iCheck('check');
            $('#female').iCheck('uncheck');
            $('#civilStatus').attr('disabled',false);
            $('#option1').attr('disabled',false);
            $('#option1').attr('value','0');
            $('#civilStatus option:selected').removeAttr('selected');
            $("#civilStatus option[value='0']").attr("selected", "selected");
            $('#option1').attr('disabled',true);
            $('#1dob').val('');
            $('#1dop').attr('value','');
            $('#1street').attr('value','');
            $('#1barangay').attr('value','');
            $('#1city').attr('value','');
            $('#1contactI').attr('value','');
            $('#1email').attr('value','');
            $('#1Ename').attr('value','');
            $('#1Erel').attr('value','');
            $('#1Econtact').attr('value','');
            $('#1Eaddress').val('');
            $('#1EBattainment').attr('value','');
            $('#1EBschool').attr('value','');
            $('#1EBcourse').attr('value','');
            $('#dynamic_head').empty();
            $('#dynamic_field').empty();
            $('#dynamic_head').append('<tr><th width="35%">Training Title</th><th width="35%">Training Center</th><th width="25%">Date Taken</th><th width="5%">Action</th></tr>');
            $('#dynamic_field').append('<tr><td><input type="text" class="selector form-control capital" name="trainingTitle[]"></td><td><input type="text" class="selector form-control capital" name="trainingCenter[]"></td><td><div class="input-group date form_datetime selector"  data-date-format="MM dd, yyyy" data-link-field="dtp_input1"><input class="form-control" size="16" type="text" value="" readonly name="dateTaken[]"><span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span><span class="input-group-addon"><span class="glyphicon glyphicon-th selector"></span></span></div></td><td><button type="button" class="selector btn btn-success" onclick="clicks()" id="add"><span class="glyphicon glyphicon-plus"></span></button></td></tr>');
            $('.form_datetime').prop('enable');

            
            $(".form_datetime").datetimepicker({
                format: "MM dd, yyyy",
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                minView: 2,
                maxView: 4,
                forceParse: 0,
            });
            
        });
        function enrolleechange(){
            var checks = true;
            $.ajax({
                type:'get',
                url:'{!!URL::to('ajax-enrollee')!!}',
                data:{'studentNumber':$('#enrollee').val()},
                success:function(data){
                    if(data.length>0){
                        $('#civilStatus option:selected').removeAttr('selected');
                        $('#enrollee_id').val(''+data[0]['enrollee_id']+'');
                        $('#1firstName').attr('value',''+data[0]['firstName']+'');
                        $('#1lastName').attr('value',''+data[0]['lastName']+'');
                        $('#1middleName').attr('value',''+data[0]['middleName']+'');
                        if(''+data[0]['gender']+''== "M"){
                            $('#male').iCheck('check');
                        }
                        else{
                            $('#female').iCheck('check');
                        }
                        $("#civilStatus option[value="+data[0]['cstatus_id']+"]").attr("selected", true);
                        $('#1dob').val(''+data[0]['dob']+'');
                        $('#1dop').attr('value',''+data[0]['dop']+'');
                        $('#1street').attr('value',''+data[0]['street']+'');
                        $('#1barangay').attr('value',''+data[0]['barangay']+'');
                        $('#1city').attr('value',''+data[0]['city']+'');
                        $('#1contactI').attr('value',''+data[0]['contact']+'');
                        $('#1email').attr('value',''+data[0]['email']+'');
                        $('#1Ename').attr('value',''+data[0]['cname']+'');
                        $('#1Erel').attr('value',''+data[0]['crelationship']+'');
                        $('#1Econtact').attr('value',''+data[0]['ccontact']+'');
                        $('#1Eaddress').val(''+data[0]['caddress']+'');
                        $('#1EBattainment').attr('value',''+data[0]['attainment']+'');
                        $('#1EBschool').attr('value',''+data[0]['school']+'');
                        $('#1EBcourse').attr('value',''+data[0]['course']+'');
                        if(data[0]['seaxp'].length>0){
                            $('#years').attr('value',''+data[0]['seaxp'][0]['noYears']+'');
                            $('#rank').attr('value',''+data[0]['seaxp'][0]['rank']+'');
                        }
                        if(data[0]['tattend'].length>0){
                            $('#dynamic_head').empty();
                            $('#dynamic_field').empty();
                            $('#dynamic_head').append('<tr><th width="40%">Training Title</th><th width="40%">Training Center</th><th width="20%">Date Taken</th></tr>');
                            for(var a=0; a<data[0]['tattend'].length; a++){
                                $('#dynamic_field').append('<tr><td>'+data[0]['tattend'][a]['trainingTitle']+'</td><td>'+data[0]['tattend'][a]['trainingCenter']+'</td><td>'+data[0]['tattend'][a]['dateTaken']+'</td></tr>')
                            }
                        }
                        $('.form_datetime').prop('disable');
                        toastr.success("Student Information found");

                    }
                    else{
                        toastr.warning("This student number doesn't exist");
                        $('#enrollee_id').attr('value','');
                        $('#1firstName').attr('value','');
                        $('#1lastName').attr('value','');
                        $('#1middleName').attr('value','');
                        $('#male').iCheck('uncheck');
                        $('#female').iCheck('uncheck');
                        $('#civilStatus').attr('disabled',false);
                        $('#option1').attr('disabled',false);
                        $('#option1').attr('value','0');
                        $('#civilStatus option:selected').removeAttr('selected');
                        $("#civilStatus option[value='0']").attr("selected", "selected");
                        $('#civilStatus').attr('disabled',true);
                        $('#option1').attr('disabled',true);
                        $('#1dob').val('');
                        $('#1dop').attr('value','');
                        $('#1street').attr('value','');
                        $('#1barangay').attr('value','');
                        $('#1city').attr('value','');
                        $('#1contact').attr('value','');
                        $('#1email').attr('value','');
                        $('#1Ename').attr('value','');
                        $('#1Erel').attr('value','');
                        $('#1Econtact').attr('value','');
                        $('#1Eaddress').val('');
                        $('#1EBattainment').attr('value','');
                        $('#1EBschool').attr('value','');
                        $('#1EBcourse').attr('value','');
                        $('#dynamic_head').empty();
                        $('#dynamic_field').empty();
                        $('#dynamic_head').append('<tr><th width="35%">Training Title</th><th width="35%">Training Center</th><th width="20%">Date Taken</th><th width="10%">Action</th></tr>');
                        $('#dynamic_field').append('<tr><td><input type="text" class="selector form-control capital" name="trainingTitle[]"></td><td><input type="text" class="selector form-control capital" name="trainingCenter[]"></td><td><div class="input-group date form_datetime"  data-date-format="MM dd, yyyy" data-link-field="dtp_input1"><input class="form-control" size="16" type="text" value="" readonly name="dateTaken[]"><span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span><span class="input-group-addon"><span class="glyphicon glyphicon-th selector"></span></span></div></td><td><button type="button" class="selector btn btn-success" onclick="clicks()" id="add"><span class="glyphicon glyphicon-plus"></span></button></td></tr>');

                        $('.form_datetime').prop('disable');
                    }
                },
                error:function(){
                }
            });
        }
        $(function(){
            //Yes! use keydown 'cus some keys is fired only in this trigger,
            //such arrows keys
            $("body").keydown(function(e){
                 //well you need keep on mind that your browser use some keys 
                 //to call some function, so we'll prevent this

                 //now we caught the key code, yabadabadoo!!
                 var keyCode = e.keyCode || e.which;
                 //your keyCode contains the key code, F1 to F12 
                 //is among 112 and 123. Just it.
                 if(keyCode == 115){
                    {{session()->flash('sprogram_id',session('sprogram_id'))}};
                 }       
            });
        });
        jQuery(document).ready(function($) {

          if (window.history && window.history.pushState) {

            window.history.pushState('forward', './iEnroll');

            $(window).on('popstate', function() {
                {{session()->flash('sprogram_id',session('sprogram_id'))}};
                history.back();
            });

          }
        });
        </script>
        <script type="text/javascript">
            //panel hide
            $('.showhide').attr('title','Hide Panel content');      
            $(document).on('click', '.panel-heading .clickable', function(e){
            var $this = $(this);
            if(!$this.hasClass('panel-collapsed')) {
             $this.parents('.panel').find('.panel-body').slideUp();
             $this.addClass('panel-collapsed');
             $this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
             $('.showhide').attr('title','Show Panel content');
            } else {
             $this.parents('.panel').find('.panel-body').slideDown();
             $this.removeClass('panel-collapsed');
             $this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
             $('.showhide').attr('title','Hide Panel content');
            }
            });
        </script>
    
        <script type="text/javascript">
                var i = 1;
                function clicks(){
                    i++;
                    $('#dynamic_field').append('<tr id="row'+i+'"><td><div><input type="text" class="selector form-control capital training" name="trainingTitle[]" onblur="validateTraining(this)"></div></td><td><div><input type="text" class="selector form-control capital training" name="trainingCenter[]"  onblur="validateTraining(this)"></div></td><td><div class="input-group date form_datetime selector"  data-date-format="MM dd, yyyy" data-link-field="dtp_input1"><input class="form-control selector training" size="16" type="text" value="" readonly name="dateTaken[]" id="dateTaken" onchange="validateTraining(this)"><span class="input-group-addon"><span class="glyphicon glyphicon-remove selector"></span></span><span class="input-group-addon"><span class="glyphicon glyphicon-th selector"></span></span></div></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger remove"><span class="glyphicon glyphicon-remove"></span></button></td></tr>');
                    
                    $(document).on('click','.remove',function(){
                        var btn_id = $(this).attr('id');
                        $('#row'+btn_id+'').remove();
                    });

                    $(".form_datetime").datetimepicker({
                        format: "MM dd, yyyy",
                        weekStart: 1,
                        todayBtn:  1,
                        autoclose: 1,
                        todayHighlight: 1,
                        startView: 2,
                        minView: 2,
                        maxView: 4,
                        forceParse: 0,
                    });
                }
                
        	$(document).ready(function(){
        	  $('input').iCheck({
        	    checkboxClass: 'icheckbox_flat-blue',
        	    radioClass: 'iradio_flat-blue'
        	  });
        	});
        </script>

        <script type="text/javascript">
            function dobChanged(dob){
                // var age = moment(dob.value,"MMM D, YYYY").fromNow(true);
                // $('#age').val(age+' old');
                var bday=  moment(dob.value,"MMM D, YYYY");
                var today = moment();
                $('#age').val(today.diff(bday,"years"));
                $('#age').valid();
            }
        </script>

        <script type="text/javascript">
            
            function changeContactType(contactType){
                if(contactType.value == "tel"){
                     {{--  document.getElementById('contact').value = "";
                    $("#contact").removeClass("cp").addClass("tel").attr("placeholder":"e.g: 0999 9999 999");
                    console.log("tel");   --}}
                    $("#contactC").empty();
                    $("#contactC").append('<input type="text" id="1contactI" name="contact" class="tel form-control placeholder selector" placeholder="e.g: 999 9999">')
                    
                    
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
                    {{--  document.getElementById('contact').value = "";
                    $("#contact").removeClass("tel").addClass("cp").attr("placeholder":"e.g: 999 9999");
                    console.log("cp");  --}}
                    
                    $("#contactC").empty();
                    $("#contactC").append('<input type="text" id="1contactI" name="contact" class="cp form-control placeholder selector" placeholder="e.g: 0999 9999 999">')
                    
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
            function EchangeContactType(contactType){
                if(contactType.value == "tel"){
                     {{--  document.getElementById('Econtact').value = "";
                    $("#contact").removeClass("cp").addClass("tel").attr("placeholder":"e.g: 0999 9999 999");
                    console.log("tel");   --}}
                    $("#contactE").empty();
                    $("#contactE").append('<input type="text" id="1Econtact" name="Econtact" class="tel form-control placeholder selector" placeholder="e.g: 999 9999">')

                    
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
                    {{--  document.getElementById('contact').value = "";
                    $("#contact").removeClass("tel").addClass("cp").attr("placeholder":"e.g: 999 9999");
                    console.log("cp");  --}}
                    
                    $("#contactE").empty();
                    $("#contactE").append('<input type="text" id="1EContact" name="Econtact" class="cp form-control placeholder selector" placeholder="e.g: 0999 9999 999">')
                    
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
          $("#application").addClass(" active ");
        </script>

        <script type="text/javascript">
                $('.tel').mask('000 0000',
                {
                      "placeholder": "--- ----"
                });

                $('.cp').mask('0000 0000 000',
                {
                      "placeholder": "---- ---- ---"
                });
        </script>

        <script>

            jQuery(function ($){
                @foreach($tclass as $tclasses)
                $('#PP{{$tclasses["id"]}}').iCheck('check');
                $('#col{{$tclasses["id"]}}').append('<input id="mode{{$tclasses["id"]}}" type="hidden" name="paymentMode[]" value="'+$('#PP{{$tclasses["id"]}}').val()+'">');
                $('#PP{{$tclasses["id"]}}').on('ifChecked',function(){
                    $('#col{{$tclasses["id"]}}').append('<input id="mode{{$tclasses["id"]}}" type="hidden" name="paymentMode[]" value="'+$('#PP{{$tclasses["id"]}}').val()+'">');
                });
                $('#PP{{$tclasses["id"]}}').on('ifUnchecked',function(){
                    $('#mode{{$tclasses["id"]}}').remove();
                });
                $('#FP{{$tclasses["id"]}}').on('ifChecked',function(){
                    $('#col{{$tclasses["id"]}}').append('<input id="mode{{$tclasses["id"]}}" type="hidden" name="paymentMode[]" value="'+$('#FP{{$tclasses["id"]}}').val()+'">');
                });
                $('#FP{{$tclasses["id"]}}').on('ifUnchecked',function(){
                    $('#mode{{$tclasses["id"]}}').remove();
                });
                @endforeach
            });
        </script>

        <script type="text/javascript">
            $.validator.addMethod("regx", function(value, element, regexpr) {          
                return regexpr.test(value);
            }, "No special characters except(hypen ( - ))");

            $.validator.addMethod("regx1", function(value, element, regexpr) {          
                return regexpr.test(value);
            }, "No special characters except(hypen ( - ) and apostrophe ( ' ))");

            $.validator.addMethod("regx2", function(value, element, regexpr) {          
                return regexpr.test(value);
            }, "Allowed characters: ' - ( ) , : ; & / # ");

            $.validator.addMethod("regx3", function(value, element) {          
                return this.optional(element) || /(^[a-zA-Z0-9 \'\-\Ñ\ñ]+$)/i.test(value) || value == "";
            }, "Invalid Input");

            $.validator.addMethod("regx4", function(value, element) {          
                return this.optional(element) || ((/(^[0-9]+$)/i.test(value)) && (value.length == 7 || value.length == 11));
            }, "Invalid Input");

            $.validator.addMethod("adult", function(value, element) {          
            if(value>=18)
                return true;
            }, "Must be 18 years old and above");

            $(function(){
                $('#apply-form').validate({
                    ignore:[],
                    rules:{
                        firstName:{
                            required: true,
                            regx1: /(^[a-zA-Z0-9 -\'\Ñ\ñ]+$)/i,
                            space: true,
                        },
                        middleName:{
                            regx3: true,
                            space: true,
                        },
                        lastName:{
                            required: true,
                            regx1: /(^[a-zA-Z0-9 \'\-\Ñ\ñ]+$)/i,
                            space: true,
                        },
                        civilStatus:{
                            required: true
                        },
                        dob:{
                            required: true
                        },
                        age:{
                            adult: true
                        },
                        dop:{
                            required: true,
                            space: true,
                            regx2: /(^[a-zA-Z0-9 \'\-\Ñ\ñ\#\.\,();:/&]+$)/i,
                        },
                        street:{
                            required: true,
                            regx2: /(^[a-zA-Z0-9 \'\-\Ñ\ñ\#\.\,();:/&]+$)/i,
                            space: true,
                        },
                        barangay:{
                            required: true,
                            regx2: /(^[a-zA-Z0-9 \'\-\Ñ\ñ\#\.\,();:/&]+$)/i,
                            space: true,
                        },
                        city:{
                            required: true,
                            regx2: /(^[a-zA-Z0-9 \'\-\Ñ\ñ\#\.\,();:/&]+$)/i,
                            space: true,
                        },
                        contact:{
                            required: true
                        },
                        email:{
                            required: true
                        },
                        Ename:{
                            required: true,
                            regx1: /(^[a-zA-Z0-9 -\'\Ñ\ñ]+$)/i,
                            space: true,
                        },
                        Erel:{
                            required: true,
                            regx1: /(^[a-zA-Z0-9 -\'\Ñ\ñ]+$)/i,
                            space: true,
                        },
                        Econtact:{
                            required: true
                        },
                        Eaddress:{
                            required: true,
                            regx2: /(^[a-zA-Z0-9 \'\-\Ñ\ñ\#\.\,();:/&]+$)/i,
                            space: true,
                        },
                        EBattainment:{
                            required: true,
                            regx2: /(^[a-zA-Z0-9 \'\-\Ñ\ñ\#\.\,();:/&]+$)/i,
                            space: true,
                        },
                        EBschool:{
                            required: true,
                            regx2: /(^[a-zA-Z0-9 \'\-\Ñ\ñ\#\.\,();:/&]+$)/i,
                            space: true,
                        },
                        EBcourse:{
                            space: true,
                        },
                        noYears:{
                            number: true,
                            space: true
                        },
                        rank:{
                            space: true,
                        }
                    },
                    errorPlacement:function(error,element){
                        error.insertAfter(element.parent("div"));
                    },
                });
            });
        </script>
        <script type="text/javascript">
            function validateTraining(trainingField){

                var isNull= false;
                $(".training").each(function (index, element) { 
                    if($(this).val().trim() == ""){
                        isNull = true;
                        console.log(isNull);
                    }
                    else{
                        isNull = false;
                        console.log(isNull);
                        return false;
                    }
                });

                if(isNull){
                     $(".training").each(function (index, element) { 
                        $(this).rules('remove', 'required');
                    });
                }
                else{
                    $(".training").each(function (index, element) { 
                        $(this).rules('add', 'required');

                //$("#dateTaken").valid();
                    });
                }


                // var isNull= false;
                // var index=i;
                // while(index != 0){
                //     $('row'+index+'').each(function (){
                //         $(".training").each(function (index, element) { 
                //             if($(this).val().trim() == ""){
                //                 isNull = true;
                //                 console.log(isNull);
                //             }
                //             else{
                //                 isNull = false;
                //                 console.log(isNull);
                //                 return false;
                //             }
                //         });
                //     });
                //     index--;
                // }

                // // if(isNull){
                // //      $(".training").each(function (index, element) { 
                // //         $(this).rules('remove', 'required');
                // //     });
                // // }
                // // else{
                // //     $(".training").each(function (index, element) { 
                // //         $(this).rules('add', 'required');

                // // //$("#dateTaken").valid();
                // //     });
                // // }

                // if(isNull){
                //  index=i;
                //     while(index != 0){
                //     $('row'+index+'').each(function (){
                //         $(".training").each(function (index, element) { 
                //                 $(this).rules('remove', 'required');
                //         });
                //     });
                //     index--;
                //     }
                // }
                // else{
                //      index=i;
                //     while(index != 0){
                //     $('row'+index+'').each(function (){
                //         $(".training").each(function (index, element) { 
                //                 $(this).rules('add', 'required');
                //         });
                //     });
                //     index--;
                //     }
                // }
            }
        </script>
@endsection