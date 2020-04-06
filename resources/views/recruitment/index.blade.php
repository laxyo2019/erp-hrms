@extends('layouts.master')
@section('content')
	<main class="app-content">
			<div class="row">
      <div class="col-md-12 col-xl-12">
        <div class="card shadow-xs">
          <div class="col-md-12 col-xl-12" style="margin-top: 15px"> 
              <h1 style="font-size: 24px">Recruitment Requests
                <a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
                <span class="ml-2">
                  <a href="{{route('recruitment.create')}}" class="btn btn-sm btn-success" style="font-size: 13px">
                  <span class="fa fa-plus "></span> Generate Requests</a>
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
            <table class="table table-striped table-hover" id="RequestsTable">
              <thead>
                <tr class="text-center">
                  <th>#</th>
                  <th>Title</th>
                  <th>Company</th>
                  <th>City</th>
                  <th>Department</th>
                  <th>HR APPROVAL</th>
                  <th>Sub-Admin APPROVAL</th>
                  <th>Admin APPROVAL</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
            @php $count = 0; 

            //Requests Status Codes

            #0 = Pending
            #1 = Approved
            #2 = Declined

            @endphp
              @foreach($indexes as $index)
              <tr class="text-center">
                <td>{{++$count}}</td>
                <td >{{ucwords($index->job_title)}}</td>
                <td >{{ucwords($index['company']->name)}}</td>
                <td >{{ucwords($index->city)}}</td>
                <td >{{ucwords($index['department']->name)}}</td>
                <td >
                  @if($index->hr_approval == 0)
                    Pending
                  @elseif($index->hr_approval == 1)
                    Approved
                  @elseif($index->hr_approval == 2)
                    Declined
                  @endif
                </td>
                <td >
                  @if($index->subadmin_approval == 0)
                    Pending
                  @elseif($index->subadmin_approval == 1)
                    Approved
                  @elseif($index->subadmin_approval == 2)
                    Declined
                  @endif
                </td>
                <td >
                  @if($index->admin_approval == 0)
                    Pending
                  @elseif($index->admin_approval == 1)
                    Approved
                  @elseif($index->admin_approval == 2)
                    Declined
                  @endif
                </td>
                <td class='d-flex' >
                  <span >
                      

                      <button alt="View" class="btn btn-sm btn-info modalReq" data-id="{{$index->id}}"><i class="fa fa-eye text-white" style="font-size: 12px;"></i></button>

                      <!-- Modal -->
<div class="modal fade" id="reqModal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Recruitment Request Details</h4>
      </div>
      <div class="modal-body table-responsive" id="reqDetailTable" style="background: #ececec">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
</div>
                  </span>
                  <span class="ml-2">
                      <a href="{{route('recruitment.edit',$index->id)}}" class="btn btn-sm btn-success"><i class="fa fa-eye text-white" style="font-size: 12px;"></i> </a>
                  </span>
                  <span class="ml-2">
                    <form  action="{{route('recruitment.destroy',$index->id)}}" method="POST" id="delform_{{ $index->id}}">
                      @csrf
                      @method('DELETE')
                      <a href="javascript:$('#delform_{{ $index->id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash text-white"  style="font-size: 12px;"></i></a>
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
<script type="text/javascript">
$(document).ready(function(){

  $('#RequestsTable').dataTable( {
    "ordering":   true,
    order   : [[1, 'asc']],
    "columnDefs": [ 
      { "orderable": false, "targets": 0,  }
    ]
  });

  $('.modalReq').on('click', function(){

    var req_id = $(this).data('id');
    $.ajax({
      type: 'GET',
      url: '/recruitment/'+req_id,
      success:function(res){
        $('#reqDetailTable').empty().html(res);
        $('#reqModal').modal('show');
      }
    });

  });
 
});
</script>
@endsection