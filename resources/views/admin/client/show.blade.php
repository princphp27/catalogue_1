@extends('admin.layouts.adminApp')

@section('pageTitle','Clients')

@section('content')
<div class="col-xl-12">
	@include ('admin.partials.messages')
	@include ('admin.partials.form-error-messages')
	<div class="card">
		<div class="card-header">Detail</div>
		<div class="card-body">
			<div class="container">
				<h5 class="card-title"><strong>Client Info</strong></h5>
					<hr/>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Name</label>
								<div class="col-sm-8">{{$dataInfo->name}}</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Email</label>
								<div class="col-sm-8">{{$dataInfo->email}}</div>
							</div>
						</div>
					</div>	
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Address</label>
								<div class="col-sm-8">{{$dataInfo->address}}</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">City</label>
								<div class="col-sm-8">{{$dataInfo->city}}</div>
							</div>
						</div>	
					</div>	
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">State</label>
								<div class="col-sm-8">{{$dataInfo->state}}</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Pincode</label>
								<div class="col-sm-8">{{$dataInfo->pincode}}</div>
							</div>
						</div>	
					</div>	
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Phone</label>
								<div class="col-sm-8">{{$dataInfo->phone}}</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Description</label>
						<div class="col-sm-10">{{$dataInfo->description}}</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Status</label>
						<div class="col-sm-10">{{$dataInfo->getStatus->name}}</div>
					</div> 
					
					<hr/>
					<h5 class="card-title"><strong>Contact Info</strong></h5>
					<hr/>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Contact name</label>
								<div class="col-sm-8">{{$dataInfo->contact_name}}</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Contact email</label>
								<div class="col-sm-8">{{$dataInfo->contact_email}}</div>
							</div>
						</div>
					</div>	
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Contact mobile</label>
								<div class="col-sm-8">{{$dataInfo->contact_mobile}}</div>
							</div>
						</div>
					</div>	
					
					<hr/>
					<h5 class="card-title"><strong>Login Info</strong></h5>
					<hr/>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Email</label>
								<div class="col-sm-8">{{$userInfo->email}}</div>
							</div>
						</div>
					</div>	
			</div>	
		</div>	
	</div> 
</div>
@endsection