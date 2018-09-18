<aside id="left-panel" class="left-panel">
	<nav class="navbar navbar-expand-sm navbar-default">
		<div class="navbar-header">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
				<i class="fa fa-bars"></i>
			</button>
			<a class="navbar-brand" href="{{ route('admin.dashboard') }}"><img src="{{ my_asset('images/logo.png') }}" alt="Logo" width="100px" height="100px"></a>
			<a class="navbar-brand hidden" href="{{ route('admin.dashboard') }}">CT</a>
		</div>
		<div id="main-menu" class="main-menu collapse navbar-collapse ">
			<ul class="nav navbar-nav"><!-- 
				<li><a href="{{ route('admin.dashboard') }}"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a></li>
				<li><a href="{{ route('admin.clients') }}"> <i class="menu-icon fa fa-th-list"></i>Clients</a></li>
				<li><a href="{{ route('admin.clients') }}"> <i class="menu-icon fa fa-th-list"></i>sub-Category</a></li> -->

				<li><a href="{{ route('admin.dashboard') }}"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a></li>
				<li><a href="{{ route('admin.clients') }}"> <i class="menu-icon fa fa-th-list"></i>Clients</a></li>
				<li><a href="{{ route('admin.categories') }}"> <i class="menu-icon fa fa-th-list"></i>Categories</a></li>
				<li><a href="{{ route('admin.sub-categories') }}"> <i class="menu-icon fa fa-th-list"></i>Sub Categories</a></li>
				<li><a href="{{ route('admin.products') }}"> <i class="menu-icon fa fa-th-list"></i>Product</a>
				
			</ul>
		</div>
	</nav>
</aside>