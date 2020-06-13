@extends('layouts.master')
@push('styles')
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" /> --}}
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('themes/vali/css/select2.min.css') }}">
  <script src="{{asset('themes/vali/js/plugins/select2.min.js')}}"></script> --}}
@endpush
@section('content')
<main class="app-content">
	<div class="row">
		<div class="col-md-12 col-xl-12">
			<h1 style="font-size: 24px">Add Separation Details
				@role('hrms_hr')
				<a href="{{ route('separation-hr.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
				@endrole
			</h1>
		</div>
	</div>
	<div style="margin-top: 1.5rem; padding: 1.5rem; border: 1px solid white;background: white">
		@if($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				{{$message}}
			</div>
		@endif
		<form action="{{route('separation.store')}}" method="POST" >
			@csrf
			<div class="row">
				<div class="col-6 form-group">
					<label for="employee">Employee</label>
					<select name="employee" class="select2-selection select2-selection--single form-control select2" id="employeeSelect">
						<option value="">Select Type</option>
							@foreach($employees as $index)
								<option value="{{$index->user_id}}" data-id="{{$index->emp_code}}">{{ucwords($index->user_id)}} : {{ucwords($index->emp_name)}}</option>
							@endforeach
					</select>
					@error('employee')
		                  <span class="text-danger" role="alert">
		                      <strong>{{ $message }}</strong>
		                  </span>
		              @enderror
				</div>
				<div class="col-6 form-group">
					<label for="emp_code">Employee Code
						@error('emp_code')
					   		<span style="color: red">| {{ $message }}</span>
						@enderror
					</label>
					<input type="text" class="form-control" name="emp_code" value="{{old('emp_code')}}" id="empCode" readonly="">
					{{-- @error('emp_code')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror --}}
				</div>
				<div class="col-6 form-group ">
					<label for="">Requested On
						@error('requested_on')
					   		<span style="color: red">| {{ $message }}</span>
						@enderror
					</label>
					<input type="text" class="form-control datepicker" name="requested_on" value="{{old('requested_on')}}" autocomplete="off">
					{{-- @error('requested_on')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror --}}
				</div>
				<div class="col-6 form-group ">
					<label for="">Separation Date
						@error('separation_date')
					   		<span style="color: red">| {{ $message }}</span>
						@enderror
					</label>
					<input type="text" class="form-control datepicker" name="separation_date" value="{{old('separation_date')}}" autocomplete="off">
					{{-- @error('separation_date')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror --}}
				</div>
			</div>
			<div class="row">
				<div class="col-6 form-group">
					<label for="reason">Reason 
						@error('reason')
					   		<span style="color: red">| {{ $message }}</span>
						@enderror
					</label>
					<textarea  class="form-control" id="reason" name="reason" >{{old('reason')}}</textarea>
				</div>
				<div class="col-6 form-group">
					<label for="short_description">Short Description 
						@error('short_description')
				          	<span style="color: red">| {{ $message }}</span>
				      	@enderror
				    </label>
					<textarea  class="form-control" id="short_description" name="short_description" >{{old('short_description')}}</textarea>
				</div>
				<div class="col-12 form-group text-center">
					<button class="btn btn-info btn-sm" style="width: 20%">SAVE</button>
					{{-- <a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 30%">Cancel</a> --}}
				</div>
			</div><br>
		</form>
	</div>
</main>

<script type="text/javascript">
	$('.datepicker').datepicker({
		orientation: "auto",
		format: "mm-dd-yyyy",
		autoclose: true,
		todayHighlight: true
		});

	// Select2 Dropdown
	$('.select2').select2({
		theme: "classic",
		placeholder: 'Select Employee'
	});

	$('#employeeSelect').on('change', function(){
		var user_id	=	$(this).val();
		
		$.ajax({
			type: 'POST',
			url: '/separation/emp-code/',
			data: {'user_id': user_id},
			headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(res){
				console.log(res)
				$('#empCode').val(res);
			}
		});
	})
	
</script>

@endsection
