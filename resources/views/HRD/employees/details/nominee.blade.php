@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content ">
	<div style="padding: 1.5rem;" class="tile">
		@include ('HRD/employees/tabs')<hr>
		@if($message = Session::get('success'))
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>
			{{$message}}
		</div>
		@endif 
			<form action="{{ route('employees.nominee', ['user_id' => $employee->user_id]) }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="row">
					<div class="col-6 form-group">
						<label for="">Nominee's Name</label>
						<input type="text" class="form-control" name="nominee_name" value="{{old('nominee_name')}}">
						@error('nominee_name')
		          <span class="text-danger" role="alert">
		            <strong>* {{ $message }}</strong>
		          </span>
		      	@enderror
					</div>
					<div class="col-6 form-group">
							<label for="">Nominee's Relation</label>
							<input type="text" class="form-control" name="relation" value="{{ old('relation') }}">
							@error('relation')
			          <span class="text-danger" role="alert">
			            <strong>* {{ $message }}</strong>
			          </span>
			      	@enderror
						</div>
					
					
					<div class="col-6 form-group">
						<label for="">Nominee's Aadhaar no.</label>
						<input type="text" class="form-control" name="aadhaar_no" value="{{ old('aadhaar_no') }}">
						@error('aadhaar_no')
		          <span class="text-danger" role="alert">
		            <strong>* {{ $message }}</strong>
		          </span>
		      	@enderror
					</div>
					<div class="col-6 form-group">
					    	<label for="">Nominee Type</label>
					    	<select name="nominee_type" id="nominee_type" class="custom-select form-control select2">
					    		<option value="">Please Select </option>
								@foreach($meta['nominee_types'] as $types)
								<option value="{{$types->id}}"  {{ old('nominee_type') }}>{{$types->name}}</option>
								@endforeach
					    	</select>
					    	@error('nominee_type')
								<span class="text-danger" role="alert">
									<strong>* {{ $message }}</strong>
								</span>
							@enderror
					    </div>
					<div class="col-6 form-group">

						<label for="">Nominee's Contact</label>
						<input type="text" class="form-control contact" name="contact" value="{{ old('contact')}}">
						@error('contact')
		          <span class="text-danger" role="alert">
		            <strong>* {{ $message }}</strong>
		          </span>
		      	@enderror
						
					</div>
						<div class="col-6 form-group">
							<label for="">Nominee's Email</label>
							<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							@error('email')
			          	<span class="text-danger" role="alert">
			           		<strong>* {{ $message }}</strong>
			          	</span>
			      		@enderror
						</div>
						
					<div class="col-6 form-group">
						<label for="file_path">Upload Documents</label>
    					<input type="file" name="file_path" class="form-control-file" id="file_path" value="{{ old('file_path')}}">
					</div>
					</div>
					<div class="col-12 form-group ">
				    	<label for="">Nominee's Permanent Address</label>
				    	<textarea name="address" id="address" class="form-control" cols="5" rows="5" value="{{old('address')}}"></textarea>
				    </div>
					<div class="col-12 form-group text-center">
						<button class="btn btn-info btn-sm" style="width: 20%">Save</button>
						<a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 20%">Cancel</a>
					</div>
				</div>
				<input type="hidden" id="form_type" value="experiences">
			</form>
			<hr>
			<table class="table table-striped table-hover table-bordered">
				<thead class="thead-dark">
					<tr>
						<th>#</th>
						<th>Nominee's Name</th>
						<th>Nominee's Email</th>
						<th>Nominee's Aadhaar No.</th>
						<th>Nominee's Contact</th>
						<th>Nominee's Relation</th>
						{{-- @can('download documents') --}}
							<th>Nominee's Document</th>
						{{-- @endcan --}}
						<th>Nominee's Address</th>
						<th class="text-center">Actions</th>
					</tr>
				</thead>
				<tbody id="experiencesTbody">
					@foreach($employee['nominee'] as $nominees)
					<tr>
						<td>{{$nominees->id}}</td>
						<td>{{$nominees->name}}</td>
						<td>{{$nominees->email}}</td>
						<td>{{$nominees->aadhar_no}}</td>
						<td>{{$nominees->contact}}</td>
						<td>{{$nominees->relation}}</td>
						{{-- @can('download documents') --}}
							<td>
							@if($nominees->file_path != null)
							<a href="{{route('employees.download', ['db_table' => 'hrms_emp_nominee', $nominees->id])}}"><i class="fa fa-arrow-down" ></i> Download</a>
							@else
								Not Available
							@endif
							</td>
						{{-- @endcan --}}
						<td>{{$nominees->addr}}</td>
						<td>
						<form action="{{ route('employee.delete_row', ['db_table' => 'hrms_emp_nominee' ,$nominees->id]) }}" method="GET" id="delform_{{ $nominees->id }}">
						<a href="javascript:$('#delform_{{ $nominees->id }}').submit();" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> Delete</a>
							</form>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@php
			//dd($employee['nominee']);
			@endphp
		</div>
	</main>
	<script>
		$(document).ready(function(){
			$('.nominee').addClass('active');
			
			$('body').on('focus', '.datepicker', function(){
			   $(this).datepicker({
			   		orientation: "auto",
					format: "mm-dd-yyyy",
					autoclose: true,
					todayHighlight: true
			   });
			});
		});
	</script>
	@endsection
