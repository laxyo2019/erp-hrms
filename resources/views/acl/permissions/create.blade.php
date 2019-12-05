@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div class="row">
		<div class="col-md-12 col-xl-12">
			<h1 style="font-size: 24px">Create Permission Here
			<a href="{{ route('permissions.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a></h1>
		</div>
	</div>
	<div style="margin-top: 1.5rem; padding: 1.5rem; border: 1px solid grey;">
		@if($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				{{$message}}
			</div>
		@endif 
		<div><h5>Write permission here</h5></div><hr>
		<form action="{{route('permissions.store')}}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="row">
				<div class="col-6 form-group">
						<label for="permission">Permission Name</label>
						<input type="text" id="permission" class="form-control" name="permission" value="{{old('permission')}}">
						@error('permission')
				          {{-- <span class="text-danger" role="alert"> --}}
				          	<small class="form-text text-danger" id="emailHelp">
				          	*{{ $message }}
				          	</small>
				            {{-- <strong>* {{ $message }}</strong> --}}
				          {{-- </span> --}}
				      	@enderror
					</div>
					<div class="col-6 form-group">
						<label for="permission_alias">Permission Alias</label>
						<input type="text" id="permission_alias" class="form-control" name="permission_alias" value="{{old('permission_alias')}}">
						@error('permission_alias')
				         <small class="form-text text-danger" id="emailHelp">
				          	*{{ $message }}
				          	</small>
				      	@enderror
					</div>
				{{-- <div class="col-12" style="text-align: center;">
					<input type="text" name="permission" value="{{old('start')}}" style="width:60%;">
					@error('start')
			          <span class="text-danger" role="alert">
			            <strong>* {{ $message }}</strong>
			          </span>
			      	@enderror
				</div>	 --}}		
			</div>
			<br><br>
    		<div class="col-12 form-group text-center">
				<button class="btn btn-info btn-sm m-2" style="width: 30%">Save</button>
				<a class="btn btn-danger btn-sm" type="submit" href="javascript:location.reload()" style="width: 30%">Clear</a>
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
