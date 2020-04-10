@extends('layouts.master')
@section('content')
	<main class="app-content">
			<div class="row">
      <div class="col-md-12 col-xl-12">
        <div class="card shadow-xs">
          <div class="col-md-12 col-xl-12" style="margin-top: 15px"> 
              <h1 style="font-size: 24px">Candidates Listing
                <a href="{{ route('recruitment.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
              </h1>
            </div>
          <div class="card-body table-responsive">
            @if($message = Session::get('success'))
              <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{$message}}
              </div>
            @endif
        		<div>
        			<h4 style="color: grey">Status - 
                @if($request->recruiter_approval == 1)
                  <strong class="apprv_msg" >SELECTED</strong>
                @elseif($request->recruiter_approval == 0)
                  <strong style="color: grey;" >PENDING</strong>
                @endif
              </h4>
        		</div>
        		<br>
            <table class="table table-striped table-hover" id="RequestsTable">
              <thead>
                <tr class="text-center">
                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Education Level</th>
                  <th>CV</th>
                  <th>Details</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
            @php $count = 0; 
            //Requests Status Codes

            #0 = Pending
            #1 = Approved
            #2 = Declined

            @endphp
              @foreach($candidates as $index)
              <tr class="text-center">
                <td>{{++$count}}</td>
                <td >{{ucwords($index->candidate_name)}}</td>
                <td >{{ucwords($index->email)}}</td>
                
                <td>{{ucwords($index['education']->name)}}</td>
                <td>
                	<a href="{{ route('download.resume', $index->id) }}" ><i class="fa fa-arrow-down"></i> Download</a>
                </td>
                <td class='text-center' >
                    
                    <span >
                    <button alt="View" class="btn btn-sm btn-info modalList" data-id="{{$index->id}}"><i class="fa fa-eye text-white" style="font-size: 12px;"></i>
                    </button>

                    <div class="modal fade" id="candidateModal" role="dialog">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Candidate Details</h4>
                          </div>
                          <div class="modal-body table-responsive" id="detailTable" style="background: #ececec">
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
                  	@if($index->recruiter_approval == 0 && $request->recruiter_approval == 0)
                  		<button class="btn btn-sm btn-success select" id="select_{{$index->id}}" data-id="{{$index->id}}"><i class="fa fa-check text-white" style="font-size: 12px;"> <span>Select</span></i></button>
                  		<strong class="apprv_msg" id="selectMsg_{{$index->id}}" style="display: none">SELECTED</strong>
                  	@elseif($index->recruiter_approval == 1)
                  		<strong class="apprv_msg" >SELECTED</strong>

                    @elseif($index->recruiter_approval == 0 && $request->recruiter_approval == 1)
                      
                      <strong class="dec_msg" >REJECTED</strong>
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
      { "orderable": false, "targets": 0  }
    ]
  });

  //Open modal

  $('.modalList').on('click', function(){

    var req_id = $(this).data('id');

    $.ajax({
      type: 'GET',
      url: '/listing/'+req_id,
      success:function(res){
        $('#detailTable').empty().html(res);
        $('#candidateModal').modal('show');
      }
    });

  });

  $('.select').on('click', function(){
  	var candidate_id = $(this).data('id');

  	$.ajax({
  		type: 'POST',
  		url:  '/shortlist/'+candidate_id,
  		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
  		success:function(res){

  			$('#select_'+candidate_id).hide();
  			$('#selectMsg_'+candidate_id).show();
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