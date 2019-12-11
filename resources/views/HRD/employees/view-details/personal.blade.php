{{-- Created by kishan Developer --}}
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
      <section class="invoice">
	        <div class="container-fluid">
				<div id="form-area">
	              <div class="row col-12">
	                <div class="col-4">
	                	<div class="form-group">
							<label for=""><b>Full Name : </b></label>
							<td>{{$employee->emp_name}}</td>
						</div>
						<div class=" form-group">
							<label for=""><b>Date of Birth : </b></label>
							<td>{{$employee->emp_dob}}</td>
						</div>
	                </div>
                    <div class="col-4">
	                	<div class=" form-group">
							<label for=""><b>Gender : </b></label>
							<td>{{$employee->emp_gender}}</td>
						</div> 
                    </div>
                     <div class="col-4">
						<div class=" form-group">
							<label for=""><b>Blood Group : </b></label>
							<td>{{$employee->blood_grp}}</td>
						</div>		
                    </div>
                 	</div>
	                <div class="row mb-4">
		                <div class="col">
		                  	<h4 class="page-header"><i class="fa fa-globe"></i> CONTACT INFORMATION</h4>
		                </div>
	           		</div>
	           		<div class="row col-12">
                    <div class="col-4">
	                	<div class="form-group">
							<label for=""><b>Contact Number : </b></label>
							<td>{{$employee->contact}}</td>
						</div>
						<div class=" form-group">
							<label for=""><b>Alternate Contact Number : </b></label>
							<td>{{$employee->alt_contact}}</td>
						</div>
						<div class=" form-group">
						<label>
		                	<input type="checkbox" id="check-address" @if($employee->curr_addr==$employee->perm_addr) checked @endif>
		                	<span class="label-text">Permanent Residence same as current</span>
		            	</label>
		            	</div>
                    </div>
                    <div class="col-4">
	                	<div class=" form-group">
							<label for=""><b>Email : </b></label>
							<td>{{$employee->email}}</td>
						</div>
						<div class=" form-group">
							<label for=""><b>Alternate Email : </b></label>
							<td>{{$employee->alt_email}}</td>
						</div>  
                    </div>
                     <div class="col-4">
						<div class=" form-group">
							<label for=""><b>Current Residence : </b></label>
							<td>{{$employee->curr_addr}}</td>
						</div>
						<div class=" form-group">
							<label for=""><b>Permanent Residence : </b></label>
							<td>{{$employee->perm_addr}}</td>
						</div>			
                    </div>
                 </div>
	            </div>
	           </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </main>
<script type="text/javascript">
	$(document).ready(function(){
		$('.personal').addClass('active');
		$('.datepicker').datepicker({
			orientation: "bottom",
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true
			});
		// Initialize select2
		$("#reportsTo").select2();
		$(":input").each(function(){
		 var input = $(this); // This is the jquery object of the input, do what you will
		 console.log();
		});
	});
</script>
@endsection
{{-- End Created by kishan Developer --}}


