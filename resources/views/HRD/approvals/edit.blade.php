@extends('layouts.master')
@section('content')
<main class="app-content">
	<div class="row">
		<div class="col-md-12 col-xl-12">
			<h1 style="font-size: 20px">Edit action here
			<a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right" style="font-size:13px"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a></h1>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-xl-12">
			<div class="card shadow-xs">
				<div class="card-body">
					<form action="{{route('approval-action.update', $actions->id)}}" method="post">
						@csrf
						@method('PATCH')
						<div class="row">
							<div class="col-6 form-group">
								<label for="">Name</label>
								<input type="text" class="form-control" name="name" value="{{ old('name', $actions->name) }}">
								@error('name')
						          <span class="text-danger" role="alert">
						            <strong>* {{ $message }}</strong>
						          </span>
						      	@enderror
							</div>
						</div> 
						<div class="row">
							<div class="col-6 form-group">
								<div>Reverse action</div>
		            			<div class="toggle lg row col-12">
		            				<div class="form-check form-check-inline mr-0">
										<label>
	<input type="checkbox" name="reverse" value="1" {{$actions->reverse == 1 ? 'checked' : '' }}><span class="button-indecator"></span>
										</label>
									</div>
		            			</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<label for="">Description</label>
									<textarea name="desc" id="desc" class="form-control" cols="30" rows="3">{{$actions->description}}</textarea>
								</div>
							</div>
							<div class="col-12 form-group text-center">
								<button class="btn btn-info btn-sm" style="width: 20%">Submit</button>
								<a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 20%">Cancel</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	</main>
@endsection