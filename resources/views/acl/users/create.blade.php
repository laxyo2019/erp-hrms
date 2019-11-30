@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div class="row">
		<div class="col-md-12 col-xl-12">
			<h1 style="font-size: 24px">Add Role
              <a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
				
				<button class="btn btn-sm btn-info ml-2 employee">
                  <i class="fa fa-eye" style="font-size: 12px">&nbsp Add as Employee</i>
                </button>
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
		<div><h4>Name - {{$user->name}}</h4></div><hr>
		<form action="{{route('assigned.role', $user->id)}}" method="POST" enctype="multipart/form-data">
			@csrf
			{{-- <div class="row">
				<div class="col-12" style="text-align: center;">
					<input type="text" name="name" value="{{old('name', $user->name)}}" style="width:50%;" >
					@error('start')
			          <span class="text-danger" role="alert">
			            <strong>* {{ $message }}</strong>
			          </span>
			      	@enderror
				</div>			
			</div> --}}
			<br>
			<div><h5>Set Role for user here</h5></div>
			<div class="col-12 " style="text-align: center;width: 50%" >
				<select name="role" id="leave_type" class="custom-select ">
					<option value="">Select</option>
					@foreach($roles as $index)
						<option value="{{$index->id}}">{{$index->name}}</option>
					@endforeach
				</select>
				@error('role')
					<span class="text-danger" role="alert">
						<strong>* {{ $message }}</strong>
					</span>
				@enderror
			</div>
			<br><br>
    		<div class="col-12 form-group" align="center">
				<button class="btn btn-info btn-sm m-2" style="width: 40%">Save</button>
			</div>
		</form>
	</div>
</main>
<script>
$(document).ready(function(){
	$('.employee').on('click', function(e){
		$.ajax({
            type: 'GET',
			url: '{{ route("assign.user", $user->id)}}',
			success:function(data){

			}
		})
	});
});
</script>
@endsection
