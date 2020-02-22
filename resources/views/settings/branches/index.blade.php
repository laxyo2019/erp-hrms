@extends('layouts.master')
@section('content')
	<main class="app-content">
		<div class="row">
      <div class="col-md-12 col-xl-12">
        <div class="card shadow-xs">
          <div class="card-body table-responsive">
            <div class="col-md-12 col-xl-12">
              <h1 style="font-size: 24px">Branches
                <a href="" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
                <span class="ml-2">
                  <a href="{{route('branches.create')}}" class="btn btn-sm btn-success" style="font-size: 13px">
                  <span class="fa fa-plus "></span> Add Branch</a>
                </span>
              </h1><br>
            </div>
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
                  <th>Name</th>
                  <th>Email</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
               {{--  @php $count = $users->firstItem(); @endphp --}}
                {{-- @foreach($users as $index) --}}
                    <tr class="text-center" >
                      <td> 5</td>
                      <td>5</td>
                      <td>5</td>
                      <td  >
                        <div class="row">
                          <div class="col" align="center">
                          <a href="" class="btn btn-sm btn-info">EDIT</a>
                          </div>
                        
                      {{-- 
                        @if(!empty($index->emp_id))
                          <span class="ml-2">
                          <form action="{{route('assign.user',$index->id)}}" method="POST" id="assign_{{ $index->id}}">
                            @csrf
                            <a href="javascript:$('#assign_{{ $index->id}}').submit();" class="btn btn-sm btn-info" onclick="return confirm('Are you sure?')">Add as Employee</a>
                          </form>
                          </span>
                          @endif 
                        
                          <div class="col" align="left">
                          <form  action="{{route('users.destroy',$index->id)}}" method="POST" id="delform_{{ $index->id}}">
                            @csrf
                            @method('DELETE')
                            <a href="javascript:$('#delform_{{ $index->id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">DELETE</a>
                          </form>
                          </div>
                        --}}
                        </div>
                      </td>
                    </tr>
                {{-- @endforeach --}}
              </tbody>
            </table>
            {{-- {{$users->links()}} --}}
          </div>
        </div>
      </div>
    </div>
	</main>
{{-- <script>
$(document).ready(function(){
  $('#user_{{}}').on('click', function(e){

    var user_id = $(this).data('id');
    alert(user_id);
    $.ajax({
            type: 'GET',
      url: '{{ route("assign.user", $user->id)}}',
      success:function(data){
      }
    })
  });
});
</script> --}}
@endsection