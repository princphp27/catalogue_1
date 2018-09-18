@extends('admin.layouts.adminApp')
@section('pageTitle','Profile :: Change Password')
@section('content')
<div class="col-xl-12">
@include ('admin.partials.messages')
@include ('admin.partials.form-error-messages')
	<div class="card">
		<form class="form-horizontal" action="{{route('admin.profile.update-password')}}" method="post">
			{!! csrf_field() !!}

			<table class="table table-bordered" style="width: 100%;">
				<tr>
					<th width="20%">Old Password:</th>
					<td>
						<input type="password" class="form-control" name="old_password" placeholder="Enter your old password">
					</td>
				</tr>
				<tr>
					<th>New Password:</th>
					<td>
						<input type="password" class="form-control" name="password" placeholder="Enter your new password">
					</td>
				</tr>
				<tr>
					<th>Confirm New Password:</th>
					<td>
						<input type="password" class="form-control" name="password_confirmation" placeholder="Confirm your new password">
					</td>
				</tr>
				<tr>
					<th></th>
					<td>
						<button type="submit" class="btn btn-primary">Save</button>
					</td>
				</tr>
			</table>
		</form>
  	</div>
</div>
@endsection