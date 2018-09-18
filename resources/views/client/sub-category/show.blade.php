@extends('client.layouts.app')
@section('pageTitle','Sub Categories')
@section('content')
<div class="col-xl-12">
@include ('client.partials.messages')
@include ('client.partials.form-error-messages')
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

							<th>Description:</th>

							<td>{{ $categoryInfo->description }}</td>
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
						<td>{{ $categoryInfo->getStatus->name }}</td>
					</tr>
					<tr>
						<th>Image:</th>
						<td>

							<img src="{{my_asset('storage/uploads/category_images')}}/{{$categoryInfo->image}}" width="150px" height="100px"/>
						</td>
					</tr>
					<tr>
						<th>Banners:</th>
						<td>

							<?php
							$banners = $categoryInfo->getBanners;
							?>
							@if($banners)
								@foreach($banners as $banner)
									<div class="category-banner-container">
										<img src="{{my_asset('storage/uploads/category_banners')}}/{{$banner->image}}" width="150px" height="100px"/></div>
								@endforeach
							@endif
						</td>
					</tr>
					<tr>
							<th></th>
							<td>
								<a href="{{route('client.sub-categories.edit',['id'=>$categoryInfo->id])}}" class="btn btn-primary">Edit</a>
							</td>
						</tr>	
				</table>
			</div>
		</div>	
	</div> 
</div>
@endsection