<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Oceanlink Institute Inc.</title>
    <!--global css starts-->
    <link rel="stylesheet" type="text/css" href="/home/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/home/css/custom.css">
    <link href="{{ asset('/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <!--end of global css-->
    <!--page level css starts-->
    @yield("css")
    <!--end of page level css-->
</head>

<body>
    <!-- Header Start -->
    <header>
        <!-- Icon Section Start -->
        <div class="icon-section">
            <div class="container">
                <ul class="list-inline">
                    <li>
                        <a href="#"> <i class="livicon" data-name="facebook" data-size="18" data-loop="true" data-c="#fff" data-hc="#757b87"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#"> <i class="livicon" data-name="twitter" data-size="18" data-loop="true" data-c="#fff" data-hc="#757b87"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#"> <i class="livicon" data-name="google-plus" data-size="18" data-loop="true" data-c="#fff" data-hc="#757b87"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#"> <i class="livicon" data-name="linkedin" data-size="18" data-loop="true" data-c="#fff" data-hc="#757b87"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#"> <i class="livicon" data-name="rss" data-size="18" data-loop="true" data-c="#fff" data-hc="#757b87"></i>
                        </a>
                    </li>
                    <li class="pull-right">
                        <ul class="list-inline icon-position">
                            <li>
                                <a href="mailto:"><i class="livicon" data-name="mail" data-size="18" data-loop="true" data-c="#fff" data-hc="#fff"></i></a>
                                <label class="hidden-xs"><a href="mailto:" class="text-white">info@oceanlinkinstitute.com</a></label>
                            </li>
                            <li>
                                <a href="tel:"><i class="livicon" data-name="phone" data-size="18" data-loop="true" data-c="#fff" data-hc="#fff"></i></a>
                                <label class="hidden-xs"><a href="tel:"class="text-white">+63 (02) 353-5841</a></label>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- //Icon Section End -->
        <!-- Nav bar Start -->
        @include('home.layouts.nav')
        <!-- Nav bar End -->
    </header>
    <!-- //Header End -->
    <!--Carousel Start -->
    @yield("carousel")
    <!-- Container Start -->
    <!-- //Carousel End -->
    <!-- Container Start -->
    <div class="container">
        <!-- Service Section Start-->
    @yield("content")
        <!-- //Our Skills End -->
    </div>
    <!-- //Container End -->
    <!-- Footer Section Start -->
    <footer>
        <!-- Footer Container Start -->
        <div class="container footer-text">
            <!-- About Us Section Start -->
            <div class="col-sm-4">
                <h4>About Us</h4>
                <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                </p>
                <h4>Follow Us</h4>
                <ul class="list-inline">
                    <li>
                        <a href="#"> <i class="livicon" data-name="facebook" data-size="18" data-loop="true" data-c="#ccc" data-hc="#ccc"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#"> <i class="livicon" data-name="twitter" data-size="18" data-loop="true" data-c="#ccc" data-hc="#ccc"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#"> <i class="livicon" data-name="google-plus" data-size="18" data-loop="true" data-c="#ccc" data-hc="#ccc"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#"> <i class="livicon" data-name="linkedin" data-size="18" data-loop="true" data-c="#ccc" data-hc="#ccc"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- //About Us Section End-->
            <!-- Contact Section Start -->
            <div class="col-sm-4">
                <h4>Contact Us</h4>
                <ul class="list-unstyled">
                    <li>35,Lorem Lis Street, Park Ave</li>
                    <li>Lis Street, India.</li>
                    <li><i class="livicon icon4 icon3" data-name="cellphone" data-size="18" data-loop="true" data-c="#ccc" data-hc="#ccc"></i>Phone:9140 123 4588</li>
                    <li><i class="livicon icon4 icon3" data-name="printer" data-size="18" data-loop="true" data-c="#ccc" data-hc="#ccc"></i> Fax:400 423 1456</li>
                    <li><i class="livicon icon3" data-name="mail-alt" data-size="20" data-loop="true" data-c="#ccc" data-hc="#ccc"></i> Email:<span class="success">
                        <a href="mailto:">info@joshadmin.com</a></span>
                    </li>
                    <li><i class="livicon icon4 icon3" data-name="skype" data-size="18" data-loop="true" data-c="#ccc" data-hc="#ccc"></i> Skype:
                        <span class="success">Joshadmin</span>
                    </li>
                </ul>
                <div class="news">
                    <h4>News letter</h4>
                    <p>subscribe to our newsletter and stay up to date with the latest news and deals</p>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="yourmail@mail.com" aria-describedby="basic-addon2">
                        <a href="#" class="btn btn-primary text-white" role="button">Subscribe</a>
                    </div>
                </div>
            </div>
            <!-- //Contact Section End -->
            <!-- Recent post Section Start -->
            <div class="col-sm-4">
                <h4>Recent Posts</h4>
                <div class="media">
                    <div class="media-left media-top">
                        <a href="#">
                            <img class="media-object" src="images/image_14.jpg" alt="image">
                        </a>
                    </div>
                    <div class="media-body">
                        <p class="media-heading">Lorem Ipsum is simply dummy text of the printing and type setting industry dummy.
                            <br />
                            <div class="pull-right"><i>John Doe</i></div>
                        </p>
                    </div>
                </div>
                <div class="media">
                    <div class="media-left media-top">
                        <a href="#">
                            <img class="media-object" src="images/image_15.jpg" alt="image">
                        </a>
                    </div>
                    <div class="media-body">
                        <p class="media-heading">Lorem Ipsum is simply dummy text of the printing and type setting industry dummy.
                            <br />
                            <div class="pull-right"><i>John Doe</i></div>
                        </p>
                    </div>
                </div>
                <div class="media">
                    <div class="media-left media-top">
                        <a href="#">
                            <img class="media-object" src="images/image_13.jpg" alt="image">
                        </a>
                    </div>
                    <div class="media-body">
                        <p class="media-heading">Lorem Ipsum is simply dummy text of the printing and type setting industry dummy.
                            <br />
                            <div class="pull-right"><i>John Doe</i></div>
                        </p>
                    </div>
                </div>
                <div class="media">
                    <div class="media-left media-top">
                        <a href="#">
                            <img class="media-object" src="images/c1.jpg" alt="image">
                        </a>
                    </div>
                    <div class="media-body">
                        <p class="media-heading">Lorem Ipsum is simply dummy text of the printing and type setting industry dummy.
                            <br />
                            <div class="pull-right"><i>John Doe</i></div>
                        </p>
                    </div>
                </div>
            </div>
            <!-- //Recent Post Section End -->
        </div>
        <!-- Footer Container Section End -->
    </footer>
    <!-- //Footer Section End -->
    <!-- Copy right Section Start -->
    <div class="copyright">
        <div class="container">
            <p>Copyright &copy; All rights reserved 2017</p>
        </div>
    </div>
    <!-- Copy right Section End -->
    <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top" data-toggle="tooltip" data-placement="left">
        <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
    </a>
    <!--global js starts-->
    <script type="text/javascript" src="/home/js/jquery.min.js"></script>
    <script type="text/javascript" src="/home/js/bootstrap.min.js"></script>s
    <script type="text/javascript" src="/home/js/livicons-1.4.min.js"></script>
    <!--global js end-->
    <!-- page level js starts-->
    <script type="text/javascript" src="/home/js/jquery.circliful.js"></script>
    <script type="text/javascript" src="/home/vendors/owl-carousel/owl.carousel.js"></script>
    <script type="text/javascript" src="/home/js/carousel.js"></script>
    <!--page level js ends-->
    @yield("js")
</body>

</html>
