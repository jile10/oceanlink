<div class="clearfix"></div>
<ul id="menu" class="page-sidebar-menu" style="margin-top: 30px;">
	<li id="cashierHome">
		<a href="/cashier
		">
			<i class="livicon" data-name="home" data-size="18" data-c="#418BCA" data-hc="#418BCA" data-loop="true"></i>
			<span class="title">Monitor Collection</span>
		</a>
	</li>
	<li id="reports">
		<a href="{{url('/reports')}}">
			<i class="livicon" data-name="barchart" data-size="18" data-c="#418BCA" data-hc="#418BCA" data-loop="true"></i>
			<span class="title">Reports</span>
		</a>
		<ul class="sub-menu">
			<li id="collectionReport">
				<a href="{{url('cashier/reports/collectionreport')}}">
					<i class="fa fa-angle-double-right"></i>
					Collection Report
				</a>
			</li>
		</ul>
	</li>
</ul>