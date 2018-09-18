<header id="header" class="header">
	<div class="header-menu">
		<div class="col-sm-7"><a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a></div>
		<div class="col-sm-5">
			<div class="pull-right">
				<ul class="nav pull-right">
					<li class="dropdown">
					
						<img class="user-avatar rounded-circle" src="{{my_asset('storage/uploads/user_images')}}/{{(Auth::guard('admin')->user()->profile_image)}}" width="50px" height="50px">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Auth::guard('admin')->user()->first_name.' '.Auth::guard('admin')->user()->last_name }} <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a class="nav-link" href="{{ route('admin.profile') }}"><i class="fa fa-user"></i> My Profile</a></li>
							<li><a class="nav-link" href="{{ route('admin.profile.change-password') }}"><i class="fa fa-key"></i> Change Password</a></li>
							
							<li class="divider"></li>
							<li><a class="nav-link" href=""><i class="fa fa-cog"></i> Settings</a></li>
							
							<li class="divider"></li>
							<li>
								<a class="nav-link" href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Logout</a>
								<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
									{{ csrf_field() }}
								</form>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</header>