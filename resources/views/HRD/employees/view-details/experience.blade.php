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
	                @if(!empty($employee->experiences))
						@foreach($employee->experiences as $exp)
	                	<div class="form-group">
							<label for=""><b>Company Name : </b></label>
							<td>{{$exp->comp_name}}</td>
						</div>
						<div class=" form-group">
							<label for=""><b>Job Type : </b></label>
							<td>{{$exp->job_type}}</td>
						</div>
						<div class=" form-group">
							<label for=""><b>Monthly CTC : </b></label>
							<td>{{$exp->monthly_ctc}}</td>
						</div> 
						<div class=" form-group">
							<label for=""><b>Designation : </b></label>
							<td>{{$exp->desg}}</td>
						</div>	
                    </div>
                 	<div class="col-4">
	                	<div class="form-group">
							<label for=""><b>Company Location : </b></label>
							<td>{{$exp->comp_loc}}</td>
						</div>
						<div class=" form-group">
							<label for=""><b>Company Email : </b></label>
							<td>{{$exp->comp_email}}</td>
						</div>
						<div class=" form-group">
							<label for=""><b>Company Website : </b></label>
							<td>{{$exp->comp_website}}</td>
						</div>
						<div class=" form-group">
							<label for=""><b>Documents : </b></label>
							<td>{{$exp->comp_website}}</td>
						</div>	
                    </div>
                    <div class="col-4">
	                	<div class="form-group">
							<label for=""><b>Start Date : </b></label>
							<td>{{$exp->start_dt}}</td>
						</div>
						<div class=" form-group">
							<label for=""><b>End Date : </b></label>
							<td>{{$exp->end_dt}}</td>
						</div>
						<div class=" form-group">
							<label for=""><b>Reason of Leaving : </b></label>
							<td>{{$exp->domain_of_study}}</td>
						</div>	
                    </div>
                 </div>
               </div>
			  @endforeach
			 @else
			@endif
       		{{-- {{'sdfdsfdsf'}} --}}
           </section>
        </div>
       </div>
   </div>
</main>
<script>
$(document).ready(function(){
	$('.experience').addClass('active');
	$('.datepicker').datepicker({
		orientation: "bottom",
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true
	});
	$('.modalExp').on('click', function(e){
		e.preventDefault();
		var exp_id = $(this).data('id');
		$.ajax({
			type: 'GET',
			url: "{{route('exp_table')}}?exp_id="+exp_id,
			success:function(res){

				$('#modalTable').empty().html(res);
				$('#expModal').modal('show');
			}

		})
	})
});
</script>
@endsection
