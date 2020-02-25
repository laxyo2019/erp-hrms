@extends('layouts.master')
@section('content')
	<main class="app-content">
	<div style="margin-top: 1.5rem; padding: 1.5rem; border: 1px solid white;background: white">
		<div class="col-md-12 col-xl-12">
			<h1 style="font-size: 24px">Add Branch
			<a href="{{ route('branches.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a></h1>
		</div>
		@if($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				{{$message}}
			</div>
		@endif
		<form action="{{route('branches.store')}}" method="POST">
		@csrf
		<div class="row">
			<div class="col-6 form-group">
				<label for="">Company</label>
				<select name="comp_id" class="custom-select form-control">
					<option value="">Select Company</option>
					@foreach($companies as $data)
						<option value="{{$data->id}}" >{{ucwords($data->name)}}</option>
					@endforeach
				</select>
				@error('comp_id')
	                <span class="text-danger" role="alert">
	                    <strong>{{ $message }}</strong>
	                </span>
	            @enderror
			</div>
		</div>
		<div class="row">
			<div class="col-6 form-group ">
				<label for="city">Add City</label>
				<input type="text" class="form-control" name="city" value="">
				@error('city')
					<span class="text-danger" role="alert">
						<strong>* {{ $message }}</strong>
					</span>
				@enderror
			</div>
		</div>
		<div class="row">
			<div class="col-6 form-group ">
                    <label for="address">Address</label>
                    <textarea class="form-control" id="address" rows="3" name="address"></textarea>
				@error('address')
					<span class="text-danger" role="alert">
						<strong>* {{ $message }}</strong>
					</span>
				@enderror
			</div>
		</div>
		<div class="row">
			<div class="col-6 form-group text-center">
				<button class="btn btn-info btn-sm" style="width: 20%">SUBMIT</button>
				<a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 20%">Cancel</a>
			</div>
		</div>
		</div><br>
		</form>
	</div>
</main>
@endsection