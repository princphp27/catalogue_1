@extends('client.layouts.app')
@section('pageTitle','Categories')
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
							<th width="20%">Name:</th>
							<td>{{ $dataInfo->name }}</td>
						</tr>
						
						<tr>
							<th>Description:</th>
							<td>{{ $dataInfo->description }}</td>
						</tr>
						<tr>
							<th>Created At:</th>
							<td>{{ $dataInfo->created_at }}</td>
						</tr>
						<tr>
							<th>Updated At:</th>
							<td>{{ $dataInfo->updated_at }}</td>
						</tr>
						<tr>
							<th>Status:</th>
							<td>{{ $dataInfo->getStatus->name }}</td>
						</tr>
						<tr>
							<th>Image:</th>
							<td>
								<img src="{{my_asset('storage/uploads/category_images')}}/{{$dataInfo->image}}" width="150px" height="100px"/>
							</td>
						</tr>
						<tr>
							<th>Banners:</th>
							<td>
	
								<?php
								$banners = $dataInfo->getBanners;
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
								<a href="{{route('client.categories.edit',['id'=>$dataInfo->id])}}" class="btn btn-primary">Edit</a>
							</td>
						</tr>	
					</table>
				</div>
			</div>
		</div>	
	</div> 
</div>
@endsection