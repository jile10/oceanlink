@extends('admin.layouts.default')
@section("css")
    <link href="/vendors/fonts/ionicons/ionicons.css" rel="stylesheet" />
    <link href="/vendors/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="{{ asset('/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Color Panel -->
    <link href="/vendors/panel/panel.css" rel="stylesheet" type="text/css"/>
    <link href="/css/all.css?v=1.0.2" rel="stylesheet">
    <link href="/css/flat/blue.css" rel="stylesheet">
    <link href="vendors/touchspin/dist/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css" media="all" /></
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
	.buttons{
		margin-bottom: 20px;
		margin-right: 15px;
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
<!-- Content Header (Page header) -->
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
			<div class="row">
				<div class="col-md-12">
					<h1 class="text-center">Company Information Form</h1>
					<br>
					<!-- BEGIN FORM WIZARD WITH VALIDATION -->
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
                                                <span class="input-group-addon">Company Name<font color="red">*</font></span>
                                                <input id="firstName" type="text" class="form-control capital" name="firstName">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">Last Name<font color="red">*</font></span>
                                                <input id="lastName" type="text" class="form-control capital" name="lastName">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">Birthplace<font color="red">*</font></span>
                                                <input type="text" class="form-control" name="pob">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    </div>

                  
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-info pull-right">Submit</button>
                        </div>
                    </div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('js')
    <script type="text/javascript" src="/home/js/jquery.validate.min.js"></script>
    <!-- datetimepicker-->
    <script type="text/javascript" src="/vendors/datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <!-- InputMask -->
    <script src="/vendors/input-mask/jquerymask.js" type="text/javascript"></script>
    <script src="/js/icheck.js" type="text/javascript"></script>
	<script src="/vendors/iCheck/icheck.js" type="text/javascript"></script>
    <script src="/vendors/touchspin/dist/jquery.bootstrap-touchspin.js"></script>
    <script src="{{ asset('/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script></

</script>

<script type="text/javascript">
    $('#table1').DataTable();
</script>
    
<script type="text/javascript">
        var i = 1;
        function clicks(){
            i++;
            $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" class="form-control" name="trainingTitle[]"></td><td><input type="text"class="form-control" name="trainingCenter[]"></td><td><input type="date" class="form-control" name="dateTaken[]"></td><td><button name="remove" type="button" id="'+i+'" class="btn btn-danger remove" >X</button></td></tr>');
            
            $(document).on('click','.remove',function(){
                var btn_id = $(this).attr('id');
                $('#row'+btn_id+'').remove();
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
    
    function changeContactType(contactType){
        if(contactType.value == "tel"){
             {{--  document.getElementById('contact').value = "";
            $("#contact").removeClass("cp").addClass("tel").attr("placeholder":"e.g: 0999 9999 999");
            console.log("tel");   --}}
            $("#contactC").empty();
            $("#contactC").append('<span class="input-group-addon">Contact<font color="red">*</font></span><input type="text" id="contact" class="tel form-control placeholder" placeholder="e.g: 999 9999">')
            
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
            $("#contactC").append('<span class="input-group-addon">Contact<font color="red">*</font></span><input type="text" id="contact" class="cp form-control placeholder" placeholder="e.g: 0999 9999 999">')
            
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

</script>

<script type="text/javascript">
  $("#application").addClass(" active ");
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
    $(function(){
        $('#traineeInfoForm').validate({
            rules:{
                firstName:{
                    required: true
                },
                lastName:{
                    required: true
                },
                gender:{
                    required: true
                },
                civilStatus:{
                    required: true
                },
                dob:{
                    required: true
                },
                pob:{
                    required: true
                },
                street:{
                    required: true
                },
                barangay:{
                    required: true
                },
                city:{
                    required: true
                },
                contact:{
                    required: true
                },
                email:{
                    required: true
                },
                Ename:{
                    required: true
                },
                Econtact:{
                    required: true
                },
                Erel:{
                    required: true
                },
                Eemail:{
                    required: true
                },
                EBattainment:{
                    required: true
                },
                EBcourse:{
                    required: true
                },
                EBschool:{
                    required: true
                }
            },
            errorPlacement: function(error,element){
                error.insertAfter(element.parent("div"));
            }
            
        });
    });
</script>
@endsection