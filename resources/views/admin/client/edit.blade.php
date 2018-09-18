@extends('admin.layouts.adminApp')

@section('pageTitle','Clients')

@section('content')
<div class="col-xl-12">
	@include ('admin.partials.messages')
	@include ('admin.partials.form-error-messages')
	<div class="card">
		<div class="card-header">Edit</div>
		<div class="card-body">
			<div class="container">
				<form class="form-horizontal" action="{{route('admin.clients.update',['id'=>$dataInfo->id])}}" method="post">

					{!! csrf_field() !!}
					<input name="_method" type="hidden" value="PUT">

					<h5 class="card-title"><strong>Client Info</strong></h5>
					<hr/>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Name</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control" placeholder="Name" name="name" value="{{old('name',$dataInfo->name)}}"/>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Email</label>
								<div class="col-sm-8">
								  <input type="email" class="form-control" placeholder="Email" name="email" value="{{old('email',$dataInfo->email)}}"/>
								</div>
							</div>
						</div>
					</div>	
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Address</label>
								<div class="col-sm-8">
								  <textarea class="form-control" placeholder="Address" name="address">{{old('address',$dataInfo->address)}}</textarea>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">City</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control" placeholder="City" name="city" value="{{old('city',$dataInfo->city)}}"/>
								</div>
							</div>
						</div>	
					</div>	
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">State</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control" placeholder="State" name="state" value="{{old('state',$dataInfo->state)}}"/>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Pincode</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control" placeholder="Pincode" name="pincode" value="{{old('pincode',$dataInfo->pincode)}}"/>
								</div>
							</div>
						</div>	
					</div>	
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Phone</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control" placeholder="Phone" name="phone" value="{{old('phone',$dataInfo->phone)}}"/>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Description</label>
						<div class="col-sm-10">
						  <textarea class="form-control" placeholder="Discription" name="description">{{old('description',$dataInfo->description)}}</textarea>
						</div>
					</div>
					<?php
					$status = old('status',$dataInfo->status);
					?>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Status</label>
						<div class="col-sm-10">
							<label class="radio-inline"><input type="radio" name="status" value="1" checked="checked"> Active</label>
							<label class="radio-inline"><input type="radio" name="status" value="0"  <?php if($status == '0'){ echo 'checked="checked"';}?>> Inactive</label>
						</div>
					</div> 
					
					<hr/>
					<h5 class="card-title"><strong>Contact Info</strong></h5>
					<hr/>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Contact name</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control" placeholder="Name" name="contact_name" value="{{old('contact_name',$dataInfo->contact_name)}}"/>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Contact email</label>
								<div class="col-sm-8">
								  <input type="email" class="form-control" placeholder="Email" name="contact_email" value="{{old('contact_email',$dataInfo->contact_email)}}"/>
								</div>
							</div>
						</div>
					</div>	
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Contact mobile</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control" placeholder="Mobile" name="contact_mobile" value="{{old('contact_mobile',$dataInfo->contact_mobile)}}"/>
								</div>
							</div>
						</div>
					</div>	
					
					<hr/>
				
					<div class="clearfix">&nbsp;</div>
					<div class="form-group row">
						<div class="col-sm-10 text-center">
						  <button type="submit" class="btn btn-primary">Update</button>
						</div>
					</div>
				</form>
			</div>
		</div>	
  	</div>
</div>
@endsection