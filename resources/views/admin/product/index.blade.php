@extends('admin.layouts.adminApp')
@section('pageTitle','Products')
@section('content')
<div class="col-xl-12">
@include ('admin.partials.messages')
@include ('admin.partials.form-error-messages')
	<div class="btn-group pull-right">
		<a href="{{route('admin.products.create')}}" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i>  New Product</a>
	</div>
	<div class="clearfix"></div>
	<div class="card">
		<div class="card-header">List</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="table-products" class="table table-bordered" style="width:100%;cellpadding:0; cellspacing:0;">
						<thead>
						<tr>
						  <th scope="col">#ID</th>
						  <th scope="col">Client Name</th>
						  <th scope="col">Product Name</th>
						  <th scope="col">Category Name<i class="fa fa-arrow-right"></i> SubCategory Name</th>
						  <th scope="col">Status</th>
						  <th scope="col">Created At</th>
						  <th scope="col">Action</th>
						</tr>
					  </thead>
					  <tbody>
					  	
						@foreach ($dataList as $row)
								<?php $i=1; ?>
								
							<tr>
							  <td scope="row">{{$i++}}</td>
							  <td>{{$row->getClient->name}}</td>
							  <td>{{$row->name}}</td>
							 
							  @foreach($categoryAll as $category)
							    @foreach($getParentCategories as $parent)
                                @if(($row->category_id)==($category->id)&&(($category->parent)==($parent->id)))
							  <td>{{$parent->name}}->{{$row->getCategory->name}}</td>
							  @endif
							  @endforeach
							   @endforeach
							  <td>{{$row->getStatus->name}}</td>
							  <td>{{$row->created_at}}</td>
							  <td width="100px">
									<a href="{{route('admin.products.show',['id'=>$row->id])}}"><i class="fa fa-info-circle" title="View"></i></a>
									<a href="{{route('admin.products.edit',['id'=>$row->id])}}"><i class="fa fa-edit" title="Edit"></i></a>

									<i class="fa fa-trash-o btn-delete" title="Remove" data-id="{{$row->id}}"></i>

									<form id="delete-form-{{$row->id}}" action="{{ route('admin.products.delete' , ['id'=>$row->id] ) }}" method="POST" style="display: none;">
										{{ csrf_field() }}
										{{ method_field('DELETE') }}
										{{ csrf_field() }}
									</form>
								</td>
								
							</tr>
						
						@endforeach
					  </tbody>
					</table>
					{{-- $categories->links('pagination::bootstrap-4') --}}
				</div>
			</div>
		</div>	
	</div>	
</div>
@endsection
@section('script')
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#table-products').DataTable();

		
		jQuery(document).on("click",".btn-delete",function(event){
			var deletedId = jQuery(this).data("id");
			if(deletedId){
				if(confirm('Are you sure to delete?')){
					document.getElementById('delete-form-'+deletedId).submit();
				}
			}	
		});
	});

</script>
@endsection