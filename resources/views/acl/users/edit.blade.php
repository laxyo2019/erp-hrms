@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div class="row">
		<div class="col-md-12 col-xl-12">
			<h1 style="font-size: 24px">Edit User
              <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
				@if(empty($user->emp_id))
					<button class="btn btn-sm btn-info ml-2 employee">
	                  <span style="font-size: 12px">+ Add as Employee</span>
	                </button>
	            {{-- @else
	            	@if(empty($employee->leave_allotted))
						<button class="btn btn-sm btn-info ml-2 leave" id="leave">
		                	<span style="font-size: 12px">+ Allot Leaves</span>
		                </button>
	                @endif --}}
                @endif
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
		<div><h5>UPDATE USER NAME HERE</h5></div><hr>
		<form action="{{route('users.update', $user->id)}}" method="POST" enctype="multipart/form-data">
			@csrf
			@method('PATCH')
			<div class="row">
				<div class="col-12" align="center">
					<input type="text" class="form-control" name="name" value="{{old('name', $user->name)}}" style="width:50%;">
					@error('name')
					<small class="form-text text-muted " role="alert" id="emailHelp">	
						<strong style="color: red;">* {{ $message }}</strong>
					</small>			          
			      	@enderror
				</div>			
			</div>
			<br>
			@if(count($roles) != 0)
			<div><h5>SET ROLES FOR USER</h5></div><hr>
			<div class="toggle lg row col-12">
			@foreach($roles as $data)
				<div class="col-3 form-check form-check-inline mr-0">
					<label>
	                	<input type="checkbox" name="roles[]" value="{{$data->name}}" {{ in_array($data->id, $roles_given) ? 'checked' : ''}}><span class="button-indecator">{{ucwords($data->name)}}</span>
					</label>
				</div>
			@endforeach
			</div>
			@endif
			<br>
			@if(count($permissions) != 0)
			<div><h5>SET PERMISSIONS FOR USER</h5></div><hr>
			<div class="toggle lg row col-12">
			@foreach($permissions as $data)
				<div class="col-3 form-check form-check-inline mr-0">
					<label>
						<input type="checkbox" name="perms[]" value="{{$data->name}}" {{ in_array($data->id, $permissions_given) ? 'checked' : ''}}><span class="button-indecator">{{ucwords($data->name)}}</span>
					</label>
				</div>
			@endforeach
			</div>
			@endif
			<br>
    		<div class="col-12 form-group" align="center">
				<button class="btn btn-info btn-sm m-2" style="width: 40%">Save</button>
			</div>
		</form>
	</div>
</main>
<script>
$(document).ready(function(){
	$('.employee').on('click', function(e){
		var user_id = {{$user->id}};
		$.ajax({
            type: 'POST',
			url: '{{ route("assign.role")}}',
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {'id':user_id },
			success:function(data){
				alert(data);

				$('.employee').hide();

			}
		})
	});
	/*$('.leave').on('click', function(e){
        e.preventDefault();
		$.ajax({
			type: 'POST',
			url: route("alloting.leave", $employee->id)}},
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(data){
				alert(data);
			}
		});
	});*/
});
</script>
@endsection
