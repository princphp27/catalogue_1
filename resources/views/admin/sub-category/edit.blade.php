@extends('admin.layouts.adminApp')
@section('pageTitle','Sub Categories')
@section('content')
<div class="col-xl-12">
	@include ('admin.partials.messages')
	@include ('admin.partials.form-error-messages')
	<div class="card">
		<div class="card-header">Edit</div>
		<div class="card-body">
			<div class="table-responsive">
				<form class="form-horizontal" action="{{route('admin.sub-categories.update',['id'=>$category->id])}}" method="post" enctype= "multipart/form-data">
					{!! csrf_field() !!}
					<input name="_method" type="hidden" value="PUT">

					<table class="table table-bordered" style="width: 100%;">
						<tr>

							<th width="20%">Parent Category:</th>
							<td>
								<select class="form-control" name="parent" placeholder="Select parent category">
									<option value="">---Select---</option>

									@foreach ($parentCategories as $pCat)
										<option value="{{$pCat->id}}" {{($category->parent == $pCat->id)?"SELECTED":""}}>{{$pCat->name}}</option>
									@endforeach
							  </select>
							</td>
						</tr>
						<tr>

							<th>Sub Category Name::</th>

							<td>
								<input type="text" class="form-control" id="name" name="name" placeholder="Enter category name" value="{{$category->name}}">
							</td>
						</tr>
						<tr>
							<th>Image:</th>
							<td>
								<img src="{{my_asset('storage/uploads/category_images')}}/{{($category->image)}}" width="150px" height="100px"/>
								<input type="file" class="form-control" id="image" name="image" placeholder="Select image file">
							</td>
						</tr>
						<tr>
							<th>Status:</th>
							<td>
								<label class="radio-inline"><input type="radio" name="status" value="1" checked="checked"> Active</label>
								<label class="radio-inline"><input type="radio" name="status" value="0" {{($category->status == 0)?'checked="checked"':''}}> Inactive</label>
							</td>
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