@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div class="row">
			<div class="col-md-12 col-xl-12">
				<h1 style="font-size: 24px">Edit Leaves here
				<a href="{{ route('types.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a></h1>
			</div>
		</div>
	<div style="margin-top: 1.5rem; padding: 1.5rem; border: 1px solid grey;">
		@if($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				{{$message}}
			</div>
		@endif 
			<form action="{{route('types.update', [$leave_type->id])}}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PATCH')
				<div class="row">
					<div class="col-6 form-group">
						<label for="leave_name">Leave Name</label>
						<input type="text" id="leave_name" class="form-control" name="leave_name" value="{{$leave_type->name}}">
						@error('leave_name')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-6 form-group">
						<label for="leave_alias">Leave Alias</label>
						<input type="text" id="leave_alias" class="form-control" name="leave_alias" value="{{$leave_type->alias}}">
						@error('leave_alias')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-6 form-group">
						<label for="total_leaves">Total leaves</label>
						<input type="text" class="form-control" name="total_leaves" autocomplete="off" id="total_leaves" value="{{$leave_type->count}}">
						@error('total_leaves')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-6 form-group">
						<label for="generate_after">Generate after</label>
						<input type="text" class="form-control" name="generate_after"
						autocomplete="off" id="generate_after" value="{{$leave_type->generates_in}}">
						@error('generate_after')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-6 form-group">
						<label for="min_apply_once">Can be applied min once</label>
						<input type="text" class="form-control" name="min_apply_once"
						autocomplete="off" id="min_apply_once" value="{{$leave_type->min_apply_once}}">
						@error('min_apply_once')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-6 form-group">
						<label for="max_apply_once">Can be applied max once</label>
						<input type="text" class="form-control" name="max_apply_once"
						autocomplete="off" id="max_apply_once" value="{{$leave_type->max_apply_once}}">
						@error('max_apply_once')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-4 form-group">
						<label for="max_days_inmonth">Maximum days in a month</label>
						<input type="text" class="form-control" name="max_days_inmonth"
						autocomplete="off" id="max_days_inmonth" value="{{$leave_type->max_days_month}}">
						@error('max_days_inmonth')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-4 form-group">
						<label for="max_apply_month">Can be applied max in month</label>
						<input type="text" class="form-control" name="max_apply_month"
						autocomplete="off" id="max_apply_month" value="{{$leave_type->max_apply_month}}">
						@error('max_apply_month')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-4 form-group">
						<label for="max_apply_year">Can be applied max in year</label>
						<input type="text" class="form-control" name="max_apply_year"
						autocomplete="off" id="max_apply_year" value="{{$leave_type->max_apply_year}}">
						@error('max_apply_year')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
<div class="col-5 form-group">
	<div class="form-check">
		<input type="checkbox" class="form-check-input" id="exampleCheck1"  name="carry" value="1" {{old('carry', $leave_type->carry_forward	) == '1' ? 'checked' : ''}}>
	    <label class="form-check-label" for="exampleCheck1">Can be carry forward ?</label>
	  </div>
</div>
		    	</div>
		    		<div class="col-12 form-group text-center">
						<button class="btn btn-info btn-sm m-2" style="width: 40%">Save</button>
						{{-- <a class="btn btn-danger btn-sm" type="submit" href="javascript:location.reload()" style="width: 30%">Clear</a> --}}
					</div>
				</div>
			</form>
	</main>

@endsection
