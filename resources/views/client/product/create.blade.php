@extends('client.layouts.app')
@section('pageTitle','Products')
@section('content')
<div class="col-xl-12">
	@include ('client.partials.messages')
	@include ('client.partials.form-error-messages')
	<div class="card">
		<div class="card-header">Create</div>
		<div class="card-body">
			<div class="table-responsive">
				<form class="form-horizontal" action="{{route('client.products.store')}}" method="post" enctype= "multipart/form-data">
					{!! csrf_field() !!}
					<?php
					$parentCategory = old('parent_category');
					$category_id =  old('category_id');
					?>
					
					
					<table class="table table-bordered" style="width: 100%;">
						
						<tr>

							<th width="20%">Category:</th>
							<td>
								<select class="form-control" id="parent_category" name="parent_category" placeholder="Select parent category">
									<option value="">---Select---</option>@foreach ($parentCategories as $datas)
										<option value="{{$datas->id}}" {{ (old('client_id') == $datas->id)?" SELECTED":"" }}>{{$datas->name}}</option>
									}
									}
									@endforeach
								</select>
							</td>
						</tr>
						<tr>

							<th>Sub Category:</th>
							<td>
								<select class="form-control" id="category_id" name="category_id" placeholder="Select category">
									<option value="">---Select---</option>
									<?php echo getSubCategoryOptions($parentCategory,$category_id);?>
								</select>
							</td>
						</tr>
						<tr>

							<th>Product Name:</th>

							<td>
								<input type="text" class="form-control" id="name" name="name" placeholder="Enter productr name" value="{{ old('name') }}">
							</td>
						</tr>
						<tr>

							<th>Product Price :</th>

							<td>
								<input type="text" class="form-control" name="price" placeholder="" value="{{old('price','')}}">
							</td>
						</tr>
						<tr>
							<th>Description:</th>
							<td>
								<textarea class="form-control" id="description" name="description" placeholder="Description">{{ old('description') }}</textarea>
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
										<!-- //<input type="textarea" class="form-control" id="specifications_value"/> -->
										<textarea class="form-control" id="specifications_value"></textarea>
									</div>
									<div class="col-md-1">
										<span class="btn btn-primary btn-add">Add</span>
									</div>
								</div>
								<br/>
								
								<?php
								$keys = old('specifications_keys');
								$values = old('specifications_values');
								?>
								@if($keys)
									@for($i=0;$i<count($keys);$i++)
										
										<div class="row" style="margin-top:5px;">
											<div class="col-md-1">
												<label>Key:</label>
											</div>
											<div class="col-md-4">
												<input type="text" class="form-control" name="specifications_keys[]" value="{{$keys[$i]}}"/>

											</div>
											<div class="col-md-1">
												<label>Value:</label>
											</div>
											<div class="col-md-4">
												<textarea class="form-control" name="specifications_values[] id="specifications_value" value="{{$values[$i]}}">{{$keys[$i]}}</textarea>
												<!-- <input type="text" class="form-control" name="specifications_values[]" value="{{$values[$i]}}"/> -->
											</div>
											<div class="col-md-1">
												<span class="btn btn-danger btn-delete">Delete</span>
											</div>
										</div>
									@endfor
								@endif
							</td>
						</tr>
						<?php
						$status = old('status');
						?>
						<tr>
							<th>Status:</th>
							<td>
								<label class="radio-inline"><input type="radio" name="status" value="1" checked="checked"> Active</label>
								<label class="radio-inline"><input type="radio" name="status" value="0" <?php if($status=='0'){ echo 'checked="checked"';}?>> Inactive</label>
							</td>
						</tr>
						<tr>
							<th>Images:</th>
							<td>
								<input type="file" class="form-control" name="images[]" placeholder="Select images" multiple>
							</td>
						</tr>
						<tr>
							<th>Banners:</th>
							<td>
								<input type="file" class="form-control" name="banners[]" placeholder="Select banners" multiple>
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

@section('script')
<script type="text/javascript">
/*jQuery(document).ready(function() {
	jQuery(document).on("change","#parent_category",function(event){
		event.preventDefault();
		jQuery("#category_id").html("");
		var categoryId = jQuery("#parent_category").val();
		if(categoryId && categoryId!=""){
			Helpers.callAjax(APP_URL+'/client/sub-categories/json/'+categoryId,'GET',{},'json',function(responseType,response){
				switch(responseType){
					case "success":
						if(response.success){
							jQuery("#category_id").html('<option value="">---Select---</option>');
							if(response.data && response.data.length > 0){
								for(var c=0; c < response.data.length; c++){
									jQuery("#category_id").append('<option value="'+response.data[c].id+'">'+response.data[c].name+'</optio>');
								}
							}
						}
					break;
				}
			});
		}
	});	
	jQuery(document).on("click",".btn-add",function(event){
		event.preventDefault();
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
});*/

jQuery(document).ready(function() {	
	jQuery(document).on("click",".btn-add",function(event){
		event.preventDefault();
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
					html+= '<textarea class="form-control" name="specifications_values[]" value="'+value+'">'+value+'</textarea>';
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

jQuery(document).ready(function() {
	jQuery("#parent_category").on("change",function(event){
		// event.preventDefault();
		jQuery("#category_id").html("");
		var ClientId = jQuery(this).val();

			   jQuery.ajax({
                        url:APP_URL+'/client/products/json/'+ClientId,
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
</script>
@endsection