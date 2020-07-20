@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div style="padding: 1.5rem; " class="tile">
		@include ('HRD/employees/view-tabs')<br>
		<div class="container-fluid">
			@if(!empty($employee->experiences))
				@php $count = 0;@endphp
				@foreach($employee->experiences as $exp)
				<div class="row mb-2">
	                <span style="color: grey; font-size: 20px; font-weight: bold"><i style="font-size: 15px;" class="fa fa-globe"></i> Company - {{++$count}}</span>
	       		</div><hr>
				<div class="row col-12">
	            	<div class="col-6 form-group">
						<b>Company Name : </b>
						{{strtoupper($exp->comp_name)}}
					</div>
					<div class="col-6 form-group">
						<b>Job Type : </b>
						{{strtoupper($exp->job_type)}}
					</div>
					<div class="col-6 form-group">
						<b>Monthly CTC : </b>
						{{$exp->monthly_ctc}}
					</div> 
					<div class="col-6 form-group">
						<b>Designation : </b>
						{{strtoupper($exp->desg)}}
					</div>
					<div class="col-6 form-group">
						<b>Company Location : </b>
						{{strtoupper($exp->comp_loc)}}
					</div>
					<div class="col-6 form-group">
						<b>Experience Certificate : </b>
						@if($exp->file_path != null)
							<a href="{{route('employees.download', ['db_table' => 'hrms_emp_exp', $exp->id])}}"><i class="fa fa-arrow-down"></i>Download</a>
						@else
							Not Available
						@endif
					</div>	
					<div class="col-6 form-group">
						<b>Start Date : </b>
						{{$exp->start_dt}}
					</div>
					<div class="col-6 form-group">
						<b>End Date : </b>
						{{$exp->end_dt}}
					</div>
					<div class="col-6 form-group">
						<b>Company Email : </b>
						{{$exp->comp_email}}
					</div>
					<div class="col-6 form-group">
						<b>Company Website : </b>
						{{$exp->comp_website}}
					</div>
					<div class="col-6 form-group">
						<b>Total Experience (In Years) : </b>
						{{$exp->total_exp}}
					</div>
					<div class="col-6 form-group">
						<b>Reason of Leaving : </b>
						{{$exp->reason_of_leaving}}
					</div>
				</div>
				@endforeach
			@endif
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
