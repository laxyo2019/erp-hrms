@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div class="row">
			<div class="col-md-12 col-xl-12">
				<h1 style="font-size: 24px">Edit Leave application here
				<a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right" style="font-size:13px"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a></h1></h1>
			</div>
		</div>
	<div style="margin-top: 1.5rem; padding: 1.5rem; border: 1px solid grey;">
		@if($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				{{$message}}
			</div>
		@endif
			<form action="{{url('employee/leaves/'.$leaves->id)}}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PATCH')
				<div class="row">
					<div class="col-6 form-group">
							<label for="leave_type">Leave</label>
							<select name="leave_type_id" id="leave_type" class="custom-select">
								<option value="">Select</option>
								@foreach($leave_type as $types)
									<option value="{{ $types->id }}" {{old('leave_type_id', $leaves->leave_type_id) == $types->id ? 'selected' : ''}}>{{$types->name}}</option>
								@endforeach
							</select>
							@error('leave_type_id')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
							@enderror
						</div>
						<div class="col-6 form-group">
						<label for="team_lead">Reports To</label>
						<input type="text" id="team_lead" class="form-control" name="team_lead"	value="{{$leaves['reportsto']->emp_name}}" disabled>
						<input type="hidden" name="team_lead_id" value="{{-- {{$leaves['employees']->id}} --}}">
					</div>
						<div class="col-3 form-group">
						<label for="start_date">Start Date</label>
						<input type="text" class="form-control datepicker" name="start_date" autocomplete="off" value="{{old('start_date', $leaves->from)}}">
						@error('start_date')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-3 form-group">
						<label for="end_date">End Date</label>
						<input type="text" class="form-control datepicker" name="end_date"
							value="{{old('end_date', $leaves->to)}}" autocomplete="off">
						@error('end_date')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					
					<div class="col-7 form-group">
						<label for="reason">Reason</label>
						<textarea  class="form-control" id="reason" name="reason" >{{old('reason', $leaves->reason)}}
						</textarea>
						@error('reason')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-5 form-group">
						<label for="contact_no">Contact no</label>
						<input type="text" id="contact_no" class="form-control" name="contact_no" value="{{old('contact_no', $leaves->contact_no)}}">
						@error('contact_no')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-7 form-group">
						<label for="file_path">Upload Documents</label>
    					<input type="file" name="file_path" class="form-control-file" id="file_path" value="">
					</div>
					<div class="col-6 form-group">
						<label for="address_leave">Address During Leave</label>
						<textarea class="form-control" id="address_leave" name="address_leave"	>{{old('address_leave', $leaves->addr_during_leave)}}</textarea>
						@error('address_leave')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-6 form-group">
						<label for="applicant_remark">Applicant's Remark</label>
						<textarea class="form-control" id="applicant_remark" name="applicant_remark">{{old('applicant_remark', $leaves->applicant_remark)}}</textarea>
						@error('applicant_remark')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-12 form-group text-center">
						<button type="submit" class="btn btn-info btn-sm m-2" style="width: 40%">Save</button>
					</div>
				</div>
			</form>
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
		});
	</script>
@endsection
