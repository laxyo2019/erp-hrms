{{-- Created by kishan developer............ --}}

@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	@include ('HRD/employees/view-tabs')
	<div style="margin-top: 1.5rem; padding: 1.5rem; border: 1px solid grey;">
		<div class="row mt-2">
  			<div class="col-md-12">
    			<div class="tile">
	        		<div class="container-fluid">
							<div id="form-area">
						@foreach($employee->bankdetails as $bank_details)
	              		<div class="row col-12">
	                		<div class="col-4">
	                			<div class="form-group">
	                				<label for=""><b>Account Holder : </b></label>
									<td>{{$bank_details->acc_holder}}</td>
								</div>
    						</div>
    						<div class="col-4">
								<div class=" form-group">
									<label for=""><b>Account Number : </b></label>
									<td>{{$bank_details->acc_no}}</td>
								</div>	
			                </div>
			                <div class="col-4">
								<div class=" form-group">
									<label for=""><b>Bank Name : </b></label>
									<td>{{$bank_details->bank_name}}</td>
								</div>	
			                </div>
			                <div class="col-4">
								<div class=" form-group">
									<label for=""><b>IFSC Code : </b></label>
									<td>{{$bank_details->ifsc}}</td>
								</div>		
			                </div>
			                <div class="col-4">
								<div class=" form-group">
									<label for=""><b>Branch : </b></label>
									<td>{{$bank_details->branch_name}}</td>
								</div>	
			                </div>
			                <div class="col-4">
								<div class=" form-group">
									<label for=""><b>Primary : </b></label>
									<td>{{$bank_details->is_primary}}</td>
								</div> 		
			                </div>
			                @can('download documents')
			                <div class="col-4">
								<div class=" form-group">
									<label for=""><b>Document : </b></label>
									<td>@if(!empty($bank_details->file_path))
									<a href="{{ route('employees.download', ['db_table'=>'emp_bank_details', $bank_details->id]) }}" ><i class="fa fa-arrow-down"></i>download</a>
									@else
									Not uploaded
									@endif
									</td>
								</div>
										
			                </div>
			                @endcan
			                <div class="col-4">
								
								<div class=" form-group">
									<label for=""><b>Note : </b></label>
									<td>{{$bank_details->note}}</td>
								</div>			
			                </div>
			              </div>      
			        		</div><hr><br>
			         @endforeach
              </div>
{{-- >>>>>>> d653f27de7ca565a87df1f09c1eccf409aa23947 --}}
          	</div>
        	</div>
      	</div>
   	</main>
<script>
$(document).ready(function(){
	$('.bankdetails').addClass('active');
	$('.datepicker').datepicker({
		orientation: "bottom",
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true
	});
});
</script>
@endsection
