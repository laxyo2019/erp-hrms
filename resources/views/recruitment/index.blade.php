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
                  <th>Sub-Admin </th>
                  <th>Admin </th>
                  <th>HR</th>
                  <th>Details</th>
                  <th>Add Candidates</th>
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
                  @if($index->subadmin_approval == 0)
                    <strong style="color: grey;">PENDING</strong>
                  @elseif($index->subadmin_approval == 1)
                    <strong class="apprv_msg">APPROVED</strong>
                  @elseif($index->subadmin_approval == 2)
                    <strong class="dec_msg">DECLINED</strong>
                  @endif
                </td>
                <td >
                  @if($index->admin_approval == 0)
                    <strong style="color: grey;">PENDING</strong>
                  @elseif($index->admin_approval == 1)
                    <strong class="apprv_msg">APPROVED</strong>
                  @elseif($index->admin_approval == 2)
                    <strong class="dec_msg">DECLINED</strong>
                  @endif
                </td>
                <td>
                  @if($index->hr_actions == 0)
                    <strong style="color: grey;">PENDING</strong>
                  @elseif($index->hr_actions == 1)
                    <strong class="apprv_msg">SUBMITTED</strong>
                  @elseif($index->hr_actions == 2)
                    <strong class="dec_msg">DECLINED</strong>
                    @elseif($index->hr_actions == 3)
                    <strong class="rev_msg">CLOSED</strong>
                  @endif
                </td>
                <td>
                  <span>
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
                </td>
                <td>
                  @if($index->hr_actions == 0)
                    <strong style="color: grey;" >UNDER PROCESS</strong>
                  @elseif($index->hr_actions == 1)

                    @if($index->recruiter_approval == 0)
                      <a href="{{route('recruiter.index', $index->id)}}" class="btn btn-sm btn-success" ><i class="fa fa-user-plus text-white"  style="font-size: 12px;"></i> ADD</a>
                    @else
                      <a href="{{route('recruiter.index', $index->id)}}" class="btn btn-sm btn-success" ><i class="fa fa-user text-white"  style="font-size: 12px;"></i> VIEW</a>
                    @endif
                  @else
                    <a href="{{route('recruiter.index', $index->id)}}" class="btn btn-sm btn-success" ><i class="fa fa-user text-white"  style="font-size: 12px;"></i> VIEW</a>
                  @endif
                </td>
                <td >
                  @if($index->recruiter_approval == 0 && $index->hr_actions == 0)
                    <strong style="color: grey;">PENDING</strong>
                  @elseif($index->recruiter_approval == 0 )
                    <button type="button" data-id="{{$index->id}}" class="btn btn-success btn-sm approveReq" id="approveBtn_{{$index->id}}">APPROVE</i> </button>
                    <strong class="apprv_msg" id="approveMsg_{{$index->id}}" style="display: none">APPROVED</strong>
                  @elseif($index->recruiter_approval == 1)
                    <strong class="apprv_msg" >APPROVED</strong>
                  @endif
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

  $('.editRequest').on('click', function(){

    var req_id = $(this).data('id');

    $.ajax({
      type: 'GET',
      url: '/recruitment/'+req_id+'/edit',
      success:function(res){
        
      }
    });

  });

  $('.approveReq').on('click', function(){

    var req_id = $(this).data('id');

    $.ajax({
      type: 'POST',
      url: '/recruitment/approved/'+req_id,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success:function(res){

        $('#approveBtn_'+req_id).hide();
        $('#approveMsg_'+req_id).show();
      }
    });
  });

});
</script>
<style type="text/css">
  .approve
  {
    background: #0cac0c;
    color: white;
  }
  .decline
  {
    background: #ff1414;
    color: white;
  }
 
  .apprv_msg{
    color: #0cac0c;
  }
  .dec_msg{
    color: #ff1414;
  }
  .rev_msg{
    color: #3375ca;
  }

</style>
@endsection