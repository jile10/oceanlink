<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>
        @section('title')
            Oceanlink
        @show
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <!-- global css -->
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/clockface.css') }}">    
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/toastr.min.css') }}">
    
    <link href="/vendors/fonts/ionicons/ionicons.css" rel="stylesheet" />
    @yield("css")

    <!-- font Awesome -->
    <!-- end of global css -->
    <!--page level css-->
    <!--end of page level css-->
<body class="skin-josh">
<header class="header">
    <a href="#" class="logo">
        <img src="{{ asset('/images/logo.png') }}" style="margin-bottom: 30px;" alt="logo">
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <div>
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <div class="responsive_nav"></div>
            </a>
        </div>
        <div class="navbar-right" style="margin-right: 0.3%;">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu" >
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/display_image/{{Auth::user()->employee->image}}" width="35" class="img-circle img-responsive pull-left" height="35" alt="riot">
                        <div class="riot">
                            <div>
                                {{Auth::user()->employee->firstName. ' ' . Auth::user()->employee->middleName . ' ' . Auth::user()->employee->lastName}}
                                <span>
                                    <i class="caret"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header bg-light-blue">
                            <img src="/display_image/{{Auth::user()->employee->image}}" class="img-responsive img-circle" alt="User Image">
                            <p class="topprofiletext">{{Auth::user()->employee->firstName. ' ' . Auth::user()->employee->lastName}}</p>
                        </li>
                        <!-- Menu Body -->
                        <li>
                            <a href="/admin/accountsetting">
                                <i class="glyphicon glyphicon-cog"></i>
                                Account Setting
                            </a>
                        </li>
                        <li>
                            <a href="/logout">
                                <i class="glyphicon glyphicon-log-out"></i>
                                Log-out
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside id="left-side" class="left-side sidebar-offcanvas">
        <section class="sidebar ">
            <div class="page-sidebar  sidebar-nav">
                <!-- BEGIN SIDEBAR MENU -->
                @include('admin.layouts.left_menu')
                <!--@yield('left_menu')-->
                <!-- END SIDEBAR MENU -->
            </div>
        </section>
    </aside>
    <aside id="right-side" class="right-side">
        <!-- Notifications -->

                <!-- Content -->
        @yield('content')

    </aside>
    <!-- right-side -->
</div>
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top"
   data-toggle="tooltip" data-placement="left">
    <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
</a>
<!-- global js -->
<script src="/js/jquery.min.js" type="text/javascript"></script>
<script src="{{ asset('/assets/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/clockface.js') }}" type="text/javascript" ></script>
<script src="{{ asset('/js/toastr.min.js') }}"></script>
<script src="{{ asset('/js/jquery.validate.js') }}"></script>
<script src="{{ asset('/js/nowhitespace.js') }}"></script>
<script src="{{ asset('/js/pattern.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var height = parseInt($('#right-side').css('height'));
        if(height <=617){
            height = 450;
        }
        $('#left-side').css('height',height+'px');
    });
    $('#right-side').resize(function(){
        var height = parseInt($('#right-side').css('height'));
        if(height <=617){
            height = 450;
        }
        $('#left-side').css('height',height+'px');
    });
</script>
<!-- end of global js -->
<!-- begin page level js -->
@yield('footer_scripts')
        <!-- end page level js -->
@yield('js')
</body>
</html>

