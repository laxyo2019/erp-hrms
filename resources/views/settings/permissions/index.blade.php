@extends('layouts.master')
@section('content')
	<main class="app-content">
		<div class="row">
			<div class="col-md-12 col-xl-12">
				<h1 style="font-size: 24px">Approval Permissions
				</h1>
				<hr>
			</div>
		</div>
		@if($message = Session::get('success'))
			<div class="alert alert-success">
				{{$message}}
			</div>
		@endif
			<div class="row">
      <div class="col-md-12 col-xl-12">
        <div class="card shadow-xs">
          
          <div class="card-body table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr class="text-center">
                  <th>ID</th>
                  <th>ROLES</th>
                  <th>ACTIONS</th>
                </tr>
              </thead>
              <tbody>
              @foreach($designations as $desig)
              <tr class="text-center">
                <td>{{$desig->id}}</td>
                <td>{{$desig->name}}</td>
                <td><a class="btn btn-info" href="{{Route('permissions.edit', [$desig->id])}}" role="button">Set Permissions</a></td>
              </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
	</main>
@endsection