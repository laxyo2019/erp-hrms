@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	
	<div style=" padding: 1.5rem; border: 1px solid white;background: white">
		{{-- <div class="col-md-12 col-xl-12"> --}}
			<h1 style="font-size: 24px">Add Allowance Here
				<a href="{{ route('by-department.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
		</h1>
		{{-- </div> --}}
		@if($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				{{$message}}
			</div>
		@endif 
		
		<form action="{{route('by-department.store')}}" method="POST" >
			@csrf
			<hr>
			<div class="row">
				<div class="col-6 form-group">
					<label for="welfare">Welfare</label>
					<select name="welfare" class="custom-select form-control select2">
						<option value="">Select Type</option>
							@foreach($welfare as $index)
								<option value="{{$index->id}}">{{ucwords($index->code)}} : {{ucwords($index->description)}}</option>
							@endforeach
					</select>
					@error('welfare')
		                  <span class="text-danger" role="alert">
		                      <strong>{{ $message }}</strong>
		                  </span>
		              @enderror
					
				</div>
				<div class="col-6 form-group">
					<label for="department">Department</label>
					<select name="department" class="custom-select form-control select2">
						<option value="">Select Type</option>
							@foreach($department as $index)
								<option value="{{$index->id}}">{{ucwords($index->name)}}</option>
							@endforeach
					</select>
					@error('department')
		                  <span class="text-danger" role="alert">
		                      <strong>{{ $message }}</strong>
		                  </span>
		              @enderror
				</div>
			</div>
			<div class="row">
				<div class="col-6 form-group ">
					<label for="value">Value</label>
					<input type="text" class="form-control" name="value" value="{{old('value')}}" id="value">
					@error('value')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
				<div class="col-6 form-group">
					<label for="percentage">% Of Basic</label>
					<input type="text" class="form-control" name="percentage" value="{{old('percentage')}}" id="percentage">
					@error('percentage')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
					<div class="col-6 form-group">
					<label for="active"><b>Active</b></label>
					<div class="input-group">
						<div class="input-group-prepend mt-1">
							<div class="animated-radio-button">
				              <label>
				                <input type="radio" value="1" name="active" class="mt-1 mr-1" {{old('active')}} ><span class="label-text">True</span>
				              </label>
				              <label class="ml-3">
				                <input type="radio" value="2" name="active" class="mt-1 mr-1 ml-3" {{old('active')}}><span class="label-text">False</span>
				              </label>
				            </div>
						</div>
					</div>							
					@error('active')
	                    <span class="text-danger" role="alert">
	                        <strong>{{ $message }}</strong>
	                    </span>
                	@enderror
				</div>
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
