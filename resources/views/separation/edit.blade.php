@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div class="row">
		<div class="col-md-12 col-xl-12">
			<h1 style="font-size: 24px">Edit Separation Details
			@role('hrms_hr')
				<a href="{{ route('separation-hr.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
			@endrole
			@role('hrms_subadmin')
				<a href="{{ route('separation-subadmin.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
			@endrole
			@role('hrms_admin')
				<a href="{{ route('separation-admin.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
			@endrole</h1>
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
		<form action="{{route('separation.update', $separation->id)}}" method="POST" >
			@csrf
			@method('PATCH')
				<div class="row">
					<div class="col-6 form-group">
						<label for="">Employee Name</label>
						<input type="text" class="form-control" name="emp_name" value="{{$separation->emp_name}}">
						@error('employee_name')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="col-6 form-group">
						<label for="emp_code">Employee Code</label>
						<input type="text" class="form-control" name="emp_code" value="{{$separation->emp_code}}">
						@error('emp_code')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="col-6 form-group ">
						<label for="">Requested On</label>
						<input type="text" class="form-control datepicker" name="requested_on" value="{{$separation->requested_on}}">
						@error('requested_on')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="col-6 form-group ">
						<label for="">Separation Date</label>
						<input type="text" class="form-control datepicker" name="separation_date" value="{{$separation->separation_date}}">
						@error('separation_date')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
						@enderror
					</div>
				</div>
				<div class="row">
					<div class="col-6 form-group">
							<label for="reason">Reason 
								@error('reason')
						          	<span style="color: red">
										| {{ $message }}
									</span>
						      	@enderror</label>
							<textarea  class="form-control" id="reason" name="reason" >{{$separation->reason}}</textarea>
						</div>
					<div class="col-6 form-group">
							<label for="short_description">Short Description 
								@error('short_description')
						          	<span style="color: red">
										| {{ $message }}
									</span>
						      	@enderror</label>
							<textarea  class="form-control" id="short_description" name="short_description" >{{$separation->short_description}}</textarea>
						</div>
					
					<div class="col-12 form-group text-center">
						<button class="btn btn-info btn-sm" style="width: 20%">SAVE</button>
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
		format: "mm-dd-yyyy",
		autoclose: true,
		todayHighlight: true
		});
</script>

@endsection
