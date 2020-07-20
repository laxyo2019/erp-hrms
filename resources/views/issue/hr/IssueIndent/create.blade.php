@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div style=" padding: 1.5rem; border: 1px solid white;background: white">
			<h1 style="font-size: 24px">Generate No Dues Request
				<a href="{{ route('no-dues-request.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Back</a>
		</h1><hr>
		<div>
			@if($message = Session::get('success'))
              <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{$message}}
              </div>
            @endif
	    </div>
		{{-- @if($request == null ) --}}
		<form action="{{route('no-dues-request.store')}}" method="POST" >
			@csrf
		{{-- @endif --}}
			<h5>Employee Detail</h5><hr>
			<div class="row">
				<div class="col-6 form-group">
					<label for="">Employee Name</label>
					<select name="employees" class="custom-select form-control select2" id="select2">

						<option value=""></option>
						@foreach($employees as $index)
							<option data-departid="{{$index->dept_id == null ? '' : $index->dept_id }}" data-depart="{{$index['department'] == null ? '' : $index['department']->name }}" value="{{$index->user_id}}">{{strtoupper($index->emp_name)}}</option>
						@endforeach
					</select>
				</div>

				<div class="col-6 form-group">
					<label for="emp_code">Employee Code</label>
					<input type="text" class="form-control" name="emp_code" id="emp_code" value="{{old('emp_code')}}" readonly="" >
					@error('emp_code')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
				<div class="col-6 form-group">
					<label for="emp_code">Department</label>
					<input type="text" class="form-control" name="department" value="" readonly="" id="department">
					@error('emp_code')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
					<input type="hidden" name="emp_depart_id" value="">
				</div>
				<div class="col-6 form-group">
					<label for="department_head">Department's Head</label>
					<input type="text" class="form-control" name="department_head" value="{{-- {{old('department_head') ?? (!empty($depart_hod) ? $depart_hod->emp_name : '')}} --}} " readonly="" >

					@error('department_head')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
			</div>
			<div class="row">
				<div class="col-6 form-group ">
					<label for="">Date of Joinning</label>
					<input type="text" class="form-control datepicker" name="date_join" value="{{-- {{old('date_join') ?? (!empty($request) ? $request->date_join : '') }} --}}" id="date_join" autocomplete="off">
					@error('date_join')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>	
				<div class="col-6 form-group ">
					<label for="">Date of Leaving</label>
					<input type="text" name="date_leave" class="form-control datepicker" autocomplete="off" value="{{-- {{old('date_leave') ?? (!empty($request) ? $request->date_leave : '')}} --}}">
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
					<textarea  class="form-control" id="assets_description" name="assets_description" >{{-- {{old('assets_description') ?? (!empty($request) ? $request->assets_description : '') }} --}}</textarea>
				</div>
			</div>

			{{-- @if($request == null ) --}}
				<div class="col-12 form-group text-center">
					<button class="btn btn-info btn-sm" style="width: 20%">SAVE</button>
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


$(document).ready(function(){

	$('.select2').select2({
		placeholder: "Select employees",
    	allowClear : true,

	});

	$('#select2').on('change', function(){
		
		var user_id = $(this).val();
		var depart_id = $('this').data('departid')
		var depart = $('this').data('depart')

		
		$('#emp_code').val(user_id);

		$('#emp_depart_id').val(depart_id);
		$('#department').val(depart);

	});

	$('.datepicker').datepicker({
		orientation: "bottom",
		format: "mm-dd-yyyy",
		autoclose: true,
		todayHighlight: true
	});


    
});
</script>
<style type="text/css">
  .approve
  {
    background: #0cac0c;
    color: white;
  }
  .decline
  {
    background: #ff1414;
    color: white;
  }
 
  .apprv_msg{
    color: #0cac0c;
  }
  .dec_msg{
    color: #ff1414;
  }
  .rev_msg{
    color: #3375ca;
  }

</style>

@endsection
