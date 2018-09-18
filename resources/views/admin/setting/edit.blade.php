@extends('admin.layouts.adminApp')
@section('pageTitle','Settings -> SMS API -> Edit')
@section('content')
<div class="col-xl-12">
@include ('admin.partials.messages')
@include ('admin.partials.form-error-messages')
	<div class="card">
		<form class="form-horizontal" action="{{route('admin.settings.sms-api.update')}}" method="post" enctype= "multipart/form-data">
			{!! csrf_field() !!}

			<table class="table table-bordered" style="width: 100%;">
				<tr>
					<th width="20%">Username:</th>
					<td>
						<input type="text" class="form-control" name="username" placeholder="Enter username" value="{{ old('username',$dataInfo->username) }}">
					</td>
				</tr>
				<tr>
					<th>Password:</th>
					<td>
						<input type="text" class="form-control"  name="password" placeholder="Enter password" value="{{ old('password',$dataInfo->password) }}">
					</td>
				</tr>
				<tr>
					<th>Sender Id:</th>
					<td>
						<input type="text" class="form-control" name="sender_id" placeholder="Enter sender id" value="{{ old('sender_id',$dataInfo->sender_id) }}">
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