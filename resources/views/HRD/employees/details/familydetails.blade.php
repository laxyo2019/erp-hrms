@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
@include ('HRD/employees/tabs')
<div style="margin-top: 1.5rem; padding: 1.5rem;" class="tile">
	@if($message = Session::get('success'))
	<div class="alert alert-success alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>
		{{$message}}
	</div>
	@endif 
		<form action="{{ route('employees.familydetails', ['user_id' => $employee->user_id]) }}" method="POST">
			@csrf
			<div class="row">
				<div class="col-6 form-group">
					<label for="">Father's Name</label>
					<input type="text" class="form-control" name="father_name" value="{{old('father_name', !empty($employee['family']->father_name)?$employee['family']->father_name : '' )}}">
					@error('father_name')
	          <span class="text-danger" role="alert">
	            <strong>* {{ $message }}</strong>
	          </span>
	      	@enderror
				</div>
				<div class="col-6 form-group">
						<label for="">Mother's Name</label>
						<input type="text" class="form-control" name="mother_name" value="{{ old('mother_name', !empty($employee['family']->mother_name) ? $employee['family']->mother_name : '' ) }}">
						@error('mother_name')
		          <span class="text-danger" role="alert">
		            <strong>* {{ $message }}</strong>
		          </span>
		      	@enderror
					</div>
				
				<div class="col-6 form-group">

					<label for="">Husban's Name</label>
					<input type="text" class="form-control" name="husband_name" value="{{ old('husband_name', !empty($employee['family']->husband_name) ? $employee['family']->husband_name : '')}}">
					@error('husband_name')
	          <span class="text-danger" role="alert">
	            <strong>* {{ $message }}</strong>
	          </span>
	      	@enderror
				</div>
				<div class="col-6 form-group">
					<label for="">Wife's Name</label>
					<input type="text" class="form-control" name="wife_name" value=	"{{ old('wife_name', !empty($employee['family']->wife_name) ? $employee['family']->wife_name : '')  }}">
					@error('wife_name')
	          <span class="text-danger" role="alert">
	            <strong>* {{ $message }}</strong>
	          </span>
	      	@enderror
				</div>
					<div class="col-6 form-group">
						<label for="">Brother's Name</label>
						<input type="text" class="form-control" name="brother_name" value="{{ old('brother_name', !empty($employee['family']->brother_name) ? $employee['family']->brother_name : '') }}">
						@error('brother_name')
		          	<span class="text-danger" role="alert">
		           		<strong>* {{ $message }}</strong>
		          	</span>
		      		@enderror
					</div>
					<div class="col-6 form-group">
				    	<label for="">Sister's Name</label>
				    	<input type="text" class="form-control" name="sister_name" value="{{ old('sister_name', !empty($employee['family']->sister_name) ? $employee['family']->brother_name : '') }}">
				    	@error('sister_type')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
						@enderror
				    </div>
				</div>
				<div class="col-12 form-group text-center">
					<button class="btn btn-info btn-sm" style="width: 20%">Save</button>
					<a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 20%">Cancel</a>
				</div>
			</div>
			<input type="hidden" id="form_type" value="experiences">
		</form>
		
	</div>
</main>
<script>
	/*$(document).ready(function(){
		$('.nominee').addClass('active');
		$('.datepicker').datepicker({
			orientation: "bottom",
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true
		});
	});*/
</script>
@endsection
