@extends('admin.layouts.default')

@section("css")
<link href="/vendors/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" />
<link href="/css/all.css?v=1.0.2" rel="stylesheet">
<link href="/css/flat/blue.css" rel="stylesheet">
<link href="/vendors/touchspin/dist/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css" media="all" />
<link href="/vendors/select2/select2.css" rel="stylesheet" />
<link rel="stylesheet" href="/vendors/select2/select2-bootstrap.css" />
@endsection
@section('content')
<style type="text/css">
    .buttons{
        margin-bottom: 20px;
        margin-right: 15px;
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <!--section starts-->
    <h1>Process Enrollment</h1>
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
            <a >Process Enrollment</a>
        </li>
        <li class="active">Single Application</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-success filterable" style="overflow:auto;">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="livicon" data-name="responsive" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
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
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active in" id="single">
                                <table class="table table-striped table-bordered" id="table1">
                                    <thead>
                                        <tr>
                                            <th width="25%">Class Name</th>
                                            <th width="30%">Program Name</th>
                                            <th width="15%">No. of Students</th>
                                            <th width="15%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tclass as $tclass)
                                            @if(count($tclass->groupapplicationdetail)==0)
                                            <tr>
                                                <td>{{$tclass->class_name}}</td>
                                                <td>{{$tclass->scheduledprogram->rate->program->programName}}</td>
                                                <td>{{count($tclass->classdetail->where('status','=',2)) + count($tclass->classdetail->where('status','=',3))}}</td>
                                                <td><a href="/manage_app/enrollee/view/{{$tclass->id}}" class="btn btn-success" > Select</a></td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="group">
                                <button class="buttons btn btn-success" data-toggle="modal" data-href="#responsive" href="#responsive"><i class="glyphicon glyphicon-plus"></i>&ensp;New Group Application</button>
                                <table class="table table-striped table-bordered" id="table1">
                                    <thead>
                                        <tr>
                                            <th width="20%">Organization Name</th>
                                            <th width="25%">Organization Address</th>
                                            <th width="15%">No. of Students</th>
                                            <th width="25%">Course Name</th>
                                            <th width="15%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($gtclass as $tclasses)
                                            @if(count($tclasses->groupapplicationdetail)>0)
                                                <tr>
                                                    <td>{{$tclasses->groupapplicationdetail->groupapplication->orgName}}</td>
                                                    <td>{{$tclasses->groupapplicationdetail->groupapplication->orgAddress}}</td>
                                                    <td>{{count($tclasses->groupclassdetail)}}</td>
                                                    <td>{{$tclasses->scheduledprogram->rate->program->programName . ' (' . $tclasses->scheduledprogram->rate->duration . ' Hours)'}}</td>
                                                    <td><a href="/manage_app/genrollee/view/{{$tclasses->id}}" class="btn btn-primary">View</a></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>                          
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!--Create Modal-->
<div class="modal fade in" id="responsive" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/manage_app/genrollee/insert" method="post" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">New Group Applicants</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary filterable" style="overflow:auto;">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><big>Set Program</big></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Choose desired program</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="rate_id" >
                                                @foreach($rate as $rates)
                                                <option value="{{$rates->id}}">{{$rates->program->programName . ' ('.$rates->duration.' Hours'}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Training Room</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="trainingroom_id" >
                                                @foreach($trainingroom as $trainingrooms)
                                                <option value="{{$trainingrooms->id}}">{{$trainingrooms->building->buildingName . ' ' . $trainingrooms->floor->floorName . ' room ' . $trainingrooms->room_no }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Training Officer</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="tofficer_id" >
                                                @foreach($tofficer as $tofficers)
                                                <option value="{{$tofficers->id}}">{{$tofficers->firstName . ' ' . $tofficers->middleName . ' ' . $tofficers->lastName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Program Start</label>
                                        <div class="col-sm-8">
                                            <div class="input-group date form_datetime"  data-date-format="MM dd, yyyy" data-link-field="dtp_input1">
                                                <input class="form-control" size="16" type="text" value="{{Carbon\Carbon::now()->format('F d, Y')}}" readonly name="dateStart" id="1dob">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-th"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Payment Method</label>
                                        <div class="col-sm-8">
                                            <label class="radio-inline"><input type="radio" name="paymentMode" id="PP" value="1">Partial Payment</label>
                                            <label class="radio-inline"><input type="radio" name="paymentMode" value="2">Full payment</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-primary filterable" style="overflow:auto;">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><big>Set Organization Information</big></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="col-md-3 col-md-offset-3">
                                            <label class="radio-inline"><input type="checkbox" name="past_data" id="past_data" value="">&ensp;Search for past data</label>
                                        </div>
                                            <input type="hidden" name="groupappplication_id" id="gapp" value="">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Choose Organization Name</label>
                                        <div class="col-md-6">
                                            <select onchange="dataChange()" name="org_id" id="org_data" class="form-control" disabled><option></option>@foreach($gapp as $gapps)<option value="{{$gapps->id}}">{{$gapps->orgName}}</option>@endforeach</select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Name</label>
                                        <div class="col-sm-6">
                                            <input type="text" id="org_name" name="orgName" class="enable form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Address</label>
                                        <div class="col-sm-6">
                                            <input type="text" id="org_address" name="orgAddress" class="form-control enable">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Representative</label>
                                        <div class="col-sm-6">
                                            <input type="text" id="org_representative" name="orgRepresentative" class="enable form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-primary filterable" style="overflow:auto;">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><big>Set Schedule</big></h3>
                                </div>
                                    <div style="margin-left: 2%; margin-top: 30px;">
                                        <input tabindex="13" type="checkbox" id="check">
                                        <label for="flat-checkbox-1">Date Range</label>
                                    </div>
                                <div class="panel-body table-responsive">
                                    <table class="table table-striped table-bordered" id="dynamic_table">
                                        <thead>
                                            <th width="30%">Day<font color="red">*</font></th>
                                            <th width="20%">Morning<font color="red">*</font></th>
                                            <th width="20%">Afternoon<font color="red">*</font></th>
                                            <th width="20%">Break Time</th>
                                            <th width="10%"></th>
                                        </thead>
                                        <tbody id="row">
                                            <tr >
                                                <td><select id="day1" onchange="days(1)" class="form-control" name="day[]">
                                                @foreach($day as $days)
                                                    <option value="{{$days->id}}">{{$days->dayName}}</option>
                                                @endforeach</select>
                                                </td>
                                                <td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="morning[]" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option>@endif @endfor @endfor</select></div></td>
                                                <td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="afternoon[]" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option>@endif @endfor @endfor</select></div></td>
                                                <td><select name="breaktime[]" class="form-control" >@for($a=1;$a<5;$a++)<option value="{{$a*15}}">{{$a*15}}</option>@endfor</select></td>
                                                <td><button type="button" onclick="clicks()" class="btn btn-primary"><i class="glyphicon glyphicon-plus" ></i></button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('js')
    <script src="/js/metisMenu.js" type="text/javascript"></script>
    <script src="/js/icheck.js" type="text/javascript"></script>
    <script src="/vendors/iCheck/icheck.js" type="text/javascript"></script>
    <script src="/js/custom.js"></script>
    <script src="/vendors/touchspin/dist/jquery.bootstrap-touchspin.js"></script>
    <script type="text/javascript" src="/vendors/datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script src="/vendors/select2/select2.js" type="text/javascript"></script>
    <script type="text/javascript">
        $('#org_data').select2({
            placeholder: "Select past data",
        });
    </script>
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
        $(document).ready( function(){
            $('#PP').iCheck('check');
        });
        $('#past_data').on('ifChecked',function(){
            $('#org_data').attr("disabled",false);
            $('.enable').attr('disabled',true);
            $('.enable').val("");

        });
        $('#past_data').on('ifUnchecked',function(){
            $('#org_data').select2("val","");
            $("#org_data option[value='0']").attr("disabled", true);
            $('#org_data').attr("disabled",true);
            $('.enable').attr('disabled',false);
            $('#org_data').attr('selected','0');
            $('.enable').val("");
        });
        function dataChange(){
            console.log($('#org_data').val());
            $.ajax({
                type:'get',
                url:'{!!URL::to('ajax-getOrg')!!}',
                data:{'group_id':$('#org_data').val()},
                success:function(data){
                        $('#org_name').val(''+data.orgName+'');
                        $('#org_address').val(''+data.orgAddress+'');
                        $('#org_representative').val(''+data.orgRepresentative+'');
                },
                error:function(){
                    console.log('error');
                },
            });
        }
    </script>
<script>
    $(document).ready( function(){
        var table = $('#table1').DataTable();
        var i = 1;
        $('#add').click(function(){
            i++;
            $('#dynamic_field').append('<tr id="row'+i+'"><td><select name="day_id[]" class="form-control">@foreach($day as $days)<option value="{{$days->id}}">{{$days->dayName}}</option>@endforeach</select></td><td><input data-format="hh:mm A" class="form-control sel-time-am" type="text" name="start[]"></td><td><input data-format="hh:mm A" class="form-control sel-time-am" type="text" name="end[]"></td><td>Break Time</td><td><input data-format="hh:mm A" class="form-control sel-time-am" type="text" name="breakStart[]"></td><td><input data-format="hh:mm A" class="form-control sel-time-am" type="text" name="breakEnd[]"></td><td><button name="remove" type="button" id="'+i+'" class="btn btn-danger remove" >X</button></td></tr>');

        $('.sel-time-am').clockface();
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
<script>
    $(document).ready(function(){
      $('input').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
      });
    });
    function days(id){
        console.log($("#day"+id).val());
    }
    $('#check').on('ifChecked', function(event){
        $("#dynamic_table").empty();
        $("#dynamic_table").append('<thead><th width="20%">From<font color="red">*</font</th><th width="20%">To</th><th width="20%">Start<font color="red">*</font</th><th width="20%">End<font color="red">*</font</th><th width="20">Break Time</th></thead><tbody><tr><td><select class="form-control" name="start">@foreach($day as $days)<option value="{{$days->id}}">{{$days->dayName}}</option>@endforeach</select></td><td><select class="form-control" name="end">@foreach($day as $days)@if($days->dayName == "Tuesday") <option selected value="{{$days->id}}">{{$days->dayName}}</option> @else <option value="{{$days->id}}">{{$days->dayName}}</option> @endif @endforeach</select></td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="morning" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option>@endif @endfor @endfor</select></div></td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="afternoon" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option>@endif @endfor @endfor</select></div></td><td><select name="breaktime" class="form-control" >@for($a=1;$a<5;$a++)<option value="{{$a*15}}">{{$a*15}}</option>@endfor</select></td></tr></tbody>');
        $("input[name='demo_vertical']").TouchSpin({
            initval: 00,
            min: 0,
            max: 59,
            step: 15,
          verticalbuttons: true,
        });
    });
    $('#check').on('ifUnchecked', function(event){
        $("#dynamic_table").empty();
        $("#dynamic_table").append('<thead><th width="30%">Day<font color="red">*</font</th><th width="20%">Morning<font color="red">*</font</th><th width="20%">Afternoon<font color="red">*</font</th></th><th width="20">Break Time</th><th width="10%"></thead><tbody id="row"><tr><td><select class="form-control" name="day[]">@foreach($day as $days)<option value="{{$days->id}}">{{$days->dayName}}</option>@endforeach</td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="morning[]" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option> @endif @endfor @endfor</select></div></td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="afternoon[]" class="form-control" >@for($i=8;$i<18;$i++)@for($a=0;$a<4;$a++)@if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option>@endif @endfor @endfor</select></div></td><td><select name="breaktime" class="form-control" >@for($a=1;$a<5;$a++)<option value="{{$a*15}}">{{$a*15}}</option>@endfor</select></td><td><button type="button" onclick="clicks()" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i></button></td></tr></tbody>');
    });
    var i=1;
    function clicks(){
        $("#row").append('<tr id="row'+i+'"><td><select class="form-control" name="day[]">@foreach($day as $days)<option value="{{$days->id}}">{{$days->dayName}}</option>@endforeach</td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="morning[]" class="form-control" >@for($i=8; $i<18;$i++)@for($a=0;$a<4;$a++)@if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option> @endif @endfor @endfor</select></div></td><td><div class="operationTime input-group"><span class="input-group-addon"><i class="fa fa-sun-o"></i></span><select name="afternoon[]" class="form-control" >@for($i=8;$i<18;$i++)@for($a=0;$a<4;$a++)@if($a*15 == 0)<option value="{{$i}}:00">{{$i}}:00</option>@else<option value="{{$i}}:{{$a*15}}">{{$i}}:{{$a*15}}</option>@endif @endfor @endfor</select></div></td><td><select name="breaktime[]" class="form-control" >@for($a=1;$a<5;$a++)<option value="{{$a*15}}">{{$a*15}}</option>@endfor</select></td><td><button type="button" onclick="removes('+i+')" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></button></td></tr>');
    }
    function removes(id){
        $("#row"+id).remove();
        i--;
    }
</script>
<script>
    $(document).ready( function(){
        var table = $('#table1').DataTable();
    });
    $("#transaction").last().addClass( "active" );
    $("#manage_app").last().addClass( "active" );
    $("#individual_app").last().addClass( "active" );
</script>
@endsection