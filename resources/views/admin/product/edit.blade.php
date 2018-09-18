@extends('admin.layouts.adminApp')
@section('pageTitle','Products')
@section('content')
<div class="col-xl-12">
	@include ('admin.partials.messages')
	@include ('admin.partials.form-error-messages')
	<div class="card">
		<div class="card-header">Edit</div>
		<div class="card-body">
			<div class="table-responsive">
				@foreach($dataInfoo as $dataInfo)
				<form class="form-horizontal" action="{{route('admin.products.update',['id'=>$dataInfo->id])}}" method="post" enctype= "multipart/form-data">
					{!! csrf_field() !!}
					<input name="_method" type="hidden" value="PUT">
					<?php
					
					$parentCategory = old('parent',$dataInfo->getpCategory->id);

					$category_id =  old('category_id',$dataInfo->getpCategory->id);
					
					?>
					<table class="table table-bordered" style="width: 100%;">
						<tr>

							<th width="20%">Category:</th>
							<td>
								<select class="form-control" id="parent" name="parent" placeholder="" value=>
									<option value="{{$pat->id}}">{{$pat->name}}</option>
									@foreach ($data as $datas)
											
										<option value="{{$datas->id}}" {{ (old('client_id') == $datas->id)?" SELECTED":"" }}>{{$datas->name}}</option>
									
									
									@endforeach
								</select>
							</td>
						</tr>
						<tr>

							<th>Sub Category:</th>
							<td>
								<select class="form-control" id="category_id" name="category_id" placeholder="">
									<option value="{{$catnew->id}}">{{$catnew->name}}</option>
									<?php echo getSubCategoryOptions($parentCategory,$category_id);?>
								</select>
							</td>
						</tr>
						<tr>
							
							<th>Product Name :</th>

							<td>
								<input type="text" class="form-control" id="name" name="name" placeholder="" value="{{$dataInfo->name}}">
							</td>
						</tr>
						<tr>

							<th>Product Price :</th>

							<td>
								<?php
								$price = $dataInfo->getPrices()->where('status',1)->get()->first();
								//dd($price);
								$price = old('price',($price) ? $price->product_price :"");
								?>
								<input type="text" class="form-control" name="price" placeholder="" value="{{$price}}">
							</td>
						</tr>
						<tr>
							<th>Description:</th>
							<td>
								<textarea class="form-control" id="description" name="description" placeholder="">{{old('description',$dataInfo->description)}}</textarea>
							</td>
						</tr>
						<tr>
							<th>Specifications:</th>
							<td id="specifications_container">
								<div class="row">
									<div class="col-md-1">
										<label>Key:</label>
									</div>
									<div class="col-md-4">
										<input type="text" class="form-control" id="specifications_key"/>
									</div>
									<div class="col-md-1">
										<label>Value:</label>
									</div>
									<div class="col-md-4">
										<input type="text" class="form-control" id="specifications_value"/>
									</div>
									<div class="col-md-1">
										<span class="btn btn-primary btn-add">Add</span>
									</div>
								</div>
								<br/>
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
												<input type="text" class="form-control" name="specifications_keys[]" value="{{$spec->product_key}}"/>
											</div>
											<div class="col-md-1">
												<label>Value:</label>
											</div>
											<div class="col-md-4">
												<input type="text" class="form-control" name="specifications_values[]" value="{{$spec->product_key}}"/>
											</div>
											<div class="col-md-1">
												<span class="btn btn-danger btn-delete">Delete</span>
											</div>
										</div>
									@endforeach
								@endif
							</td>
						</tr>
						<?php
						$status = old('status',$dataInfo->status);
						?>
						<tr>
							<th>Status:</th>
							<td>
								<label class="radio-inline"><input type="radio" name="status" value="1" checked="checked"> Active</label>
								<label class="radio-inline"><input type="radio" name="status" value="0" <?php ($status == '0') ? 'checked="checked"' : ''?>> Inactive</label>
							</td>
						</tr>
						<tr>
							<th>Images:</th>
							<td>
	
								<?php
								$images = $dataInfo->getImages;
								?>
								@if($images)
									@foreach($images as $img)
										<div class="product-image-container"><img src="{{my_asset('storage/uploads/product_images')}}/{{($img->image)}}" width="150px" height="100px"/></div>
									@endforeach
								@endif
								<input type="file" class="form-control" name="images[]" placeholder="Select images" multiple>
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
										<div class="product-banner-container"><img src="{{my_asset('storage/uploads/product_banners')}}/{{($banner->image)}}" width="150px" height="100px" /></div>
									@endforeach
								@endif
								<input type="file" class="form-control" name="banners[]" placeholder="Select banners" multiple>
							</td>
							@endforeach
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
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery("#parent").on("change",function(event){
		// event.preventDefault();
		jQuery("#category_id").html("");
		var categoryID = jQuery(this).val();
			   jQuery.ajax({
                        url:APP_URL+'/admin/sub-categories/json/'+categoryID,
                        type:"get",
                        data: {},
                        dataType:'json',
                        success: function(response){
                           // jQuery('.ShowShiftUpdateModal').html(response);
                            if(response.success){
                                   
                            	jQuery("#category_id").html('<option value="">---Select---</option>');
                              if(response.data){
                                for(var c=0; c < response.data.length; c++){
									jQuery("#category_id").append('<option value="'+response.data[c].id+'">'+response.data[c].name+'</option>');
								}
                              }
                            }
                            else{ 
                              if(response.message){
                                 ViewHelpers.notify("error",response.message);
                              }
                            }
                        },
                        error: function(err){
                            //alert(err) ;
                        }
                    });
		
	});
});
	jQuery(document).ready(function() {
	jQuery(document).on("click",".btn-add",function(event){
		//event.preventDefault();
		var key = jQuery('#specifications_key').val();
		var value = jQuery('#specifications_value').val();
		console.log(key+"==="+value);
		if(key=="" || value==""){
			return false;
		}
		jQuery('#specifications_key').val("");
		jQuery('#specifications_value').val("");
		var html= '';
			html+= '<div class="row" style="margin-top:5px;">';
				html+= '<div class="col-md-1">';
					html+= '<label>Key:</label>';
				html+= '</div>';
				html+= '<div class="col-md-4">';
					html+= '<input type="text" class="form-control" name="specifications_keys[]" value="'+key+'"/>';
				html+= '</div>';
				html+= '<div class="col-md-1">';
					html+= '<label>Value:</label>';
				html+= '</div>';
				html+= '<div class="col-md-4">';
					html+= '<input type="text" class="form-control" name="specifications_values[]" value="'+value+'"/>';
				html+= '</div>';
				html+= '<div class="col-md-1">';
					html+= '<span class="btn btn-danger btn-delete">Delete</span>';
				html+= '</div>';
			html+= '</div>';
		jQuery('#specifications_container').append(html);	
		
	});	
	jQuery(document).on("click",".btn-delete",function(event){
		event.preventDefault();
		jQuery(this).parent().parent().remove();
	});	
});
</script>
@endsection
