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
    				@php $count = 1;@endphp
    				@foreach($employee->bankdetails as $bank_details)
    				 <div class="row mb-3">
	                		<span style="color: grey; font-size: 20px; font-weight: bold"><i class="fa fa-globe"></i> Account Details - {{$count++}}</span>
           				</div><hr>	
	        		
						
	              		<div class="row col-12">
	                		
	                			<div class="col-6 form-group">
	                				<label for=""><b>Account Holder : </b></label>
									<td>{{ucwords($bank_details->acc_holder)}}</td>
								</div>
    						
    						
								<div class="col-6 form-group">
									<label for=""><b>Account Number : </b></label>
									<td>{{$bank_details->acc_no}}</td>
								</div>	
			                
			                
								<div class="col-6 form-group">
									<label for=""><b>Bank Name : </b></label>
									<td>{{ucwords($bank_details->bank_name)}}</td>
								</div>	
			                
			                
								<div class="col-6 form-group">
									<label for=""><b>IFSC Code : </b></label>
									<td>{{$bank_details->ifsc}}</td>
								</div>		
			                
			                
								<div class="col-6 form-group">
									<label for=""><b>Branch : </b></label>
									<td>{{ucwords($bank_details->branch_name)}}</td>
								</div>	
			                
			                
								<div class="col-6 form-group">
									<label for=""><b>Primary : </b></label>
									<td>{{$bank_details->is_primary}}</td>
								</div> 		
			                
			                @can('download documents')
			                
								<div class="col-6 form-group">
									<label for=""><b>Document : </b></label>
									<td>@if(!empty($bank_details->file_path))
									<a href="{{ route('employees.download', ['db_table'=>'hrms_emp_bank_details', $bank_details->id]) }}" ><i class="fa fa-arrow-down"></i>download</a>
									@else
									Not uploaded
									@endif
									</td>
								</div>
										
			                
			                @endcan
			                
								
								<div class="col-6 form-group">
									<label for=""><b>Note : </b></label>
									<td>{{$bank_details->note}}</td>
								</div>			
			                
			              </div>      
			        		<br>
			         
              @endforeach
              </div>
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
