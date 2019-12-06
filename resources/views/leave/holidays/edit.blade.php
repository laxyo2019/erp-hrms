@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div class="row">
			<div class="col-md-12 col-xl-12">
				<h1 style="font-size: 24px">Edit Holiday here
                    <a href="{{ route('holidays.index') }}" class="btn btn-sm btn-primary pull-right" style="font-size:13px"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
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
			<form action="{{route('holidays.update', $holiday->id)}}" method="POST" >
				@csrf
				@method('PATCH')
				<div class="row">
					<div class="col-6 form-group">
						<label for="title">Holiday Title</label>
						<input type="text" id="title" class="form-control" name="title" value="{{old('title', $holiday->title)}}">
						@error('title')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-6 form-group">
						<label for="holiday_date">Holiday date</label>
						<input type="text" class="form-control datepicker" name="holiday_date" autocomplete="off" id="holiday_date" value="{{old('holiday_date', $holiday->date)}}">
						@error('holiday_date')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-12 form-group">
						<label for="description">Description</label>
						<textarea class="form-control" name="description"
						autocomplete="off" id="description" >{{old('description', $holiday->desc)}}</textarea> 
						@error('description')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
		    	</div>
	    		<div class="col-12 form-group text-center">
					<button class="btn btn-info btn-sm m-2" style="width: 40%">Save</button>
					
				</div>
				</div>
			</form>
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
