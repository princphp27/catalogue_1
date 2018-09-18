@extends('admin.layouts.adminApp')
@section('pageTitle','Sub Categories')
@section('content')
<div class="col-xl-12">
	@include ('admin.partials.messages')
	@include ('admin.partials.form-error-messages')
	<div class="card">
		<div class="card-header">Create</div>
		<div class="card-body">
					<div class="table-responsive">
					@foreach ($Clients as $client)
				<form class="form-horizontal" action="{{route('admin.sub-categories.store',$client->id)}}" method="post" enctype= "multipart/form-data">@endforeach
					<?php
					$parentCategory = old('parent_category');
					$category_id =  old('category_id');
					?>
					{!! csrf_field() !!}
					
					<table class="table table-bordered" style="width: 100%;">
						<tr>
                             
							<th width="20%">Client List:</th>
							<td>
								<select class="form-control" name="client_id" id="client_id" placeholder="Select Client List">
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

							<th width="20%">Parent Category:</th>
							<td>
								<select class="form-control" id="parent" name="parent" placeholder="Select parent category">
									<option value="">---Select---</option>
									<?php echo getCategoryOptions($parentCategory);?>
								</select>
							</td>
						</tr>
						<tr>

							<th>Sub Category Name:</th>

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

@section('script')
<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery("#client_id").on("change",function(event){
		// event.preventDefault();
		jQuery("#parent").html("");
		var ClientId = jQuery(this).val();
			   jQuery.ajax({
                        url:APP_URL+'/admin/categories/json/'+ClientId,
                        type:"get",
                        data: {},
                        dataType:'json',
                        success: function(response){
                
                            if(response.success){
                            
                            	jQuery("#parent").html('<option value="">---Select---</option>');
                              if(response.data){
                                for(var c=0; c < response.data.length; c++){
									jQuery("#parent").append('<option value="'+response.data[c].id+'">'+response.data[c].name+'</option>');
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