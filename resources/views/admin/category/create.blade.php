@extends('admin.layouts.adminApp')
@section('pageTitle','Categories')
@section('content')
<div class="col-xl-12">
@include ('admin.partials.messages')
@include ('admin.partials.form-error-messages')
	<div class="card">
		<div class="card-header">Create</div>
			<div class="card-body">
				<div class="table-responsive">
				<form class="form-horizontal" action="{{route('admin.categories.store')}}" method="post" enctype= "multipart/form-data">
					{!! csrf_field() !!}
					
					<table class="table table-bordered" style="width: 100%;">
						<tr>
                             
							<th width="20%">Client List:</th>
							<td>
								<select class="form-control" name="client_id" placeholder="Select Client List">
									<option value="">---Select---</option>

									
									@foreach ($Clients as $client)
											
										<option value="{{$client->id}}" {{ (old('client_id') == $client->id)?" SELECTED":"" }}>{{$client->name}}</option>
									}
									}
									@endforeach

								</select>
								
							</td>
						</tr>
				
						<tr>
							<th>Name:</th>
							<td>
								<input type="text" class="form-control" id="name" name="name" placeholder="Enter category name" value="{{ old('name') }}">
							</td>
						</tr>
						<tr>
							<th>Image:</th>
							<td>
								<input type="file" class="form-control" id="image" name="image" placeholder="Select image file">
							</td>
						</tr>
						<tr>
							<th>Status:</th>
							<td>
								<label class="radio-inline"><input type="radio" name="status" value="1" checked="checked"> Active</label>
								<label class="radio-inline"><input type="radio" name="status" value="0"> Inactive</label>
							</td>
						</tr>
						<tr>
							<th></th>
							<td>
								<button type="submit" class="btn btn-primary">Create</button>
							</td>
						</tr>	
					</table>
				</form>
			</div>	
		</div>	
	</div>
</div>	
@endsection