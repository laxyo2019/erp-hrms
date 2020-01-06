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
						<label for="total_leaves">Total leaves</label>
						<input type="text" class="form-control" name="total_leaves" autocomplete="off" id="total_leaves" value="{{$leave_type->total}}">
						@error('total_leaves')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					{{-- <div class="col-6 form-group">
						<label for="generate_after">Generate after</label>
						<input type="text" class="form-control" name="generate_after"
						autocomplete="off" id="generate_after" value="{{$leave_type->generates_in}}">
						@error('generate_after')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div> --}}
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
					<div class="col-6 form-group">
						<label for="max_days_inmonth">Maximum days in a month</label>
						<input type="text" class="form-control" name="max_days_inmonth"
						autocomplete="off" id="max_days_inmonth" value="{{$leave_type->max_days_month}}">
						@error('max_days_inmonth')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-6 form-group">
						<label for="max_apply_month">Can be applied max in month</label>
						<input type="text" class="form-control" name="max_apply_month"
						autocomplete="off" id="max_apply_month" value="{{$leave_type->max_apply_month}}">
						@error('max_apply_month')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-6 form-group">
						<label for="max_apply_year">Can be applied max in year</label>
						<input type="text" class="form-control" name="max_apply_year"
						autocomplete="off" id="max_apply_year" value="{{$leave_type->max_apply_year}}">
						@error('max_apply_year')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
				</div>
				<div class="row">
					<div class="col-4 form-group">
						<div><h5>Can be carry forward</h5></div>
            			<div class="toggle lg row col-12">
            				<div class="form-check form-check-inline mr-0">
								<label>
									<input type="checkbox" name="carry" value="1" {{ !empty($leave_type->carry_forward) ? 'checked' : ''}}><span class="button-indecator"></span>
								</label>
							</div>
            			</div>
					</div>
					<div class="col-4 form-group">
						<div><h5>Document required</h5></div>
            			<div class="toggle lg row col-12">
            				<div class="form-check form-check-inline mr-0">
								<label>
									<input type="checkbox" name="docs_required" value="1" {{!empty($leave_type->docs_required) ? 'checked' : ''}}><span class="button-indecator"></span>
								</label>
							</div>
            			</div>
					</div>
					<div class="col-4 form-group">
						<div><h5>Leave w/o Pay</h5></div>
            			<div class="toggle lg row col-12">
            				<div class="form-check form-check-inline mr-0">
								<label>
									<input type="checkbox" name="docs_required" value="1" {{!empty($leave_type->without_pay) ? 'checked' : ''}}><span class="button-indecator"></span>
								</label>
							</div>
            			</div>
					</div>
		    	</div>
	    		<div class="col-12 form-group text-center">
					<button class="btn btn-info btn-sm m-2" style="width: 40%">Save</button>
				</div>
				</div>
			</form>
	</main>

@endsection
