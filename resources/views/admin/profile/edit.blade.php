@extends('admin.layouts.adminApp')
@section('pageTitle','Profile :: Change Password')
@section('content')
<div class="col-xl-12">
@include ('admin.partials.messages')
@include ('admin.partials.form-error-messages')
	<div class="card">
		<form class="form-horizontal" action="{{route('admin.profile.update')}}" method="post" enctype= "multipart/form-data">
			{!! csrf_field() !!}

			<table class="table table-bordered" style="width: 100%;">
				<tr>
					<th width="20%">Profile Image:</th>
					<td>
						<img src="{{my_asset('storage/uploads/user_images')}}/{{($userInfo->profile_image)}}" width="100px" height="100px"/>
						<input type="file" class="form-control" id="profile_image" name="profile_image" placeholder="Select profile image file">
					</td>
				</tr>
				<tr>
					<th>First Name:</th>
					<td>
						<input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" value="{{ old('first_name',$userInfo->first_name) }}">
					</td>
				</tr>
				<tr>
					<th>Last Name:</th>
					<td>
						<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" value="{{ old('last_name',$userInfo->last_name) }}">
					</td>
				</tr>
				<tr>
					<th>Email:</th>
					<td>
						<input type="text" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ old('mobile',$userInfo->email) }}">
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