@extends('admin.layouts.adminApp')
@section('pageTitle','Profile :: Show')
@section('content')
<div class="col-xl-12">
@include ('admin.partials.messages')
@include ('admin.partials.form-error-messages')
	<div class="card">	
		<table class="table table-bordered" style="width: 100%;">
			<tr>
				<th width="20%">Profile Image:</th>
				<td>
					<img src="{{my_asset('storage/uploads/user_images')}}/{{($userInfo->profile_image)}}" width="100px" height="100px"/>
				</td>
			</tr>
			<tr>
				<th>First Name:</th>
				<td>
					{{ $userInfo->first_name }}
				</td>
			</tr>
			<tr>
				<th>Last Name:</th>
				<td>
					{{ $userInfo->last_name }}
				</td>
			</tr>
			<tr>
				<th>Email:</th>
				<td>
					{{ $userInfo->email }}
				</td>
			</tr>
			
			<tr>
				<th>Created At:</th>
				<td>
					{{ $userInfo->created_at }}
				</td>
			</tr>
			<tr>
				<th>Updated At:</th>
				<td>
					{{ $userInfo->updated_at }}
				</td>
			</tr>
			<tr>
				<th>Status:</th>
				<td>
					{{ $userInfo->getStatus->name }}
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
					<a class="btn btn-primary" href="{{ route('admin.profile.edit') }}">Edit</a>
				</td>
			</tr>
		</table>
	</div> 
</div>
@endsection