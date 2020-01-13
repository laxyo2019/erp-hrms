@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div class="row">
		<div class="col-md-12 col-xl-12">
			<h1 style="font-size: 24px">Create User here
              <a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
				
				{{-- <button class="btn btn-sm btn-info ml-2 employee">
                  <i class="fa fa-eye" style="font-size: 12px">&nbsp Add as Employee</i>
                </button> --}}
			</h1>
		</div>
	</div>
	<div style="margin-top: 1.5rem; padding: 1.5rem; border: 1px solid grey;">
		@if($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				{{$message}}
			</div>
		@endif
		<form action="{{route('users.store')}}" method="POST" >
			@csrf
		<div class="row">
				<div class="row">
					<div class="col-6 form-group">
						<label for="">Name</label>
						<input type="text" class="form-control" name="name" value="{{old('name')}}">
						@error('name')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="col-6 form-group ">
						<label for="">Email</label>
						<input type="text" class="form-control" name="email" value="{{old('email')}}">
						@error('email')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="col-6 form-group ">
						<label for="">Password</label>
						<input type="password" class="form-control" name="password" value="{{old('password')}}">
						@error('password')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="col-6 form-group ">
						<label for="">Confirm Password</label>
						<input type="password" class="form-control" name="password_confirmation" value="{{old('password_confirmation')}}">
						@error('confirmed')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
						@enderror
					</div>
					
					<div class="col-12 form-group text-center">
						<button class="btn btn-info btn-sm" style="width: 20%">Save</button>
						<a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 20%">Cancel</a>
					</div>
				</div>			
			</div>
		</form>
	</div>
</main>
<script>
$(document).ready(function(){
	$('.employee').on('click', function(e){
		$.ajax({
            type: 'GET',
			
			success:function(data){

			}
		})
	});
});
</script>
@endsection
