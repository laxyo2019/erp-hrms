@extends('layouts.master')
@section('content')
	<main class="app-content">
		<div class="row">
			<div class="col-md-12 col-xl-12">
				<h1 style="font-size: 24px">Edit Leave</h1>
				<hr>
			</div>
		</div>
		@if($message = Session::get('success'))
			<div class="alert alert-success">
				{{$message}}
			</div>
		@endif 
	</main>
@endsection