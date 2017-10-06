@extends("home.layouts.master2")
@section("css")
<link rel="stylesheet" type="text/css" href="/home/css/tabbular.css">
<link rel="stylesheet" type="text/css" href="/home/css/jquery.circliful.css">
<link rel="stylesheet" type="text/css" href="/home/vendors/owl-carousel/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="/home/vendors/owl-carousel/owl.theme.css">
@endsection
@section("content")
<div class="row">
	<!-- Testimonial Section -->
	<div class="text-center">
		<h3 class="border-primary"><span class="heading_border bg-primary">Programs</span></h3>
	</div>
	@foreach($type as $types)
	<div class="col-md-12">
		@if(count($types->program)!=0)
		<h2 class="text-center">{{$types->typeName}}</h2>
		@endif
		@foreach($program as $programs)
		@if($programs->programtype->typeName == $types->typeName)
		<div class="col-md-4">
			<div class="author">
				<h3 class="text-center">{{$programs->programName}}</h3>
				<p>
					<label>{{$programs->programDesc}}</label>
				</p>
			</div>
		</div>
		@endif
		@endforeach
	</div>
	@endforeach()
	<!-- Testimonial Section End -->
</div>

@endsection
@section("js")
<script type="text/javascript">
	$("#programs").addClass( "active");
</script>
@endsection