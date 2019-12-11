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
      		<section class="invoice">
	           <div class="container-fluid">
				 <div id="form-area">
	              <div class="row col-12">
	                <div class="col-4">
	                	<div class="form-group">
							<label for=""><b>Company : </b></label>
							<td>{{$meta['company']->name}}</td>
						</div>
						<div class=" form-group">
							<label for=""><b>Department : </b></label>
							<td>{{$meta['department']->name}}</td>
						</div>
						<div class=" form-group">
							<label for=""><b>Employee Type : </b></label>
							<td>{{$meta['emptype']->name}}</td>
						</div> 
						<div class=" form-group">
							<label for=""><b>REPORTS TO : </b></label>
							<td>{{$meta['reportto']->emp_name}}</td>
						</div>	
                    </div>
                 	<div class="col-4">
	                	<div class="form-group">
							<label for=""><b>Employee Status : </b></label>
							<td>{{$meta['empstatus']->name}}</td>
						</div>
						<div class=" form-group">
							<label for=""><b>Joinning Date : </b></label>
							<td>{{$meta->join_dt}}</td>
						</div>
						<div class=" form-group">
							<label for=""><b>Leave Date : </b></label>
							<td>{{$meta->leave_dt}}</td>
						</div>	
                    </div>
                     <div class="col-4">
	                	<div class="form-group">
							<label for=""><b>Employee Code : </b></label>
							<td>{{$meta->emp_code}}</td>
						</div>
						<div class=" form-group">
							<label for=""><b>Employee Grade : </b></label>
							<td>{{$meta['empgrade']->name}}</td>
						</div>
						<div class=" form-group">
							<label for=""><b>Designation : </b></label>
							<td>{{$meta['designation']}}</td>
						</div>	
                    </div>
                </div>
                <div class="row mb-4">
	                <div class="col">
	                  	<h4 class="page-header"><i class="fa fa-globe"></i> NECESSARY DOCUMENTS</h4>
	                </div>
           		</div>
                <div class="row col-12">
                   <div class="col-4">
	                	<div class="form-group">
							<label for=""><b>Aadhaar Card No : </b></label>
							<td>{{$meta->aadhar_no}}</td>
						</div>
						<div class="form-group">
							<label for=""><b>Driving License No : </b></label>
							<td>{{$meta->driv_lic}}</td>
						</div>
						
                    </div>
                 <div class="col-4">
						<div class=" form-group">
							<label for=""><b>PAN Card No : </b></label>
							<td>{{$meta->join_dt}}</td>
						</div>
							
                    </div>
                     <div class="col-4">
                     	<div class=" form-group">
							<label for=""><b>Voter ID No: </b></label>
							<td>{{$meta->voter_id}}</td>
						</div>
                    </div>
                </div>
                <div class="row mb-4">
	                <div class="col">
	                  	<h4 class="page-header"><i class="fa fa-globe"></i> EMPLOYEE PROVIDENT FUND INFORMATION</h4>
	                </div>
	            </div>
                <div class="row col-12">
                   <div class="col-4">
	                	<div class="form-group">
							<label for=""><b>Old PF Number : </b></label>
							<td>{{$meta->old_pf}}</td>
						</div>
						<div class="form-group">
							<label for=""><b>New PF Number : </b></label>
							<td>{{$meta->curr_pf}}</td>
						</div>
						
                    </div>
                 <div class="col-4">
						<div class=" form-group">
							<label for=""><b>Old UAN Number : </b></label>
							<td>{{$meta->old_uan}}</td>
						</div>
						<div class=" form-group">
							<label for=""><b>New UAN Number: </b></label>
							<td>{{$meta->curr_uan}}</td>
						</div>	
                    </div>
                     <div class="col-4">
                     	<div class=" form-group">
							<label for=""><b>Old ESI Number: </b></label>
							<td>{{$meta->old_esi}}</td>
						</div>
						<div class=" form-group">
							<label for=""><b>New ESI Number: </b></label>
							<td>{{$meta->curr_esi}}</td>
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
