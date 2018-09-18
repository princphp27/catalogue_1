@extends('client.layouts.app')
@section('pageTitle','Enquiry')
@section('content')
<div class="col-xl-12">
@include ('client.partials.messages')
@include ('client.partials.form-error-messages')
	<div class="card">
		<div class="card-header">Enquiry Table</div>
			<div class="card-body">
				<div class="table-responsive">
						 <table id="enquiry_table" class="table table-bordered" style="width:100%">
                           <thead>
					            <tr>
					                <th> ID</th>
					                 <th>Client Name</th>
					                 <th>Product Name</th>
					                 <th>Message</th>
					                  <th>Created</th>   
					            </tr>
					        </thead>
					      </table>
		            </div>	
		        </div>	
			</div>
		</div>	
@endsection
<script type="text/javascript" src="  https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script> -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
@section('script')

<script type="text/javascript">
$(document).ready(function(){
     $('#enquiry_table').DataTable({
		dom: 'Bfrtip',
        buttons: [
             'excel', 
        ],
        "processing": true,
        "serverSide": true,
        "ajax": "{{ route('client.enquiry.getdata') }}",
        "columns":[  
                     
            { "data": "id" },
            { "data": "client_name" },
            { "data": "product_name" },
            { "data": "message" },
            { "data": "created_at" },
           ],
     });
});
</script>
@endsection