<!DOCTYPE html>
<html>
<head>
    <title>Oceanlink</title> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- global level css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <!-- end of global level css -->
    <!-- page level css -->
    <link href="assets/css/pages/login2.css" rel="stylesheet" />
    <link href="assets/vendors/iCheck/skins/minimal/blue.css" rel="stylesheet" />
    <!-- styles of the page ends-->

    <style type="text/css">
    body{
        background-image: url(/images/header-bg4.png);
        background-size: cover;
        background-repeat: no-repeat;
    }
    .container{
        position: relative;
        height: 47.3em;
    }
    #login{
        position: relative;
        top: 50.5%;
        left:50%;
        transform: translate(-50%,-50%);
        width: 30%;
        background: rgba(220,220,220, 0.5);
        margin-bottom: 20px;
        border: 1px solid #e3e3e3;
        border-radius: 10px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
    }
    img{
        width: 60%;
        margin-top: 40px;
        margin-bottom: 40px;

    }
    form{
        padding: 40px;
    }
    button {
        background-color: transparent;
        color: inherit;
        transition: all .5s;
        margin-top: 50px;
    }

</style>
</head>

<body >
    <div class="container">
      <div class="panel panel-default" id="login">
        <div class="panel-body">
            <center><img src="/images/oceanlogo.png"></center>
            <center><h2><font color="white">Login</font></h2></center>
            <form action="/login/prelogin" method="post">
                {{csrf_field()}}
                <fieldset>
                    <div class="form-group input-group">
                        <div class="input-group-addon">
                            <i class="livicon" data-name="at" data-size="18" data-c="#000" data-hc="#000" data-loop="true"></i>
                        </div>
                        <input class="form-control" placeholder="E-mail" name="email" type="text" />
                    </div>
                    <div class="form-group input-group">
                        <div class="input-group-addon">
                            <i class="livicon" data-name="key" data-size="18" data-c="#000" data-hc="#000" data-loop="true"></i>
                        </div>
                        <input class="form-control" placeholder="Password" name="password" type="password" value="" />
                    </div>
                    <div class="form-group">
                    </div>
                    <button type="submit" class="btn btn-block btn-primary btn-lg" ><font size="4px;">LOGIN</font></button>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<!-- global js -->
<script src="assets/js/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<!--livicons-->
<script src="assets/js/raphael-min.js" type="text/javascript"></script>
<script src="assets/js/livicons-1.4.min.js" type="text/javascript"></script>
<!-- end of global js -->
<!-- begining of page level js-->
<script src="/assets/js/TweenLite.min.js"></script>
<script src="assets/vendors/iCheck/icheck.js" type="text/javascript"></script>
<!-- end of page level js-->
</body>
</html>