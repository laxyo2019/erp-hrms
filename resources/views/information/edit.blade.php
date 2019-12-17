@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div class="row">
		<div class="col-md-12 col-xl-12">
			<h1 style="font-size: 24px">Update Basic information
			<a href="{{ route('information.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a></h1>
		</div>
	</div>
	<div style="margin-top: 1.5rem; padding: 1.5rem; border: 1px solid white;background: white">
		@if($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				{{$message}}
			</div>
		@endif 
		{{-- <div><h5>Write role name</h5></div><hr> --}}
		<form action="{{route('information.update', $info->id)}}" method="POST" >
			@csrf
			@method("PATCH")
			<div class="row">
				<div class="row">
					<div class="col-6 form-group">
						<label for="">Employee Name</label>
						<input type="text" class="form-control" name="emp_name" value="{{old('employee_name', $info->emp_name)}}">
						@error('employee_name')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="col-6 form-group">
						<label for="name"><b>Gender</b> </label>
							<div class="input-group">
								<div class="input-group-prepend mt-1">
									<div class="animated-radio-button">
						              <label>
						                <input type="radio" value="M" name="emp_gender" class="mt-1 mr-1" {{old('emp_gender',$info->emp_gender) == 'M' ? 'checked' : ''}} ><span class="label-text">Male</span>
						              </label>
						              <label class="ml-3">
						                <input type="radio" value="F" name="emp_gender" class="mt-1 mr-1 ml-3" {{old('emp_gender',$info->emp_gender) == 'F' ? 'checked' : ''}}><span class="label-text">Female</span>
						              </label>
						              <label class="ml-3">
						                <input type="radio" value="O" name="emp_gender" class="mt-1 mr-1 ml-3" {{old('emp_gender',$info->emp_gender) == 'O' ? 'checked' : ''}} ><span class="label-text">Other</span>
						              </label>
						            </div>
								</div>
							</div>
					</div>
					<div class="col-6 form-group ">
						<label for="">Date of Birth</label>
						<input type="text" class="form-control datepicker" name="dob" value="{{old('dob', $info->emp_dob)}}">
						@error('dob')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="col-6 form-group ">
						<label for="">Contact No.</label>
						<input type="text" class="form-control" name="contact" value="{{old('contact', $info->contact)}}">
						@error('contact')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="col-6 form-group ">
						<label for="">Email ID</label>
						<input type="text" class="form-control" name="email" value="{{old('email', $info->email)}}">
						@error('email')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="col-6 form-group ">
						<label for="">Address</label>
						<input type="text" class="form-control" name="address" value="{{old('address', $info->address )}}">
						@error('address')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="col-12 form-group text-center">
						<button class="btn btn-info btn-sm" style="width: 40%">Save</button>
						{{-- <a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 30%">Cancel</a> --}}
					</div>
				</div>			
			</div>
			<br>
			
		</form>
	</div>
</main>

<script type="text/javascript">
	$('.datepicker').datepicker({
		orientation: "bottom",
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true
		});
</script>

@endsection
