@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
@include ('HRD/employees/view-tabs')
<div style="margin-top: 1.5rem; padding: 1.5rem; " class="tile">
<div class="row mt-2 ">
  	<div class="col-md-12">
    		<div class="container-fluid">
					@if(!empty($employee->experiences))
						@php $count = 0;@endphp
						@foreach($employee['family'] as $family)
						<div class="row mb-2">
			                <span style="color: grey; font-size: 20px; font-weight: bold"><i class="fa fa-globe"></i> Family Member - {{++$count}}</span>
		           		</div><hr>
						<div class="row col-12">
		                	<div class="col-6 form-group">
								<b>Name : </b>
								{{strtoupper($family->name)}}
							</div>
							<div class="col-6 form-group">
								<b>Relation : </b>
								{{strtoupper($family->relation)}}
							</div>
							<div class="col-6 form-group">
								<b>Aadhar_id : </b>
								{{$family->aadhar_id}}
							</div> 
							<div class="col-6 form-group">
								<b>Document ( Aadhar Card ) : </b>
								@if($family->file_path != null)
									<a href="{{route('employees.download', ['db_table' => 'hrms_family_details', $family->id])}}"><i class="fa fa-arrow-down"></i>Download</a>
								@else
									Not Available
								@endif
							</div>							
						</div>
	        			@endforeach
					@endif			
		</div>
   	</div>
</main>
<script>
$(document).ready(function(){
	$('.familydetails').addClass('active');
	
});
</script>
@endsection
