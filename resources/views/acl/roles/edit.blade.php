@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div class="row">
		<div class="col-md-12 col-xl-12">
			<h1 style="font-size: 24px">Edit Role
			<a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a></h1>
		</div>
	</div>
	<div style="margin-top: 1.5rem; padding: 1.5rem; border: 1px solid grey;">
		@if($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×	</button>
				{{$message}}
			</div>
		@endif
		<div><h5>Update Role name here</h5></div><hr>
		<form action="{{route('roles.update', $role->id)}}" method="POST" enctype="multipart/form-data">
			@csrf
			@method('PATCH')
			<div class="row">
				<div class="col-12" style="text-align: center;">
					<input type="text" name="role" value="{{old('role', $role->name)}}" style="width:50%;">
					@error('role')
			          <span class="text-danger" role="alert">
			            <strong>* {{ $message }}</strong>
			          </span>
			      	@enderror
				</div>			
			</div>
			<br>
			<div><h5>Set permissions</h5></div><hr>
            <div class="toggle lg row col-12">
            	@foreach($permissions as $data)
            	<div class="col-3 form-check form-check-inline mr-0">
					<label>
<input type="checkbox" name="perms[]" value="{{$data->name}}" {{ in_array($data->id, $permission_given) ? 'checked' : ''}}><span class="button-indecator">{{ucwords($data->name)}}</span>
					</label>
				</div>
				@endforeach
            </div>
            <br><br>
    		<div class="col-12 form-group" align="center">
				<button class="btn btn-info btn-sm m-2" style="width: 40%">Save</button>
			</div>
		</form>
	</div>
</main>

@endsection
