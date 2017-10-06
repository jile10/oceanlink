@extends("home.layouts.master2")
@section("css")
<link rel="stylesheet" type="text/css" href="/home/vendors/font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="/home/css/portfolio.css">
<link rel="stylesheet" type="text/css" href="/home/vendors/fancybox/source/jquery.fancybox.css">
<link rel="stylesheet" type="text/css" href="/home/vendors/fancybox/source/helpers/jquery.fancybox-buttons.css">
@endsection
@section("content")
<!-- Images Section Start -->
<div class="col-md-12">
	<div class="text-center" >
        <h3 class="border-primary" ><span class="heading_border bg-primary" id="aboutus">FACILITIES</span></h3>
    </div>
		<div id="gallery">
		<div>
			<button class=" btn filter btn-primary" data-filter="all">ALL</button>
			<button class="btn filter btn-primary" data-filter=".category-1">LAND</button>
			<button class=" btn filter btn-primary" data-filter=".category-2">VESSEL</button>
		</div>
		<div>
			<div class="mix category-1" data-my-order="1">
				<div class="col-md-3 col-sm-6 col-xs-6">
					<a class="fancybox" href="/images/land-2.jpg"><i class="fa fa-search-plus"></i></a>
				</div>
				<div class="thumb_zoom"><img src="/images/land-2.jpg" class="img-responsive"> </div>
			</div>
			<div class="mix category-1" data-my-order="2">
				<div class="col-md-3 col-sm-6 col-xs-6">
					<a class="fancybox" href="/images/land-3.jpg"><i class="fa fa-search-plus"></i></a>
				</div>
				<div class="thumb_zoom"><img src="/images/land-3.jpg" class="img-responsive"> </div>
			</div>
			<div class="mix category-2" data-my-order="3">
				<div class="col-md-3 col-sm-6 col-xs-6">
					<a class="fancybox" href="/images/vessel-4.jpg"><i class="fa fa-search-plus"></i></a>
				</div>
				<div class="thumb_zoom"><img src="/images/vessel-4.jpg" class="img-responsive"> </div>
			</div>
			<div class="mix category-1" data-my-order="4">
				<div class="col-md-3 col-sm-6 col-xs-6">
					<a class="fancybox" href="/images/land-5.jpg"><i class="fa fa-search-plus"></i></a>
				</div>
				<div class="thumb_zoom"><img src="/images/land-5.jpg" class="img-responsive"> </div>
			</div>
			<div class="mix category-2" data-my-order="5">
				<div class="col-md-3 col-sm-6 col-xs-6">
					<a class="fancybox" href="/images/vessel-5.jpg"><i class="fa fa-search-plus"></i></a>
				</div>
				<div class="thumb_zoom"><img src="/images/vessel-5.jpg" class="img-responsive"> </div>
			</div>
			<div class="mix category-2" data-my-order="6">
				<div class="col-md-3 col-sm-6 col-xs-6">
					<a class="fancybox" href="/images/vessel-6.jpg"><i class="fa fa-search-plus"></i></a>
				</div>
				<div class="thumb_zoom"><img src="/images/vessel-6.jpg" class="img-responsive"> </div>
			</div>
			<div class="mix category-1" data-my-order="7">
				<div class="col-md-3 col-sm-6 col-xs-6">
					<a class="fancybox" href="/images/land-6.jpg"><i class="fa fa-search-plus"></i></a>
				</div>
				<div class="thumb_zoom"><img src="/images/land-6.jpg" class="img-responsive"> </div>
			</div>
			<div class="mix category-1" data-my-order="8">
				<div class="col-md-3 col-sm-6 col-xs-6">
					<a class="fancybox" href="/images/land-7.jpg"><i class="fa fa-search-plus"></i></a>
				</div>
				<div class="thumb_zoom"><img src="/images/land-7.jpg" class="img-responsive"> </div>
			</div>
			<div class="mix category-2" data-my-order="8">
				<div class="col-md-3 col-sm-6 col-xs-6">
					<a class="fancybox" href="/images/vessel-8.jpg"><i class="fa fa-search-plus"></i></a>
				</div>
				<div class="thumb_zoom"><img src="/images/vessel-8.jpg" class="img-responsive"> </div>
			</div>
			<div class="mix category-1" data-my-order="8">
				<div class="col-md-3 col-sm-6 col-xs-6">
					<a class="fancybox" href="/images/land-9.jpg"><i class="fa fa-search-plus"></i></a>
				</div>
				<div class="thumb_zoom"><img src="/images/land-9.jpg" class="img-responsive"> </div>
			</div>
			<div class="mix category-1" data-my-order="8">
				<div class="col-md-3 col-sm-6 col-xs-6">
					<a class="fancybox" href="/images/land-1.jpg"><i class="fa fa-search-plus"></i></a>
				</div>
				<div class="thumb_zoom"><img src="/images/land-1.jpg" class="img-responsive"> </div>
			</div>
			<div class="mix category-2" data-my-order="8">
				<div class="col-md-3 col-sm-6 col-xs-6">
					<a class="fancybox" href="/images/vessel-12.jpg"><i class="fa fa-search-plus"></i></a>
				</div>
				<div class="thumb_zoom"><img src="/images/vessel-12.jpg" class="img-responsive"> </div>
			</div>
		</div>
	</div>
</div>
<!-- /Images Section End -->
</div>
<!-- Container Section End -->
<!-- page level js starts-->
@endsection
@section("js")
<script type="text/javascript" src="/home/vendors/mixitup/src/jquery.mixitup.js"></script>
<script type="text/javascript" src="/home/vendors/fancybox/source/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="/home/vendors/fancybox/source/helpers/jquery.fancybox-buttons.js"></script>
<script type="text/javascript" src="/home/vendors/fancybox/source/helpers/jquery.fancybox-media.js"></script>
<script type="text/javascript" src="/home/js/portfolio.js"></script>

<!--page level js ends-->
@endsection