@extends('admin.layouts.default')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-6 mx-auto">
			<img src="{{my_asset('images/logo.png')}}" height="150px"/>
			<div class="card">
				<div class="card-header">Admin Login</div>
				<div class="card-body">
					@include ('admin.partials.messages')
					@include ('admin.partials.form-error-messages')
						
					<form id="form_login" action="{{ route('admin.login') }}" method="post">
						{{ csrf_field() }}
					  <div class="form-group">
							<input type="text" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autofocus>
					  </div>
					  
					  <div class="form-group">
							<input type="password" class="form-control" placeholder="Password" name="password" required>
					  </div>
					  <div class="button-holder text-right">
						<button type="submit" class="btn btn-primary">Login</button>
					  </div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>	
@endsection
@section('script')
@endsection