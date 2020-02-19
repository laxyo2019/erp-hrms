@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div class="row">
		<div class="col-md-12 col-xl-12">
			<h1 style="font-size: 24px">Create Role Here
			<a href="{{ route('roles.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a></h1>
		</div>
	</div>
	<div style="margin-top: 1.5rem; padding: 1.5rem; border: 1px solid grey;">
		@if($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				{{$message}}
			</div>
		@endif
		<div><h5>Write role name</h5></div><hr>
		<form action="{{route('roles.store')}}" method="POST">
			@csrf
			<div class="row">
				<div class="col-12" style="text-align: center;">
					<input type="text" name="role" value="{{old('role')}}" style="width:60%;">
					@error('role')
			          <span class="text-danger" role="alert">
			            <strong>* {{ $message }}</strong>
			          </span>
			      	@enderror
				</div>			
			</div>
			{{-- <br>
			@if(count($permissions) != 0)
			<div><h5>SET PERMISSIONS FOR USER</h5></div><hr>
			<div class="toggle lg row col-12">
			@foreach($permissions as $data)
				<div class="col-3 form-check form-check-inline mr-0">
					<label>
	                	<input type="checkbox" name="permissions[]" value="{{$data->name}}" ><span class="button-indecator">{{ucwords($data->name)}}</span>
					</label>
				</div>
			@endforeach
			</div>
			@endif --}}
			<br><br>
    		<div class="col-12 form-group text-center">
				<button class="btn btn-info btn-sm m-2" style="width: 20%">Save</button>
				<a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 20%">Clear</a>
			</div>
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
