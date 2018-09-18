@extends('client.layouts.app')
@section('pageTitle','Settings')
@section('content')
<div class="col-xl-12">
@include ('client.partials.messages')
@include ('client.partials.form-error-messages')
	<div class="card">
		<div class="card-header">Theme :: Edit</div>
			<div class="card-body">
				<div class="table-responsive">
					<form class="form-horizontal" action="{{route('client.theme.update')}}" method="post" enctype= "multipart/form-data">
						{!! csrf_field() !!}
						<input name="_method" type="hidden" value="PUT">

						<table class="table table-bordered" style="width: 100%;">
							<tr>
								<th width="20%">Color Code:</th>
								<td>
									<input type="text" class="form-control" name="color_code" placeholder="" value="{{old('color_code',($dataInfo) ? $dataInfo->color_code :'')}}">
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
</div>	
@endsection