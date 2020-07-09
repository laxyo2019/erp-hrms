@extends('layouts.master')
@section('content')
	<main class="app-content">
			<div class="row">
      <div class="col-md-12 col-xl-12">
        <div class="card shadow-xs">
          <div class="col-md-12 col-xl-12" style="margin-top: 15px"> 
              <h1 style="font-size: 24px">Roles
                <a href="{{ route('no-dues-request.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Back</a>
                {{-- @ability('hrms_admin', 'hrms-create') --}}
                <span class="ml-2">
                  <a href="{{route('no-dues-request.create')}}" class="btn btn-sm btn-success" style="font-size: 13px">
                  <span class="fa fa-plus "></span> Add</a>
                </span>
                {{-- @endability --}}
              </h1>
            </div>
          <div class="card-body table-responsive">
            @if($message = Session::get('success'))
              <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{$message}}
              </div>
            @endif
            <table class="table table-striped table-hover" id="NoDuesTable">
              <thead>
                <tr class="text-center">
                  <th>#</th>
                  <th>Department Head</th>
                  <th>Posted</th>
                  {{-- @ability('hrms_admin', 'hrms-edit|hrms-delete') --}}
                    <th>ACTIONS</th>
                  {{-- @endability --}}
                </tr>
              </thead>
              <tbody>
            @php $count = 0; @endphp
              @foreach($nodues as $index)
              <tr class="text-center">
                <td>{{++$count}}</td>
                <td >{{ucwords($index->name)}}</td>
                @ability('hrms_admin', 'hrms-edit|hrms-delete')
                  <td>
                    <div class="row">
                      @ability('hrms_admin', 'hrms-edit')
                        <div class="col" align="right">
                            <a href="{{route('roles.edit',$index->id)}}" class="btn btn-sm btn-info">Edit Permission</a>
                        </div>
                      @endability
                      @ability('hrms_admin', 'hrms-delete')
                        <div  class="col" align="left">
                          <form  action="{{route('roles.destroy',$index->id)}}" method="POST" id="delform_{{ $index->id}}">
                            @csrf
                            @method('DELETE')
                            <a href="javascript:$('#delform_{{ $index->id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">DELETE</a>
                            </form>
                        </div>
                      @endability
                      </div>
                    </td>
                  @endability
              </tr>
              @endforeach
              </tbody>
            </table>
            @role('approve')
              'sgdfgsdg';
            @endrole
          </div>
        </div>
      </div>
    </div>
	</main>
<script type="text/javascript">
$(document).ready(function(){

  $('#NoDuesTable').dataTable( {
    "ordering":   true,
    order   : [[1, 'asc']],
    "columnDefs": [ 
      { "orderable": false, "targets": 0,  }
    ]
  });
 
});
</script>
@endsection