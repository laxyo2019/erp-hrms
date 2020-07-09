@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	
	<div style=" padding: 1.5rem; border: 1px solid white;background: white">
			<h1 style="font-size: 24px">Generate No Dues Request
				<a href="{{ route('no-dues-request.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Back</a>
		</h1>
		<div>
	    </div>
		{{-- @if($request->hr_approval == 0 ) --}}
		<form action="{{route('no-dues-request.store')}}" method="POST" >
			@csrf
		{{-- @endif --}}
			<h5>Employee Detail</h5><hr>
			<div class="row">
				<div class="col-6 form-group">
					<label for="">Employee Name</label>
					<input type="text" class="form-control" name="emp_name" value="{{-- {{old('emp_name' , $emp->emp_name )}} --}}" readonly="">
					
				</div>
				<div class="col-6 form-group">
					<label for="emp_code">Employee Code</label>
					<input type="text" class="form-control" name="emp_code" value="{{-- {{old('emp_code' , $emp->emp_code )}} --}}" readonly="">
					@error('emp_code')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
			</div>
			{{-- <h5>Resignation Detail</h5><hr> --}}
			<div class="row">
				<div class="col-6 form-group ">
					<label for="">Date of Joinning</label>
					<input type="text" class="form-control datepicker" name="date_join" value="{{-- {{$request->interest_rate}} --}}" id="date_join">
					@error('date_join')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>	
				<div class="col-6 form-group ">
					<label for="">Date of Leaving</label>
					<input type="text" name="date_leave" class="form-control datepicker" autocomplete="">
					@error('date_leave')
		                  <span class="text-danger" role="alert">
		                      <strong>{{ $message }}</strong>
		                  </span>
		              @enderror
				</div>
				<div class="col-12 form-group">
					<label for="assets_description">Name of the Assets/Articles 
						@error('assets_description')
				          	<span style="color: red">
								| {{ $message }}
							</span>
				      	@enderror</label>
					<textarea  class="form-control" id="assets_description" name="assets_description" >{{-- {{$request->reason}} --}}</textarea>
				</div>
			</div>
				<br><h4>Head of Department Approval</h4><hr>
				<div class="row card-body text-center">
					{{-- <span>Employee's Department Head</span><hr><br> --}}
					<div class="col-4">
						<h5>{{-- {{strtoupper($emp_hod->emp_name)}} --}} (Employee's Department Head)</h5>
						<div>321654987</div>
					</div>
					<div class="col-6" >
						<h5>Requested Date</h5>
						<div>321654987</div>
					</div>
					<div class="col-6" >
						<h5>Requested Date</h5>
						<div>321654987</div>
					</div>
				{{-- </div>
				<div class="row card-body text-center"> --}}
					{{-- <span>Employee's Department Head</span><hr><br> --}}
					<div class="col-4">
						<h5>Loan Type</h5>
						<div>321654987</div>
					</div>
					<div class="col-4" >
						<h5>Requested Date</h5>
						<div>321654987</div>
					</div>
					<div class="col-4" >
						<h5>Requested Date</h5>
						<div>321654987</div>
					</div>
				</div>
				

			
			
			{{-- @if($request->hr_approval == 0 ) --}}	
				<div class="col-12 form-group text-center">
					<button class="btn btn-info btn-sm" style="width: 20%">SAVE</button>
					{{-- <a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 30%">Cancel</a> --}}
				</div>
			{{-- @endif --}}
			</div>		
			</div>
			<br>
		{{-- @if($request->hr_approval != 0 ) --}}
			</form>
		{{-- @endif --}}
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
