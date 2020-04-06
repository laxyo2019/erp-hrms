@extends('layouts.master')
@push('styles')
	<script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
	<script src='{{asset('js/select2.min.js')}}' type='text/javascript'></script>
@endpush
@section('content')
<main class="app-content ">

	<div style="margin-top: 1.5rem; padding: 1.5rem;" class="tile">
		<div class="row">
		<div class="col-md-12 col-xl-12">
			<h1 style="font-size: 24px">Recruitment Request Details
			<a href="{{ route('recruitment.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a></h1>
		</div>
	</div>
		@if($message = Session::get('success'))
		<div class="alert alert-success alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>
			{{$message}}
		</div>
		@endif
		<div id="form-area">
			<form action="{{route('recruitment.store')}}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="container-fluid">
					<div class="row">
						
						<div class="col-6 form-group">
							<label for="job_title">Job Title
							@error('job_title')
						          	<span style="color: red">
										| {{ $message }}
									</span>
						      	@enderror</label>
							<input type="text" name="job_title" value="{{old('job_title')}}" class="form-control">
						</div>
						<div class="col-6 form-group">
							<label for="company_name">Company
								@error('company_name')
						          	<span style="color: red">
										| {{ $message }}
									</span>
						      	@enderror</label>
							</label>
							<select name="company_name" class="form-control">
								<option value="">Select Company</option>
									@foreach($comps as $comp)
										<option value="{{$comp->id}}" >{{ucwords($comp->name)}}</option>
									@endforeach 
							</select>
							
						</div>
						<div class="col-6 form-group">
							<label for="city">City
								@error('city')
						          	<span style="color: red">
										| {{ $message }}
									</span>
						      	@enderror
							</label>
							<input type="text" name="city" value="{{old('city')}}" class="form-control">
						</div>
						<div class="col-6 form-group">
							<label for="postal_code">Postal Code</label>
							<input type="text" name="postal_code" value="{{old('postal_code')}}" class="form-control">
						</div>
						
						<div class="col-6 form-group">
							<label for="department">Department
								@error('department')
						          	<span style="color: red">
										| {{ $message }}
									</span>
						      	@enderror
							</label>
							<select name="department" id="department" class="form-control">
								<option value=""> Select Department </option>
								@foreach($departments as $department)
								<option value="{{$department->id}}" >{{ucwords($department->name)}}</option>
								@endforeach
							</select>
							{{-- @error('department')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
							@enderror --}}
						</div>
						<div class="col-6 form-group">
							<label for="employement_type">Employement Type
								@error('employement_type')
						          	<span style="color: red">
										| {{ $message }}
									</span>
						      	@enderror
							</label>
							<select name="employement_type" id="employement_type" class="form-control">
								<option value=""> Select Type </option>
								@foreach($empTypes as $empType)
								<option value="{{$empType->id}}" >{{ucwords($empType->name)}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-6 form-group">
							<label for="education_level">Education Level
								@error('education_level')
						          	<span style="color: red">
										| {{ $message }}
									</span>
						      	@enderror
							</label>
							<select name="education_level" id="education_level" class="form-control">
								<option value=""> Select here </option>
								@foreach($eduLevels as $eduLevel)
								<option value="{{$eduLevel->id}}">{{ucwords($eduLevel->name)}}</option>
								@endforeach
							</select>
							
						</div>
						<div class="col-6 form-group">
							<label for="experience_level">Experience Level
								@error('experience_level')
						          	<span style="color: red">
										| {{ $message }}
									</span>
						      	@enderror
							</label>
							<select name="experience_level" id="experience_level" class="form-control">
								<option value=""> Select Type </option>
								@foreach($expLevels as $expLevel)
								<option value="{{$expLevel->id}}">{{ucwords($expLevel->name)}}</option>
								@endforeach
							</select>
						</div>
						

						<div class="col-6 form-group">
							<label for="requirements">Job Requirements 
								@error('requirements')
						          	<span style="color: red">
										| {{ $message }}
									</span>
						      	@enderror</label>
							<textarea  class="form-control" id="requirements" name="requirements" >{{old('requriements')}}</textarea>
						</div>

						<div class="col-6 form-group">
							<label for="short_description">Short Description 
								@error('short_description')
						          	<span style="color: red">
										| {{ $message }}
									</span>
						      	@enderror</label>
							<textarea  class="form-control" id="short_description" name="short_description" >{{old('short_description')}}</textarea>
						</div>
					</div>
					<br>
					{{-- <div><h5>NECESSARY DOCUMENTS</h5></div><hr>
					<div class="row">
						<div class="col-6 form-group">
							<label for="">Aadhaar Card</label>
							<input type="text" name="aadhar_no" value="{{old('aadhar_no')}}" class="form-control" id="aadhar_no">
						</div>
						<div class="col-6 form-group">
							<label for="">PAN Card</label>
							<input type="text" name="pan_no" value="{{old('pan_no')}}" class="form-control" id="pan_no">
						</div>
						<div class="col-6 form-group">
							<label for="">Voter ID</label>
							<input type="text" name="voter_id" value="{{old('voter_id')}}" class="form-control" id="voter_id">
						</div>
						
						<div class="col-6 form-group">
							<label for="">Driving License</label>
							<input type="text" name="driv_lic" value="{{old('drive_lic')}}" class="form-control">
						</div>
							<div class="col-6 form-group">
							<label for="passport_id">Passport ID</label>
							<input type="text" name="passport_id" value="{{old('passport_id')}}" class="form-control">
						</div> 
						
					</div> --}}
					<br>
					
					<div class="col-12 form-group text-center">
						<button class="btn btn-info btn-sm" style="width: 20%">Update</button>
						<a class="btn btn-danger btn-sm" style="width: 20%" href="javascript:location.reload()">Cancel</a>
					</div>
				</div>
				<input type="hidden" name="form_type" id="form_type" value="official">
			</form>
		</div>
	</div>
	<div class="img_parent d-none">
		<img src="{{asset('images/loading1.gif')}}" alt="">
	</div>
</main>
@endsection
