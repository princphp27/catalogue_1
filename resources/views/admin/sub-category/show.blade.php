@extends('admin.layouts.adminApp')
@section('pageTitle','Sub Categories')
@section('content')
<div class="col-xl-12">
@include ('admin.partials.messages')
@include ('admin.partials.form-error-messages')
	<div class="card">
		<div class="card-header">Detail</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" style="width: 100%;">
					<tr>
						<th width="20%">Category:</th>
						<td>{{ ($categoryInfo->getParentCategory) ? $categoryInfo->getParentCategory->name :"N/A" }}</td>
					</tr>
					<tr>

						<th>Sub Category Name:</th>

						<td>{{ $categoryInfo->name }}</td>
					</tr>
					<tr>
						<th>Image:</th>
						<td>
							<img src="{{my_asset('storage/uploads/category_images')}}/{{($categoryInfo->image)}}" width="150px" height="100px"/>
						</td>
					</tr>
					<tr>
						<th>Created At:</th>
						<td>{{ $categoryInfo->created_at }}</td>
					</tr>
					<tr>
						<th>Updated At:</th>
						<td>{{ $categoryInfo->updated_at }}</td>
					</tr>
					<tr>
						<th>Status:</th>
						<td>{{ $categoryInfo->status }}</td>
					</tr>
				</table>
			</div>
		</div>	
	</div> 
</div>
@endsection