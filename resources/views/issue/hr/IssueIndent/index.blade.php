@extends('layouts.master')
@section('content')
  <main class="app-content">
      <div class="row">
      <div class="col-md-12 col-xl-12">
        <div class="card shadow-xs">
          <div class="col-md-12 col-xl-12" style="margin-top: 15px"> 
              <h1 style="font-size: 24px">Issue Indent
                <span class="ml-2">
                  <a href="{{route('issue-indent.create')}}" class="btn btn-sm btn-success" style="font-size: 13px">
                  <span class="fa fa-plus "></span> Generate</a>
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
            <table class="table table-striped table-hover" id="IndentTable">
              <thead>
                <tr class="text-center">
                  <th>#</th>
                  <th>Employee</th>
                  <th>Details</th>
                  <th>ACTIONS</th>
                </tr>
              </thead>
              <tbody>
            @php $count = 0; @endphp
              @foreach($indent as $index)
              <tr class="text-center" id="indent_{{$index->id}}">
                <td>{{++$count}}</td>
                <td >{{ucwords($index['employee']->emp_name)}}</td>
                <td>
                  <div class="row">
                    <div class="col">
                      <a href="{{route('issue-indent.edit',$index->user_id)}}" class="btn btn-sm btn-info">Issued Indent</a>
                      </div>
                        {{-- <div class="col" align="left">
                         <a href="{{route('issue-indent.edit',$index->id)}}" class="btn btn-sm btn-info">No Dues</a>
                        </div> --}}
                      </div>
                    </td>
                    <td><button class="btn-danger btn-sm deleteRequest" 
                      data-id="del_{{$index->user_id}}_{{$index->id}}" >Delete</button></td>
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

  $('#IndentTable').dataTable( {
    "ordering":   true,
    order   : [[1, 'asc']],
    "columnDefs": [ 
      { "orderable": false, "targets": 0,  }
    ]
  });

  $('.deleteRequest').on('click', function(){

      var data = $(this).data('id');
      var arr = data.split('_');
      
      $.ajax({
        type: 'DELETE',
        url: '/issue-indent/'+arr[2],
        data: {'arr': arr},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success:function(res){

          alert('Request has been deleted.');

          $('#indent_'+arr[2]).hide();
        }
      })

  });
 
});
</script>
@endsection