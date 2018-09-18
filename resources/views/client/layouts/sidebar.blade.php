<aside id="left-panel" class="left-panel">
	<nav class="navbar navbar-expand-sm navbar-default">
		<div class="navbar-header">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
				<i class="fa fa-bars"></i>
			</button>
			<a class="navbar-brand" href="{{ route('client.dashboard') }}"><img src="{{ my_asset('images/logo.png') }}" alt="Logo" width="100px" height="100px"></a>
			<a class="navbar-brand hidden" href="{{ route('client.dashboard') }}">CT</a>
		</div>
		<div id="main-menu" class="main-menu collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li><a href="{{ route('client.dashboard') }}"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a></li>
				<li><a href="{{ route('client.categories') }}"> <i class="menu-icon fa fa-th-list"></i>Categories</a></li>
				<li><a href="{{ route('client.sub-categories') }}"> <i class="menu-icon fa fa-th-list"></i>Sub Categories</a></li>
				<li><a href="{{ route('client.products') }}"> <i class="menu-icon fa fa-th-list"></i>Products</a></li>
				<li><a href="{{ route('client.enquiry') }}"> <i class="menu-icon fa fa-envelope"></i>Enquiry</a></li>
			</ul>
		</div>
	</nav>
</aside>