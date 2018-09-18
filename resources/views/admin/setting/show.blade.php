@extends('admin.layouts.adminApp')
@section('pageTitle','Settings -> SMS API')
@section('content')
<div class="col-xl-12">
@include ('admin.partials.messages')
@include ('admin.partials.form-error-messages')

	<div class="card">	
		<table class="table table-bordered" style="width: 100%;">
			<tr>
				<th width="20%">Username:</th>
				<td>
					{{ $dataInfo->username }}
				</td>
			</tr>
			<tr>
				<th>Password:</th>
				<td>
					{{ $dataInfo->password }}
				</td>
			</tr>
			<tr>
				<th>Send Id:</th>
				<td>
					{{ $dataInfo->sender_id }}
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
					<a class="btn btn-primary" href="{{ route('admin.settings.sms-api.edit') }}">Edit</a>
				</td>
			</tr>
		</table>
	</div> 
</div>
@endsection
