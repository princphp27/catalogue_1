@extends('client.layouts.app')
@section('pageTitle','Settings')
@section('content')
<div class="col-xl-12">
	@include ('client.partials.messages')
	@include ('client.partials.form-error-messages')
	<div class="card">
		<div class="card-header">Theme</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" style="width: 100%;">
						<tr>
							<th width="20%">Color Code:</th>
							<td>{{ ($dataInfo) ? $dataInfo->color_code : "N/A" }}</td>
						</tr>
						<tr>
							<th></th>
							<td>
								<a href="{{route('client.theme.edit')}}" class="btn btn-primary">Edit</a>
							</td>
						</tr>	
					</table>
				</div>
			</div>
		</div>	
	</div> 
</div>
@endsection