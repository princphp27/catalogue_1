@extends('client.layouts.app')
@section('pageTitle','Dashboard')

@section('content')
<div class="col-xl-12">
	@include ('client.partials.messages')
	@include ('client.partials.form-error-messages')
	<div class="card">
		<div class="card-body">
			<h2 class="text-center">Welcome to client dashboard</h2>
		</div>	
	</div> 
</div>
@endsection

@section('script')
@endsection