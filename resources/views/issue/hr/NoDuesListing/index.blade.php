@extends('layouts.master')
@section('content')
<main class="app-content" id="noduesListing">
  <div class="row">
    <div class="col-md-12 col-xl-12">
      <div class="card shadow-xs">
        <div class="col-md-12 col-xl-12" style="margin-top: 15px"> 
            <h1 style="font-size: 24px">No Dues Listing
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
          <table class="table table-striped table-hover" id="NoduesTable">
            <thead>
              <tr class="text-center">
                <th>#</th>
                <th>Employee</th>
                <th>Department</th>
                <th>Department Head</th>
                <th>Posted</th>
                @permission('hrms-manage-nodues-request-items')
                  <th>Details</th>
                @endpermission
                <th>Status</th>
                <th>ACTIONS</th>
              </tr>
            </thead>
            <tbody>
          @php $count = 0; @endphp
            @foreach($data as $index)
            <tr class="text-center" id="indent_{{$index->id}}">
              <td>{{++$count}}</td>
              <td >{{ucwords($index['employee']->emp_code)}} : {{ucwords($index['employee']->emp_name)}}</td>
              <td>{{strtoupper($index['department']->name)}}</td>
              <td>{{strtoupper($index['hod']->emp_name)}}</td>
              <td>{{$index->posted}}</td>
              @permission('hrms-manage-nodues-request-items')
              <td>
                  <a href="{{route('nodues.detail', $index->id)}}" data-id="{{$index->id}}" class="btn btn-info btn-sm actionView" id="{{$index->id}}">view</a>
              </td>
              @endpermission
              <td>
                <?php $condition = []; ?>
                @foreach($index['approval'] as $approval)
                 
                    <?php $condition[] = $approval->action; ?>
                  
                @endforeach

                @if(in_array('0', $condition))
                  PENDING
                @else
                  APPROVED
                @endif
              </td>
              <td><button type="button"  data-id="{{$index->id}}" class="btn btn-info btn-sm actionShow" id="{{$index->id}}">show</button>
                <!-- Modal -->
                <div class="modal fade" id="reqModal" role="dialog">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">No Dues Approval</h4>
                      </div>
                      <div class="modal-body table-responsive" id="noDuesTable" style="background: #ececec">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div></td>
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

  $('#NoduesTable').dataTable( {
    "ordering":   true,
    order   : [[1, 'asc']],
    "columnDefs": [ 
      { "orderable": false, "targets": 0,  }
    ]
  });

  /*$('.actionView').on('click', function(){

      var request_id = $(this).data('id');

      $.ajax({
        type: 'GET',
        url: '/noduesail')}}',
        data: {'request_id': request_id},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success:function(res){
          $('#')
        }
      })
  });*/

    $('.actionShow').on('click', function(){

      var request_id  = $(this).data('id');


      $.ajax({
        type: 'post',
        url: "/no-dues/department-head/show/",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {'request_id': request_id},
        success: function(res){
          $('#noDuesTable').empty().html(res);
          $('#reqModal').modal('show');
        }

      })
  })
 
});
</script>
@endsection