@extends('home.layouts.master2')
@section('css')
    <link href="/vendors/fonts/ionicons/ionicons.css" rel="stylesheet" />
    <link href="{{ asset('/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="/css/all.css?v=1.0.2" rel="stylesheet">
    <link href="/css/flat/blue.css" rel="stylesheet">
    <link href="/css/table.css" rel="stylesheet">
    <link href="vendors/touchspin/dist/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/toastr.min.css') }}">
@endsection

@section('content')

	<style>
		.badge-danger{
        background-color: #D89796!important;
    }
    .rowColor{
        background-color: #D89796!important;
        color: white;
    }

	</style>
	
	<section class="content">
  <!--main content-->
		<div class="row" >
  		<div class="col-md-12">
        <!--main content-->
        <div class="row">
          <div class="col-md-12">
          	<div class="col-md-12">
	            <div class="panel panel-primary" style="margin-top: 0px;">
                <div class="panel-heading">
                  <h3 class="panel-title">
                    <i class="livicon" data-name="user" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>Register to a Course
                  </h3>
                </div>
                <div class="panel-body">

                  <center><h2>Select Desired Program</h2></center>

                  <div class="pull-right col-md-3">
                    <fieldset>
                    	<legend>Legend</legend>
                    	<span class="badge badge-danger">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;Conflict in Schedule
                    </fieldset>
                  </div>
                  <form id="form-table" action="/next" method="get">
                    {{csrf_token()}}
	                  <div class="col-md-12 table-responded" style="margin-top: 50px;">
	                    <table class="striped bordered" id="table1">
	                      <thead>
	                        <tr>
	                          <th width="5%"></th>
	                          <th width="15%">Program Type</th>
	                          <th width="20%">Course</th>
	                          <th width="15%">Date Start</th>
	                          <th width="15%">Date end</th>
	                          <th width="20%">Schedule</th>
	                          <th width="10%" style="text-align:right;">Fee &ensp;(Php)</th>
	                        </tr>
	                      </thead>
	                      <tbody>
	                        @foreach($tclass as $tclasses)
	                        <tr id="row{{$tclasses['id']}}">
	                          <td style="text-align: center"><input onclick="checks({{$tclasses['id']}})" id="{{$tclasses['id']}}" type="checkbox"></td>
	                          <td>{{$tclasses['type']}}</td>
	                          <td>{{$tclasses['course_name']}}</td>
	                          <td>{{$tclasses['dateStart']}}</td>
	                          <td>{{$tclasses['dateEnd']}}</td>
	                          <td>@if(count($tclasses['sched'])>1)
	                          @foreach($tclasses['sched'] as $scheds)
	                              {{$scheds['scheds']}}</br>
	                          @endforeach
	                          @else
	                              {{$tclasses['sched']}}
	                          @endif
	                          </td>
	                          <td style="text-align:right;">{{number_format($tclasses['fee'],2)}}</td>
	                        </tr>
	                        @endforeach
	                      </tbody>
	                    </table>
	                    <div id="programCounter">
	                    </div>
	                    <button type="submit" class="btn btn-info col-md-4 pull-right">Proceed</button>
	                  </div>
                  </form>
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
  <script src="/js/jquery.min.js" type="text/javascript"></script>
  <script src="{{ asset('/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
   <script src="js/icheck.js" type="text/javascript"></script>
	<script src="/vendors/iCheck/icheck.js" type="text/javascript"></script>
    <script type="text/javascript" src="/home/js/jquery.validate.min.js"></script>
  <script src="/js/toastr.min.js"></script>
	<script src="/js/moment.min.js"></script>
  <script type="text/javascript">

  	$(document).ready(function(){
		  $('input').iCheck({
		    checkboxClass: 'icheckbox_flat-blue',
		    radioClass: 'iradio_flat-blue'
		  });
      @if(count(session('message_exist'))>0)
        toastr.error("{{session('message_exist')}}");
      @endif
		});
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
    $('#table1').DataTable();
	</script>
	<script type="text/javascript">
  $(document).ready(function() {
    @if(Session::has('message'))
      toastr.error("{{session('message')}}");
    @endif
  });
	var x = 0;
        $('input').on('ifChecked', function(event){
        	x++;
        	$('#programCounter').append('<input type="hidden" name="id[]" id="remove'+this.id+'" value="'+this.id+'" />')
            @foreach($tclass as $tclasses)
                if({{$tclasses['id']}} == this.id)
                {
                    var dateStart = new Date({{Carbon\Carbon::parse($tclasses['dateStart'])->format('Y-m-d')}});
                    var dateEnd = Date.parse({{Carbon\Carbon::parse($tclasses['dateEnd'])->format('Y-m-d')}});
                    @foreach($tclass as $classes)
                        if({{$tclasses['id']}}!={{$classes['id']}}){
                            if(moment("{{Carbon\Carbon::parse($tclasses['dateStart'])->format('Y-m-d')}}").isBetween(moment("{{Carbon\Carbon::parse($classes['dateStart'])->format('Y-m-d')}}").subtract(1,'days'),moment("{{Carbon\Carbon::parse($classes['dateEnd'])->format('Y-m-d')}}").add(1,'days')) || moment("{{Carbon\Carbon::parse($tclasses['dateEnd'])->format('Y-m-d')}}").isBetween(moment("{{Carbon\Carbon::parse($classes['dateStart'])->format('Y-m-d')}}").subtract(1,'days'),moment("{{Carbon\Carbon::parse($classes['dateEnd'])->format('Y-m-d')}}").add(1,'days')) || moment("{{Carbon\Carbon::parse($classes['dateStart'])->format('Y-m-d')}}").isBetween(moment("{{Carbon\Carbon::parse($tclasses['dateStart'])->format('Y-m-d')}}").subtract(1,'days'),moment("{{Carbon\Carbon::parse($tclasses['dateEnd'])->format('Y-m-d')}}").add(1,'days')) || moment("{{Carbon\Carbon::parse($classes['dateEnd'])->format('Y-m-d')}}").isBetween(moment("{{Carbon\Carbon::parse($tclasses['dateStart'])->format('Y-m-d')}}").subtract(1,'days'),moment("{{Carbon\Carbon::parse($tclasses['dateEnd'])->format('Y-m-d')}}").add(1,'days')))
                            {
                              @foreach($classes['sdetail'] as $details)
                                    @foreach($tclasses['sdetail'] as $sdetails)
                                        if( {{$details->day_id}} == {{$sdetails->day_id}})
                                        {
                                            @if(Carbon\Carbon::parse($sdetails->start)->gte(Carbon\Carbon::parse($details->start)) || Carbon\Carbon::parse($sdetails->start)->lte(Carbon\Carbon::parse($details->end)) || Carbon\Carbon::parse($sdetails->end)->gte(Carbon\Carbon::parse($details->start)) || Carbon\Carbon::parse($sdetails->end)->lte(Carbon\Carbon::parse($details->end)))
                                                $('#'+{{$classes['id']}}).iCheck('uncheck');
                                                $('#'+{{$classes['id']}}).iCheck('disable');
                                                $('#row'+{{$classes['id']}}).addClass( 'rowColor' );
                                            @endif
                                        }
                                    @endforeach
                                @endforeach
                            }
                        }
                    @endforeach
                }
            @endforeach
        });
        $('input').on('ifUnchecked', function(event){
        	x--;
        	$('#remove'+this.id).remove();
            @foreach($tclass as $tclasses)
                if({{$tclasses['id']}} == this.id)
                {
                    var dateStart = Date.parse({{Carbon\Carbon::parse($tclasses['dateStart'])->format('Y-m-d')}});
                    var dateEnd = Date.parse({{Carbon\Carbon::parse($tclasses['dateEnd'])->format('Y-m-d')}});
                    @foreach($tclass as $classes)
                        if({{$tclasses['id']}}!={{$classes['id']}}){
                            if(moment("{{Carbon\Carbon::parse($tclasses['dateStart'])->format('Y-m-d')}}").isBetween(moment("{{Carbon\Carbon::parse($classes['dateStart'])->format('Y-m-d')}}").subtract(1,'days'),moment("{{Carbon\Carbon::parse($classes['dateEnd'])->format('Y-m-d')}}").add(1,'days')) || moment("{{Carbon\Carbon::parse($tclasses['dateEnd'])->format('Y-m-d')}}").isBetween(moment("{{Carbon\Carbon::parse($classes['dateStart'])->format('Y-m-d')}}").subtract(1,'days'),moment("{{Carbon\Carbon::parse($classes['dateEnd'])->format('Y-m-d')}}").add(1,'days')) || moment("{{Carbon\Carbon::parse($classes['dateStart'])->format('Y-m-d')}}").isBetween(moment("{{Carbon\Carbon::parse($tclasses['dateStart'])->format('Y-m-d')}}").subtract(1,'days'),moment("{{Carbon\Carbon::parse($tclasses['dateEnd'])->format('Y-m-d')}}").add(1,'days')) || moment("{{Carbon\Carbon::parse($classes['dateEnd'])->format('Y-m-d')}}").isBetween(moment("{{Carbon\Carbon::parse($tclasses['dateStart'])->format('Y-m-d')}}").subtract(1,'days'),moment("{{Carbon\Carbon::parse($tclasses['dateEnd'])->format('Y-m-d')}}").add(1,'days')))
                            {
                                @foreach($classes['sdetail'] as $details)
                                    @foreach($tclasses['sdetail'] as $sdetails)
                                        if( {{$details->day_id}} == {{$sdetails->day_id}})
                                        {
                                            @if((Carbon\Carbon::parse($sdetails->start)->gte(Carbon\Carbon::parse($details->start)) || Carbon\Carbon::parse($sdetails->start)->lte(Carbon\Carbon::parse($details->end))) && (Carbon\Carbon::parse($sdetails->end)->gte(Carbon\Carbon::parse($details->start)) || Carbon\Carbon::parse($sdetails->end)->lte(Carbon\Carbon::parse($details->end))))
                                                $('#'+{{$classes['id']}}).iCheck('enable');
                                                $('#row'+{{$classes['id']}}).removeClass( 'rowColor' );
                                            @endif
                                        }
                                    @endforeach
                                @endforeach
                            }
                        }
                    @endforeach
                }
            @endforeach
        });
        $( "#form-table" ).submit(function(e) {
						if(x==0){
				  		e.preventDefault();
				  		toastr.error("Please choose a course");
						}
				});
    </script>
    <!-- <script type="text/javascript">
    	jQuery(document).ready(function(){
	    		if (window.history && window.history.pushState) {

            window.history.pushState('forward', './registercourse');

            $(window).on('popstate', function() {
            	history.back();
            });

          }
    	});
    </script> -->
@endsection