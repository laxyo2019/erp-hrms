@extends('layouts.master')
@section('content')
	<main class="app-content">
		<div class="row">
			<div class="col-md-12 col-xl-12">
				<h1 style="font-size: 24px">Roles
          <a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>

          <span class="ml-2">
            <a href="{{route('roles.create')}}" class="btn btn-sm btn-success" style="font-size: 13px">
            <span class="fa fa-plus "></span> Add Roles</a>
          </span>
				</h1>
				<hr>
			</div>
		</div>
		
			<div class="row">
      <div class="col-md-12 col-xl-12">
        <div class="card shadow-xs">
          
          <div class="card-body table-responsive">
            @if($message = Session::get('success'))
              <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{$message}}
              </div>
            @endif
            <table class="table table-striped table-hover">
              <thead>
                <tr class="text-center">
                  <th>#</th>
                  <th>ROLE</th>
                  <th>ACTIONS</th>
                </tr>
              </thead>
              <tbody>
            @php $count = 0; @endphp
              @foreach($roles as $index)
              <tr class="text-center">
                <td>{{++$count}}</td>
                <td >{{ucwords($index->name)}}</td>
                <td >
                  <div class="row">
                    
                  <div class="col" align="right">
                      <a href="{{route('roles.edit',$index->id)}}" class="btn btn-sm btn-info">Edit Permission</a>
                  </div>
                  <div  class="col" align="left">
                    <form  action="{{route('roles.destroy',$index->id)}}" method="POST" id="delform_{{ $index->id}}">
                      @csrf
                      @method('DELETE')
                      <a href="javascript:$('#delform_{{ $index->id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">DELETE</a>
                      </form>
                    </div>
                    </div>
                  </td>
              </tr>
              @endforeach
              </tbody>
            </table>
            @role('approve')
              'dododod';
            @endrole
          </div>
        </div>
      </div>
    </div>
	</main>
@endsection