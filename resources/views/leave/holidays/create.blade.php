@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div class="row">
			<div class="col-md-12 col-xl-12">
				<h1 style="font-size: 24px">Create Holiday here
                    <a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right" style="font-size:13px"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
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
			<form action="{{route('holidays.store')}}" method="POST" >
				@csrf
				<div class="row">
					<div class="col-6 form-group">
						<label for="title">Holiday Title</label>
						<input type="text" id="title" class="form-control" name="title" value="{{old('title')}}">
						@error('title')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-6 form-group">
						<label for="date">Holiday date</label>
						<input type="text" class="form-control datepicker" name="date" autocomplete="off" id="date" value="{{old('date')}}">
						@error('date')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-12 form-group">
						<label for="description">Description</label>
						<textarea class="form-control" name="description"
						autocomplete="off" id="description" >{{old('description')}}</textarea> 
						@error('description')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
		    	</div>
		    		<div class="col-12 form-group text-center">
						<button class="btn btn-info btn-sm m-2" style="width: 30%">   Save   </button>
						<a class="btn btn-danger btn-sm" style="width: 30%" type="submit" href="javascript:location.reload()">Clear  </a>
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
