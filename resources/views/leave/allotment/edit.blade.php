@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div class="row">
		<div class="col-md-12 col-xl-12">
			<h1 style="font-size: 24px">Edit Employee allotments here
			<a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a></h1>
		</div>
	</div>
	<div style="margin-top: 1.5rem; padding: 1.5rem; border: 1px solid grey;">
		@if($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				{{$message}}
			</div>
		@endif
		<div><h4>{{$name->emp_name}}</h4></div><hr>
		<form action="{{route('allotments.update', $name->id)}}" method="POST" enctype="multipart/form-data">
			@csrf
			@method('PATCH')
			<div class="row">
				<div class="col-6 form-group">
					<label for="start">Leave Session Started</label>
					<input type="text" id="start" class="form-control datepicker" name="start" value="{{old('start', $employee[0]->start)}}" autocomplete="off">
					@error('start')
			          <span class="text-danger" role="alert">
			            <strong>* {{ $message }}</strong>
			          </span>
			      	@enderror
				</div>
				<div class="col-6 form-group">
					<label for="ends">Leave Session Ends</label>
					<input type="text" class="form-control datepicker" name="ends" value="{{old('ends', $employee[0]->end)}}" autocomplete="off" id="ends">
					@error('ends')
			          <span class="text-danger" role="alert">
			            <strong>* {{ $message }}</strong>
			          </span>
			      	@enderror
				</div>
				@foreach($employee as $user)
					<div class="col-4 form-group">
						<label for="leave_{{$user->leave_mast_id}}">{{$user->leaves->name}} ( in days )</label>
						<input type="text" class="form-control" name="leave[]"
						autocomplete="off" id="leave_{{$user->leave_mast_id}}" value="{{$user->current_bal}}">
						<input type="hidden" name="id[]" value="{{$user->leave_mast_id}}">

						@error('leave_{{$user->leave_mast_id}}')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
				@endforeach
			</div>
    		<div class="col-12 form-group text-center">
				<button class="btn btn-info btn-sm m-2" style="width: 40%">Save</button>
				{{-- <a class="btn btn-danger btn-sm" type="submit" href="javascript:location.reload()" style="width: 30%">Clear</a> --}}
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
