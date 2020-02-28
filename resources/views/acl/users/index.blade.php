@extends('layouts.master')
@section('content')
<main class="app-content">
  <div class="row">
    <div class="col-md-12 col-xl-12">
      <div class="card shadow-xs">
        <div class="col-md-12 col-xl-12" style="margin-top: 15px"> 
          <h1 style="font-size: 24px">Manage users
              <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
              <span class="ml-2">
                <a href="{{route('users.create')}}" class="btn btn-sm btn-success" style="font-size: 13px">
              <span class="fa fa-plus "></span> Add Users</a>
             </span>
          </h1>
        </div>
        <div class="card-body table-responsive">
          @if($message = Session::get('success'))
            <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button>
              {{$message}}
            </div>
          @endif
          <table class="table table-striped table-hover" id="UsersTable">
            <thead>
              <tr class="text-center">
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
          @php $count = 0; @endphp
            @foreach($users as $index)
                    <tr class="text-center" >
                      <td> {{++$count}}</td>
                      <td>{{ucwords($index->name)}}</td>
                      <td>{{$index->email}}</td>
                      <td  >
                        <div class="row">
                          <div class="col" align="center">
                          <a href="{{route('users.edit',$index->id)}}" class="btn btn-sm btn-info">EDIT</a>
                          </div>
                        </div>
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
<script type="text/javascript">
$(document).ready(function(){

  $('#UsersTable').dataTable( {
    "ordering":   true,
    order   : [[1, 'asc']],
    "columnDefs": [ 
      { "orderable": false, "targets": 0,  }
    ]
  });
 
});
</script>
@endsection