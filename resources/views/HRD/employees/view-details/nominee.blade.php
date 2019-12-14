{{-- Created by kishan developer............ --}}

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
				 	@foreach($employee['nominee'] as $nominees)
	              <div class="row col-12">
	                <div class="col-4">
	                	<div class="form-group">
							<label for=""><b>Nominee's Name : </b></label>
							<td>{{$nominees->name}}</td>
						</div>
					 	<div class=" form-group">
							<label for=""><b>Nominee's Email : </b></label>
							<td>{{$nominees->email}}</td>
						</div>
						<div class=" form-group">
							<label for=""><b>Nominee's Aadhaar No. : </b></label>
							<td>{{$nominees->aadhar_no}}</td>
						</div>
                    </div>
                 	<div class="col-4">
	                	<div class="form-group">
							<label for=""><b>Nominee's Contact : </b></label>
							<td>{{$nominees->contact}}</td>
						</div>
						<div class=" form-group">
							<label for=""><b>Nominee's Relation : </b></label>
							<td>{{$nominees->relation}}</td>
						</div>	
                    </div>
                     <div class="col-4">
	                	<div class="form-group">
							<label for=""><b>Nominee's Documents : </b></label>
							<td><a href="{{route('employees.download', ['db_table' => 'emp_nominee', $nominees->id])}}"><i class="fa fa-arrow-down" ></i> Download</a></td>
						</div>
						<div class=" form-group">
							<label for=""><b>Nominee's Address : </b></label>
							<td>{{$nominees->addr}}</td>
						</div>
					</div>
              </div>
		  		@endforeach
            </section>
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
