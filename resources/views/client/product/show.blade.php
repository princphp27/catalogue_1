@extends('client.layouts.app')
@section('pageTitle','Products')
@section('content')
<div class="btn-group pull-right">
		<a href="{{route('client.products.create')}}" class="btn btn-primary" style="margin-right:20px;"><i class="fa fa-plus">     Add New Product</i></a>
	</div>
<div class="col-xl-12">
@include ('client.partials.messages')
@include ('client.partials.form-error-messages')
<!-- <div class="btn-group pull-right">
		<a href="{{route('client.products.create')}}" class="btn btn-primary">Add New Product</a>
	</div> -->
	<div class="card">
		<div class="card-header">Detail</div>
		
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" style="width: 100%;">

					<tr>
						<th width="20%">Product Name:</th>
						<td>{{ $dataInfo->name }}</td>
					</tr>
					<tr>

							<th>Product Price :</th>

							<td>
								<?php
								$price = $dataInfo->getPrices()->where('status',1)->get()->first();
								$price = ($price) ? $price->product_price :"";
								?>
								{{$price}}
							</td>
						</tr>
					<tr>
						<th>Category:</th>
						<td>{{$dataInfo->getCategory->name}} <i class="fa fa-arrow-right"></i> {{$dataInfo->name}}</td>
					</tr>
					<tr>
						<th>Description:</th>
						<td>{{ $dataInfo->description }}</td>
					</tr>
					
					<tr>
						<th>Specifications:</th>
						<td>
							<?php
							$specifications = $dataInfo->getSpecifications;
							?>
							@if($specifications)
								@foreach($specifications as $spec)
	
									<div class="row" style="margin-top:5px;">
									<div class="col-md-1">
										<label>Key:</label>
									</div>
									<div class="col-md-4">
										{{$spec->product_key}}
									</div>
									<div class="col-md-1">
										<label>Value:</label>
									</div>
									<div class="col-md-4">
										{{$spec->product_value}}
									</div>
									<div class="col-md-1">
										
									</div>
								</div>
								@endforeach
							@endif
							
						</td>
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
						<th>Images:</th>
						<td>
							<?php
								$images = $dataInfo->getImages;
							?>
							@if($images)
								@foreach($images as $img)
									<div class="product-image-container">
										<img src="{{my_asset('storage/uploads/product_images')}}/{{$img->image}}" width="150px" height="100px"/></div>
								@endforeach
							@endif
						</td>
					</tr>
					<tr>
						<th>Banners:</th>
						<td>
							<?php
								$banners = $dataInfo->getBanners;
							?>
							@if($images)
								@foreach($banners as $banner)
									<div class="product-banner-container">
										<img src="{{my_asset('storage/uploads/product_banners')}}/{{$banner->image}}" width="150px" height="100px"/></div>
								@endforeach
							@endif
						</td>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<td><a href="{{route('client.products.edit',['id'=>$dataInfo->id])}}" class="btn btn-primary">Edit</a></td>
					</tr>
				</table>
			</div>
		</div>	
	</div> 
</div>
@endsection