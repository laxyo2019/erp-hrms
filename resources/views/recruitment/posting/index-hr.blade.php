@extends('layouts.master')
@section('content')
	<main class="app-content">
			<div class="row">
      <div class="col-md-12 col-xl-12">
        <div class="card shadow-xs">
          <div class="col-md-12 col-xl-12" style="margin-top: 15px"> 
              <h1 style="font-size: 24px">Recruitment Postings
                
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
                  <th>TITLE</th>
                  <th>COMPANY</th>
                  <th>CITY</th>
                  <th>DEPARTMENT</th>
                  <th>REQUESTED BY</th>
                  <th>DETAILS</th>
                  <th>MANAGER</th>
                  <th>ADD RECRUITS</th>
                  <th>ACTIONS</th>
                </tr>
              </thead>
              <tbody>
            @php $count = 0; 

            //Requests Status Codes

            #0 = Pending
            #1 = Approved
            #2 = Declined
            #3 = Closed
            @endphp
              @foreach($postings as $index)
              <tr class="text-center">
                <td>{{++$count}}</td>
                <td>{{ucwords($index->job_title)}}</td>
                <td>{{ucwords($index['company']->name)}}</td>
                <td>{{ucwords($index->city)}}</td>
                <td>{{ucwords($index['department']->name)}}</td>
                <td>{{ ucwords($index['employee']->emp_name) }}</td>
                <td class='text-center'>
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
                    @if($index->recruiter_approval == 0)
                      <strong style="color: grey;">DISABLE</strong></td>
                    @endif
                  @elseif($index->hr_actions == 1)
                    @if($index->recruiter_approval == 0)
                      <strong style="color: grey">PENDING</strong></td>
                    @elseif($index->recruiter_approval == 1)
                      <strong class="apprv_msg">APPROVED</strong></td>
                    @endif
                  @else
                    <strong class="apprv_msg">APPROVED</strong></td>
                  @endif
                <td>
                  @if($index->hr_actions == 3)
                     <div class='text-center'>
                     <a href="{{url('/recruit/'.$index->id.'/candidates/hr')}}" class="btn btn-sm btn-success addUser"><i class="fa fa-user text-white"  style="font-size: 20px;" ></i> VIEW</a>
                     </div>
                  @else
                    <div class='text-center'>
                     <a href="{{url('/recruit/'.$index->id.'/candidates/hr')}}" class="btn btn-sm btn-success addUser"><i class="fa fa-user-plus text-white"  style="font-size: 20px;" ></i></a>
                     </div>
                  @endif
                </td>
                <td>
                    <div class='text-center'>
                      @if($index->hr_actions == 0)
                        <button class="btn btn-sm btn-success submit" id="submit_{{$index->id}}" data-id="{{$index->id}}" value="submit"><i class="fa fa-check text-white" style="font-size: 12px;">Submit</i></button>
                        
                        <span style="color: #0cac0c; display:none" id="msg_{{$index->id}}">SUBMITTED</span>
                      @elseif($index->hr_actions == 1)

                        @if($index->recruiter_approval == 0)
                          <span style="color: #0cac0c;" id="msg_{{$index->id}}">SUBMITTED</span>
                        @elseif($index->recruiter_approval == 1)

                          {{-- <button class="btn btn-sm btn-info close"  data-id="{{$index->id}}" id="close_{{$index->id}}">CLOSE</button> --}}

                          <button class="btn btn-sm Crequest" style="background-color:#3375ca; color:white" id="close_{{$index->id}}" data-id="{{$index->id}}">CLOSE</button>

                          <strong class="rev_msg" style="display:none" id="closeMsg_{{$index->id}}">CLOSED</strong>

                        @endif

                      @elseif($index->hr_actions == 3)
                        <strong class="rev_msg" >CLOSED</strong>
                      @endif
					          </div>
                      
                </td>
                  </div>
                  </tr>
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

  //To view details of request
  $('.modalReq').on('click', function(){

    var req_id = $(this).data('id');
    $.ajax({
      type: 'GET',
      url: '/recruit-posting/'+req_id,
      success:function(res){
        $('#reqDetailTable').empty().html(res);
        $('#reqModal').modal('show');
      }
    });

  });

  //To take actions regarding requests

  $('.submit').on('click', function(){

    var req_id = $(this).data('id');

    var value  = $(this).val();

    $.ajax({
      type: 'PATCH',
      url: '/recruit-posting/'+req_id,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: {'button': value},
      success:function(res){
        //console.log()
        $('#submit_'+req_id).hide();
        $('#msg_'+req_id).show();

      }
    })

  })
 
  //Close Recruitment Request

  $('.Crequest').on('click', function(){

    var req_id = $(this).data('id');

    $.ajax({
      type: 'POST',
      url: '/close-request/'+req_id,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success:function(res){
        //console.log()
        $('#close_'+req_id).hide();
        $('#closeMsg_'+req_id).show();

      }
    })

  })

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