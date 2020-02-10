{{-- Created by kishan Developer --}}
@extends('layouts.master')
@push('styles')
	<script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
	<script src='{{asset('js/select2.min.js')}}' type='text/javascript'></script>
@endpush
@section('content')
<main class="app-content">
@include ('HRD/employees/view-tabs')
<div style="margin-top: 1.5rem; padding: 1.5rem; border: 1px solid grey;">
<div class="row mt-2">
  	<div class="col-md-12">
    	<div class="tile">
			<div class="container-fluid">
				<div class="row mb-3">
	                <span style="color: grey; font-size: 20px; font-weight: bold"><i class="fa fa-globe"></i> NECESSARY DOCUMENTS</span>
           		</div><hr>
				<div class="row col-12">
					<div class="col-6 form-group">
						<label for=""><b>Company : </b></label>{{empty($meta['company']->name)?'': ucwords($meta['company']->name)}}
					</div>
					<div class="col-6 form-group">
						<label for=""><b>Department : </b></label>{{empty($meta['department']->name)?'': ucwords($meta['department']->name)}}
					</div>
					<div class="col-6 form-group">
						<label for=""><b>Employee Type : </b></label>{{empty($meta['emptype']->name)?'': ucwords($meta['emptype']->name)}}
					</div> 
					<div class="col-6 form-group">
						<label for=""><b>REPORTS TO : &nbsp</b></label>{{empty($meta['reportto']->emp_name)?'': ucwords($meta['reportto']->emp_name)}}</td>
					</div>
                	<div class="col-6 form-group">
						<label for=""><b>Employee Status : </b></label>
					{{empty($meta['empstatus']->name)?'':ucwords($meta['empstatus']->name)}}
					</div>
					<div class="col-6 form-group">
						<label for=""><b>Joinning Date : </b></label>
					{{empty($meta->join_dt)?'':$meta->join_dt}}</td>
					</div>
					<div class="col-6 form-group">
						<label for=""><b>Leave Date : </b></label>
					{{empty($meta->leave_dt)?'':$meta->leave_dt}}
					</div>
                	<div class="col-6 form-group">
						<label for=""><b>Employee Code : </b></label>
					{{empty($meta->emp_code)?'':$meta->emp_code}}
					</div>
					<div class="col-6 form-group">
						<label for=""><b>Employee Grade : </b></label>
					{{empty($meta['empgrade']->name)?'': ucwords($meta['empgrade']->name)}}
					</div>
					<div class="col-6 form-group">
						<label for=""><b>Designation : </b></label>
					{{empty($meta['designation']->name)?'': ucwords($meta['designation']->name)}}
					</div>	
                </div>
                <div class="row mb-4">
	                
	                  	<span style="color: grey; font-size: 20px; font-weight: bold"><i class="fa fa-globe"></i> NECESSARY DOCUMENTS</span>
	                
           		</div><hr>
                <div class="row col-12">
                	<div class="col-6 form-group">
						<label for=""><b>Aadhaar Card No : </b></label>
					{{empty($meta->aadhar_no)?'':$meta->aadhar_no}}
					</div>
					<div class="col-6 form-group">
						<label for=""><b>Driving License No : </b></label>
					{{empty($meta->driv_lic)?'':$meta->driv_lic}}
					</div>
					<div class="col-6 form-group">
						<label for=""><b>PAN Card No : </b></label>
					{{empty($meta->join_dt)?'':$meta->join_dt}}
					</div>
                 	<div class="col-6 form-group">
						<label for=""><b>Voter ID No: </b></label>
					{{empty($meta->voter_id)?'':$meta->voter_id}}
					</div>
                </div>
                <div class="row mb-4">
	               
	                  	<span style="color: grey; font-size: 20px; font-weight: bold"><i class="fa fa-globe"></i> EMPLOYEE PROVIDENT FUND INFORMATION</span>
	                
	            </div><hr>
                <div class="row col-12">
                	<div class="col-6 form-group">
						<label for=""><b>Old PF Number : </b></label>
					{{empty($meta->old_pf)?'':$meta->old_pf}}
					</div>
					<div class="col-6 form-group">
						<label for=""><b>New PF Number : </b></label>
					{{empty($meta->curr_pf)?'':$meta->curr_pf}}
					</div>
					<div class="col-6 form-group">
						<label for=""><b>Old UAN Number : </b></label>
						{{empty($meta->old_uan)?'':$meta->old_uan}}
					</div>
					<div class="col-6 form-group">
						<label for=""><b>New UAN Number: </b></label>
					{{empty($meta->curr_uan)?'':$meta->curr_uan}}
					</div>
                 	<div class="col-6 form-group">
						<label for=""><b>Old ESI Number: </b></label>
					{{empty($meta->old_esi)?'':$meta->old_esi}}
					</div>
					<div class="col-6 form-group">
						<label for=""><b>New ESI Number: </b></label>
						{{empty($meta->curr_esi)?'':$meta->curr_esi}}
					</div>
                </div>
          </div>
       </div>
   </div>
</main>
<script type="text/javascript">
	$(document).ready(function(){
		$('.official').addClass('active');
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
