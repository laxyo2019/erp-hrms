@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
@include ('HRD/employees/view-tabs')
<div style="margin-top: 1.5rem; padding: 1.5rem;"  class="tile">
	<div class="row mt-2">
  		<div class="col-md-12">
        	<div class="container-fluid">
			 	@php $count = 0; @endphp
			 	@foreach($employee['nominee'] as $nominees)
			 	<div class="row ">
	                <span style="color: grey; font-size: 20px;  font-weight: bold"><i class="fa fa-globe"></i> Nominee - {{++$count}}
	                </span>
           		</div>
		 		<hr>
              	<div class="row col-12">
                	<div class="col-6 form-group">
						<label for=""><b>Nominee's Name : </b></label>
						{{$nominees->name}}
					</div>
				 	<div class="col-6 form-group">
						<label for=""><b>Nominee's Email : </b></label>
						{{$nominees->email}}
					</div>
					<div class="col-6 form-group">
						<label for=""><b>Nominee's Aadhaar No. : </b></label>
						{{$nominees->aadhar_no}}
					</div>		                 	
                	<div class="col-6 form-group">
						<label for=""><b>Nominee's Contact : </b></label>
						{{$nominees->contact}}
					</div>
					<div class="col-6 form-group">
						<label for=""><b>Nominee's Relation : </b></label>
						{{$nominees->relation}}
					</div>		                    
                	<div class="col-6 form-group">
						<label for=""><b>Nominee's Documents : </b></label>
						<a href="{{route('employees.download', ['db_table' => 'hrms_emp_nominee', $nominees->id])}}"><i class="fa fa-arrow-down" ></i> Download</a>
					</div>
					<div class="col-6 form-group">
						<label for=""><b>Nominee's Address : </b></label>
						{{$nominees->addr}}
					</div>	                	
				</div>
	  			@endforeach
	  		</div>
	  	</div>
	</div>
</div>
</main>
<script>
$(document).ready(function(){
	$('.nominee').addClass('active');
	$('.datepicker').datepicker({
		orientation: "bottom",
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true
	});
});
</script>
	@endsection
