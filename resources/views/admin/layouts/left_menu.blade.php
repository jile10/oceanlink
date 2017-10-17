<div class="nav_icons" style="margin-top: 10px;">
    <ul class="sidebar_threeicons">
        <li>
            <a href="/admin">
                <i class="livicon" data-name="home" title="Home" data-loop="true" data-color="#e9573f" data-hc="#e9573f" data-s="25"></i>
            </a>
        </li>
        <li>
            <a href="#">
                <i class="livicon" data-name="users" title="Page Builder" data-loop="true" data-color="#37bc9b" data-hc="#37bc9b" data-s="25"></i>
            </a>
        </li>
        <li>
            <a href="/maintenance/employee">
                <i class="livicon" data-name="gears" title="Employee Maintenance" data-loop="true" data-color="#42aaca" data-hc="#42aaca" data-s="25"></i>
            </a>
        </li>
        <li>
            <a href="/">
                <i class="livicon" data-name="sign-out" title="Sign out" data-loop="true" data-color="#f6bb42" data-hc="#f6bb42" data-s="25"></i>
            </a>
        </li>
    </ul>
</div>
<div class="clearfix"></div>

<ul id="menu" class="page-sidebar-menu">
	<li id="home">
		<a href="/admin">
			<i class="livicon" data-name="home" data-size="18" data-c="#418BCA" data-hc="#418BCA" data-loop="true"></i>
			<span class="title">Dashboard</span>
		</a>
	</li>
	<li id="transaction">
		<a href="#">
			<i class="livicon" data-name="briefcase" data-size="18" data-c="#418BCA" data-hc="#418BCA" data-loop="true"></i>
			<span class="title">Transaction</span>
		</a>
		<ul class="sub-menu">
			<li id="manage_enrollment">
				<a href="/manage_enrollment">
					<i class="fa fa-angle-double-right"></i>
					<span class="title">Manage Schedule</span>
				</a>
			</li>
			<li id="manage_app">
				<a href="/manage_app/enrollee">
					<i class="fa fa-angle-double-right"></i>
					<span class="title">Process Enrollment</span>
				</a>
			</li>
			<li id="manage_class">
				<a href="/manage_class">
					<i class="fa fa-angle-double-right"></i>
					<span class="title">Manage Class</span>
				</a>
			</li>
			<li id="collection">
				<a href="/collection/single">
					<i class="fa fa-angle-double-right"></i>					
					<span class="title">Monitor Collections</span>
				</a>
			</li>
			<li id="issuance">
				<a href="/issuance">
					<i class="fa fa-angle-double-right"></i>					
					<span class="title">Issuance of Certificate</span>
				</a>
			</li>
		</ul>
	</li>
	<li id="maintenance">
		<a href="#">
			<i class="livicon" data-name="hammer" data-size="18" data-c="#418BCA" data-hc="#418BCA" data-loop="true"></i>
			<span class="title">Maintenance</span>
		</a>
		<ul class="sub-menu">
			<li id="programtype">
				<a href="/maintenance/ptype">
					<i class="fa fa-angle-double-right"></i>
					Program Type 
				</a>
			</li>
			<li id="program">
				<a href="/maintenance/program">
					<i class="fa fa-angle-double-right"></i>
					Program 
				</a>
			</li>
			<li id="course">
				<a href="/maintenance/rate">
					<i class="fa fa-angle-double-right"></i>
					Course 
				</a>
			</li>
			<li id="tofficer">
				<a href="{{url('/maintenance/tofficer')}}">
					<i class="fa fa-angle-double-right"></i>
					Training Officer
				</a>
			</li>
			<li id="buildings">
				<a href="/maintenance/building">
					<i class="fa fa-angle-double-right"></i>
					Building 
				</a>
			</li>
			<li id="floors">
				<a href="/maintenance/floor">
					<i class="fa fa-angle-double-right"></i>
					Floor 
				</a>
			</li>
			<li id="room">
				<a href="/maintenance/room">
					<i class="fa fa-angle-double-right"></i>
					Training Room 
				</a>
			</li>
			<li id="holiday">
				<a href="/maintenance/holiday">
					<i class="fa fa-angle-double-right"></i>
					Holiday
				</a>
			</li>
			<li id="vessel">
				<a href="/maintenance/vessel">
					<i class="fa fa-angle-double-right"></i>
					Vessel
				</a>
			</li>
		</ul>
	</li>
	<li id="utilities">
		<a href="#">
			<i class="livicon" data-name="wrench" data-size="18" data-c="#418BCA" data-hc="#418BCA" data-loop="true"></i>
			<span class="title">Utilities</span>
		</a>
		<ul class="sub-menu">
			<li id="companyinfo">
				<a href="{{url('/utilities/companyinfo')}}">
					<i class="fa fa-angle-double-right"></i>
					Company Information
				</a>
			</li>
			<li id="configuration">
				<a href="{{url('/maintenance/employee')}}">
					<i class="fa fa-angle-double-right"></i>
					Configuration
				</a>
			</li>
			<li id="employee">
				<a href="{{url('/maintenance/employee')}}">
					<i class="fa fa-angle-double-right"></i>
					Employee
				</a>
			</li>
			<li id="position">
				<a href="/maintenance/position">
					<i class="fa fa-angle-double-right"></i>
					Position 
				</a>
			</li>
		</ul>
	</li>
	<li id="queries">
		<a href="{{url('/queries')}}">
			<i class="livicon" data-name="linechart" data-size="18" data-c="#418BCA" data-hc="#418BCA" data-loop="true"></i>
			<span class="title">Queries</span>
		</a>
	</li>
	<li id="reports">
		<a href="{{url('/reports')}}">
			<i class="livicon" data-name="barchart" data-size="18" data-c="#418BCA" data-hc="#418BCA" data-loop="true"></i>
			<span class="title">Reports</span>
		</a>
		<ul class="sub-menu">
			<li id="collectionReport">
				<a href="{{url('/reports/collectionreport')}}">
					<i class="fa fa-angle-double-right"></i>
					Collection Report
				</a>
			</li>
			<li id="accountbalance">
				<a href="{{url('/reports/accountbalance')}}">
					<i class="fa fa-angle-double-right"></i>
					Account with Balance
				</a>
			</li>
			<li id="refund">
				<a href="{{url('/reports/refund')}}">
					<i class="fa fa-angle-double-right"></i>
					Refund Report
				</a>
			</li>
		</ul>
	</li>
</ul>