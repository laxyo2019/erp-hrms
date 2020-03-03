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
				<div class="row">
	                <div class="col">
	                  	<h4 class="page-header" style="color: grey"><i class="fa fa-globe"></i> BASIC INFORMATION</h4>
	                </div>
           		</div><hr>
	            <div class="row col-12">
                	<div class="col-6 form-group">
						<label for=""><b>Full Name : </b></label>
						{{empty($employee->emp_name)?'':strtoupper($employee->emp_name)}}
					</div>
					<div class="col-6 form-group">
						<label for=""><b>Date of Birth : </b></label>
						{{empty($employee->emp_dob) ? '' : $employee->emp_dob}}
					</div>
                
                
                	<div class="col-6 form-group">
						<label for=""><b>Gender : </b></label>
						{{empty($employee->emp_gender) ? '' : strtoupper($employee->emp_gender)}}
					</div> 
                
                 
					<div class="col-6 form-group">
						<label for=""><b>Blood Group : </b></label>
					{{empty($employee->blood_grp) ? '' : $employee->blood_grp}}
					</div>
                </div>
                <div class="row mb-6">
	                <div class="col">
	                  	<h4 class="page-header" style="color: grey"><i class="fa fa-globe"></i> CONTACT INFORMATION</h4>
	                </div>
           		</div><hr>
	           		<div class="row col-12">
	                	<div class="col-6 form-group">
							<label for=""><b>Contact Number ( Provided by Company ): </b></label>
						{{empty($employee->comp_contact)?'':$employee->comp_contact}}
						</div>
						<div class="col-6 form-group">
							<label for=""><b>Contact No ( Personal ): </b></label>
						{{empty($employee->personal_contact) ? '' : $employee->personal_contact}}
						</div>
	                	<div class="col-6 form-group">
							<label for=""><b>Email ( Provided by Company ): </b></label>
						{{empty($employee->comp_email) ? '' : $employee->comp_email}}
						</div>
						<div class="col-6 form-group">
							<label for=""><b>Email ( Personal ): </b></label>
							{{empty($employee->personal_email)?'':$employee->personal_email}}
						</div>  
                  
                     
						<div class="col-6 form-group">
							<label for=""><b>Current Residence : </b></label>
							{{-- {{empty($employee->curr_addr)?'':$employee->curr_addr}} --}}
							{{empty($employee->curr_addr) ? '' : strtoupper($employee->curr_addr)}}
						</div>
						<div class="col-6 form-group">
							<label for=""><b>Permanent Residence : </b></label>
							{{empty($employee->perm_addr) ? '' : strtoupper($employee->perm_addr)}}
						</div>			
                    
                 </div>
	            </div>

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


