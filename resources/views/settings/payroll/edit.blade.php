@extends('layouts.master')
@section('content')
<main class="app-content">
	
	<div style=" padding: 1.5rem; border: 1px solid white;background: white">
			<h1 style="font-size: 24px">Create Chapter 6 Section Heads
				<a href="{{ route('chapter6-head.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Back</a><hr>
		</h1>
		@if($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				{{$message}}
			</div>
		@endif
		<form action="{{route('chapter6-head.update', $head->id)}}" method="POST" >
			@csrf
			@method('PATCH')
			<div class="row">
				<div class="col-6 form-group ">
					<label for="">Chapter 6 Sections</label>
					<select name="chapt6" class="custom-select form-control select2">
						<option value="">Select Type</option>
							@foreach($sections as $index)
								<option value="{{$index->id}}" {{old('chapt6', $head->chapt6_section_id) == $index->id ? 'selected': ''}}>{{ucwords($index->name)}}</option>
							@endforeach
					</select>
					@error('chapt6')
		                  <span class="text-danger" role="alert">
		                      <strong>{{ $message }}</strong>
		                  </span>
		              @enderror
				</div>
			</div>
			<div class="row">
				<div class="col-6 form-group">
					<label for="heads">Section Head</label>
					<input type="text" class="form-control" name="heads" value="{{$head->head}}">
					@error('heads')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>	
			</div>
			
			<div class="row">
				<div class="col-6 form-group">
					<label for="description">description 
						@error('description')
				          	<span style="color: red">
								| {{ $message }}
							</span>
				      	@enderror</label>
					<textarea  class="form-control" id="description" name="description" >{{$head->description}}</textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-6 form-group text-center">
					<button class="btn btn-info btn-sm" style="width: 20%">SAVE</button>
					<a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 30%">Cancel</a>
				</div>
			</div>
				
			</div>
			<br>
			
		</form>
	</div>
</main>
@endsection
