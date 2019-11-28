@extends('layouts.master')
@section('content')
	<main class="app-content">
		<div class="row">
			<div class="col-md-12 col-xl-12">
				<h1 style="font-size: 24px">Permissions
          <span class="ml-2">
            <a href="{{route('permissions.create')}}" class="btn btn-sm btn-success" style="font-size: 13px">
            <span class="fa fa-plus "></span> Add Permission</a>
          </span>
				</h1>
				<hr>
			</div>
		</div>
		@if($message = Session::get('success'))
      <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
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
                  <th>#</th>
                  <th>PERMISSION</th>
                  <th>ACTIONS</th>
                </tr>
              </thead>
              <tbody>
                @php $count = 0; @endphp
              @foreach($permissions as $index)
              <tr class="text-center">
                <td>{{++$count}}</td>
                <td>{{ucwords($index->name)}}</td>
                <td class="d-flex text-center">
                    <span>
                        <a href="{{route('permissions.edit',$index->id)}}" class="btn btn-sm btn-info">EDIT</a>
                    </span>
                    <span class="ml-2 ">
                      <form  action="{{route('permissions.destroy',$index->id)}}" method="POST" id="delform_{{ $index->id}}">
                          @csrf
                        @method('DELETE')
                        <a href="javascript:$('#delform_{{ $index->id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">DELETE</a>
                    
                      </form>
                    </span>
                  </td>
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