<header id="header" class="header">
	<div class="header-menu">
		<div class="col-sm-7"><a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a></div>
		<div class="col-sm-5">
			<div class="pull-right">
				<ul class="nav pull-right">
					<li class="dropdown">
					
						<img class="user-avatar rounded-circle" src="{{my_asset('storage/uploads/user_images')}}/{{(Auth::user()->getClient->logo)}}" width="50px" height="50px">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->getClient->name}}  <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li class="divider"></li>
							<li>
								<a class="nav-link" href="{{ route('client.theme') }}"><i class="fa fa-cog"></i> Theme</a>
							</li>
							<li class="divider"></li>
							<li>
								<a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Logout</a>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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