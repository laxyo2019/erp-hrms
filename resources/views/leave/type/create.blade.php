@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div class="row">
			<div class="col-md-12 col-xl-12">
				<h1 style="font-size: 24px">Create Leave here
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
			<form action="{{route('types.store')}}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="row">
					<div class="col-6 form-group">
						<label for="leave_name">Leave Name</label>
						<input type="text" id="leave_name" class="form-control" name="leave_name" value="{{old('leave_name')}}">
						@error('leave_name')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-6 form-group">
						<label for="total_leaves">Total leaves</label>
						<input type="text" class="form-control" name="total_leaves" id="total_leaves" value="{{old('total_leaves')}}">
						@error('total_leaves')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					{{-- <div class="col-6 form-group">
						<label for="generate_after">Generate after</label>
						<input type="text" class="form-control" name="generate_after" id="generate_after" value="{{old('generate_after')}}">
						@error('generate_after')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div> --}}
					<div class="col-6 form-group">
						<label for="min_apply_once">Can be applied min once</label>
						<input type="text" class="form-control" name="min_apply_once" id="min_apply_once" value="{{old('min_apply_once')}}">
						@error('min_apply_once')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-6 form-group">
						<label for="max_apply_once">Can be applied max once</label>
						<input type="text" class="form-control" name="max_apply_once" id="max_apply_once" value="{{old('max_apply_once')}}">
						@error('max_apply_once')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-4 form-group">
						<label for="max_days_inmonth">Maximum days in a month</label>
						<input type="text" class="form-control" name="max_days_inmonth" id="max_days_inmonth" value="{{old('max_days_inmonth')}}">
						@error('max_days_inmonth')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-4 form-group">
						<label for="max_apply_month">Maximum time can be appied in month</label>
						<input type="text" class="form-control" name="max_apply_month" id="max_apply_month" value="{{old('max_apply_month')}}">
						@error('max_apply_month')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-4 form-group">
						<label for="max_apply_year">Can be applied max in year</label>
						<input type="text" class="form-control" name="max_apply_year" id="max_apply_year" value="{{old('max_apply_year')}}">
						@error('max_apply_year')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-3 form-group">
						<div><h5>Can be carry forward</h5></div>
            			<div class="toggle lg row col-12">
            				<div class="form-check form-check-inline mr-0">
								<label>
									<input type="checkbox" name="carry" value="1"><span class="button-indecator"></span>
								</label>
							</div>
            			</div>
					</div>
					<div class="col-3 form-group">
						<div><h5>Document required</h5></div>
            			<div class="toggle lg row col-12">
            				<div class="form-check form-check-inline mr-0">
								<label>
									<input type="checkbox" name="docs_required" value="1" ><span class="button-indecator"></span>
								</label>
							</div>
            			</div>
					</div>
		    	</div>
		    		<div class="col-12 form-group text-center">
						<button class="btn btn-info btn-sm m-2" style="width: 30%">Save</button>
						<a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 30%">Clear</a>
					</div>
				</div>
			</form>
	</main>

@endsection
