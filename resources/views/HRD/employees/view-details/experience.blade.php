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
					@if(!empty($employee->experiences))
						@php $count = 1;@endphp
						@foreach($employee->experiences as $exp)
						<h4>Company - {{$count++}}</h4><hr>
						<div class="row">	
		                	<div class="col-6 form-group">
								<b>Company Name : </b>
								<td>{{$exp->comp_name}}</td>
							</div>
							<div class="col-6 form-group">
								<b>Job Type : </b>
								<td>{{$exp->job_type}}</td>
							</div>
							<div class="col-6 form-group">
								<b>Monthly CTC : </b>
								<td>{{$exp->monthly_ctc}}</td>
							</div> 
							<div class="col-6 form-group">
								<b>Designation : </b>
								<td>{{$exp->desg}}</td>
							</div>
							<div class="col-6 form-group">
								<b>Company Location : </b>
								<td>{{$exp->comp_loc}}</td>
							</div>
							<div class="col-6 form-group">
								<b>Company Email : </b>
								<td>{{$exp->comp_email}}</td>
							</div>
							<div class="col-6 form-group">
								<b>Company Website : </b>
								<td>{{$exp->comp_website}}</td>
							</div>
							<div class="col-6 form-group">
								<b>Documents : </b>
								<td>{{$exp->comp_website}}</td>
							</div>	
							<div class="col-6 form-group">
								<b>Start Date : </b>
								<td>{{$exp->start_dt}}</td>
							</div>
							<div class="col-6 form-group">
								<b>End Date : </b>
								<td>{{$exp->end_dt}}</td>
							</div>
							<div class="col-6 form-group">
								<b>Reason of Leaving : </b>
								<td>{{$exp->domain_of_study}}</td>
							</div>
						</div>
	        			@endforeach
					@endif
				</div>
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
