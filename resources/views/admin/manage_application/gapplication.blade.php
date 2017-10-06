@extends('admin.layouts.default')

@section('css')
<link href="/vendors/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" />
<link href="/vendors/panel/panel.css" rel="stylesheet" type="text/css"/>
<link href="/css/all.css?v=1.0.2" rel="stylesheet">
<link href="/css/flat/blue.css" rel="stylesheet">
<link href="/vendors/touchspin/dist/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css" media="all" />
<link href="/vendors/select2/select2.css" rel="stylesheet" />
<link rel="stylesheet" href="/vendors/select2/select2-bootstrap.css" />
@endsection
@section('content')

<style type="text/css">
    .capital{
        text-transform: capitalize;
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
	<!--section starts-->
	<h1>Application</h1>
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
            <a >Manage Application</a>
        </li>
        <li>
            <a href="/manage_app/genrollee">Group Application</a>
        </li>
		<li class="active">New Application</li>
	</ol>
</section>
<section class="content-body">
<div class="row">
    <form action="/manage_app/genrollee/application/insert" method="post">
        {{csrf_field()}}
        <input type="hidden" name="groupapplication_id" value="{{$groupapplication_id}}">
        <div class="form-horizontal">
            <div class="form-group">
                <div class="col-sm-3">
                    <label class="radio-inline control-label">
                        <input type="checkbox" id="student" name="">&ensp;Already a student
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="e1" class="control-label col-sm-2">
                    Choose Student
                </label>
                <div class="col-sm-4">
                    <select id="e1" name="groupenrollee_id" onchange="selectChange()" disabled tabindex="-1" class="form-control select2">
                        <option id="opt1"></option>
                        @foreach($student as $students)
                            <option value="{{$students->groupenrollee->id}}">{{$students->groupenrollee->firstName . ' ' . $students->groupenrollee->middleName . ' ' . $students->groupenrollee->lastName}}</option>
                        @endforeach
                    </select>
                </div>
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
                                <input class="form-control" size="16" type="text" value="" readonly name="dob" id="1dob">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </span>
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
                        <div class="col-md-8">
                            <div class="form-group">
                                <div id="contactC" class="input-group">
                                    <span class="input-group-addon">Contact<font color="red">*</font></span>
                                    <input type="text" id="1contactI" name="contact" class="cp form-control placeholder selector" placeholder="e.g: 0999 9999 999">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select name="contactType" id="contactType" class="selector form-control" onchange="changeContactType(this)">
                                <option selected value="mobile">Mobile No.</option>
                                <option value="tel">Landline No.</option>
                            </select>
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
                                    <span class="input-group-addon">Course<font color="red">*</font></span>
                                    <input type="text" id="1EBcourse" class="selector form-control capital" name="EBcourse">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- EMERGENCY CONTACT -->
        <div class="col-md-8">
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
                        <div class="form-group">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div id="contactE" class="input-group">
                                        <span class="input-group-addon">Contact<font color="red">*</font></span>
                                        <input type="text" id="1Econtact" class="selector cp form-control placeholder" name="Econtact" placeholder="e.g: 0999 9999 999">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select name="EContactType" id="1EContactType" class="selector form-control" onchange="EchangeContactType(this)">
                                    <option selected value="mobile">Mobile No.</option>
                                    <option value="tel">Landline No.</option>
                                </select>
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
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-block btn-lg btn-info pull-right">Submit</button>
            </div>
        </div>
    </form>
</div>
</section>
@endsection
@section('js')

    <script type="text/javascript" src="/home/js/jquery.validate.min.js"></script>
    <script src="/vendors/select2/select2.js" type="text/javascript"></script>
    <!-- datetimepicker-->
    <script type="text/javascript" src="/vendors/datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <!-- InputMask -->
    <script src="/vendors/input-mask/jquerymask.js" type="text/javascript"></script>
    <script src="/js/icheck.js" type="text/javascript"></script>
    <script src="/vendors/iCheck/icheck.js" type="text/javascript"></script>
    <script src="/vendors/touchspin/dist/jquery.bootstrap-touchspin.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        //select
        $('#e1').select2({
            placeholder: "Select a student",
            allowClear:true
        });

        var i = 1;
        $('#add').click(function(){
            i++;
            $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" class="form-control" name="trainingTitle[]"></td><td><input type="text"class="form-control" name="trainingCenter[]"></td><td><input type="date" class="form-control" name="dateTaken[]"></td><td><button name="remove" type="button" id="'+i+'" class="btn btn-danger remove" >X</button></td></tr>');
        });
        $(document).on('click','.remove',function(){
            var btn_id = $(this).attr('id');
            $('#row'+btn_id+'').remove();
        });
    });
    $('.sel-time-am').clockface();
    $("#transaction").last().addClass( "active" );
    $("#manage_app").last().addClass( "active" );
    $("#group_app").last().addClass( "active" );
</script>
<script type="text/javascript">
    //student
    $('#student').on('ifChecked',function(){
        $('#e1').attr('disabled',false);
        $('#civilStatus').attr('disabled',false);
        $('#option1').attr('disabled',false);
        $('#option1').attr('value','0');
        $('#civilStatus option:selected').removeAttr('selected');
        $("#civilStatus option[value='0']").attr("selected", "selected");
        $('#option1').attr('disabled',true);
        $('.selector').attr('disabled',true);
        $('#male').iCheck('uncheck');
        $('#female').iCheck('uncheck');
    });
    $('#student').on('ifUnchecked',function(){
        $('#e1').select2("val",'');
        $('#e1').attr('disabled',true);
        $('.selector').attr('disabled',false);
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
    });

    function selectChange(){
        var checks = true;
            $.ajax({
                type:'get',
                url:'{!!URL::to('ajax-groupenrollee')!!}',
                data:{'groupenrollee_id':$('#e1').val()},
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
                    }
                    else{
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
                    }
                },
                error:function(){
                }
            });
    }
</script>
<script type="text/javascript">
$(document).ready(function(){
    $('input').iCheck({
    checkboxClass: 'icheckbox_flat-blue',
    radioClass: 'iradio_flat-blue'
    });
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
</script>
<script type="text/javascript">
function EchangeContactType(contactType){
    if(contactType.value == "tel"){
         {{--  document.getElementById('Econtact').value = "";
        $("#contact").removeClass("cp").addClass("tel").attr("placeholder":"e.g: 0999 9999 999");
        console.log("tel");   --}}
        $("#contactE").empty();
        $("#contactE").append('<span class="input-group-addon">Contact<font color="red">*</font></span><input type="text" id="contactE" class="tel form-control placeholder" placeholder="e.g: 999 9999">')
        
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
        $("#contactE").append('<span class="input-group-addon">Contact<font color="red">*</font></span><input type="text" id="contactE" class="cp form-control placeholder" placeholder="e.g: 0999 9999 999">')
        
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

$('.tel').mask('000 0000',
{
      "placeholder": "--- ----"
});

$('.cp').mask('0000 0000 000',
{
      "placeholder": "---- ---- ---"
});
</script>
@endsection