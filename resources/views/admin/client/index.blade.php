@extends('admin.layouts.adminApp')
@section('pageTitle','Clients')

@section('content')
<div class="col-xl-12">
	@include ('admin.partials.messages')
	@include ('admin.partials.form-error-messages')
	
	<div class="btn-group pull-right">
		<a href="{{route('admin.clients.create')}}" class="btn btn-primary">New Client</a>

	</div>
	<div class="clearfix"></div>
	<div class="card">
		<div class="card-header">List</div>
		<div class="card-body">
			<div class="table-responsive">
				<table id="table-list" class="table table-bordered" style="width:100%;cellpadding:0; cellspacing:0;">
				  <thead>
					<tr>
					  <th>#ID</th>

					  <th>Name</th>
					  <th>Phone</th>
					  <th>Email</th>
					  <th>Contact</th>
					  <th>Contact mobile</th>
					  <th>Contact Email</th>
					  <!-- <th>Client Key</th> -->
					  <th>Status</th>
					  <th>Action</th>
					</tr>
				  </thead>
				  <tbody>
					@if($dataList && count($dataList)>0)
						@foreach ($dataList as $row)
							<tr>
							  <th scope="row">{{$row->id}}</th>


							  <td>{{$row->name}}</td>
							  <td>{{$row->phone}}</td>
							  <td>{{$row->email}}</td>
							  <td>{{$row->contact_name}}</td>
							  <td>{{$row->contact_mobile}}</td>
							  <td>{{$row->contact_email}}</td>
							   <!-- <td>{{$row->client_key}}</td> -->
							  <td>{{$row->getStatus->name}}</td>
							  <td width="80px">

								<a href="{{route('admin.clients.show',['id'=>$row->id])}}"><i class="fa fa-info-circle" title="View"></i></a>
								<a href="{{route('admin.clients.edit',['id'=>$row->id])}}"><i class="fa fa-edit" title="Edit"></i></a>
								<a href="{{route('admin.clients.delete',['id'=>$row->id])}}"><i class="fa fa-trash-o btn-delete" title="Remove" data-id="{{$row->id}}"></i></a>

							</td>
							</tr>
						@endforeach
					@endif	
				  </tbody>
				</table>
				{{-- $users->links('pagination::bootstrap-4') --}}
			</div>
		</div>	
	</div>	
</div>

@endsection
@section('script')
<script type="text/javascript">
	jQuery(document).ready(function() {

		jQuery('#table-list').DataTable();

	} );
</script>
@endsection