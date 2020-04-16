@extends('layouts.master')
@section('content')
<main class="app-content">
  <div style="margin-top: 1.5rem; padding: 1.5rem;" class="tile">
    <h1 style="font-size: 24px">Add Recruits here
      <a href="{{ route('recruitment.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
              </h1>
    @if($message = Session::get('success'))
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      {{$message}}
    </div>
    @elseif($message = Session::get('failed'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      {{$message}}
    </div>
    @endif
    <br>
    <div>
      <h4 style="color: grey">Job Title - {{ucwords($requirement->job_title)}}</h4>
    </div>
    <div>
      <h4 style="color: grey">Status - 
        @if($requirement->hr_actions == 0)
          <span style="color: #0cac0c;">OPEN</span>
        @elseif($requirement->hr_actions == 1 && $requirement->recruiter_approval == 0)
            <span style="color: #167cff;">SELECTED</span>
        @elseif($requirement->hr_actions == 1 && $requirement->recruiter_approval == 1)
            <span style="color: #167cff;">FINALISED</span>
        @elseif($requirement->hr_actions == 3)
          <span style="color: #167cff;">JOINED</span>
        @endif
      </h4>
    </div>
    <br>
    <table class="table table-striped table-hover table-bordered" id="CandidatesTable">
        <thead class="thead-dark">
          <tr>
            <th class="text-center">#</th>
            <th class="text-center">Name</th>
            <th class="text-center">Education Level</th>
            <th class="text-center">Email</th>
            <th class="text-center">Contact</th>
            <th class="text-center">Details</th>
            <th class="text-center">Candidate's CV</th>
            <th class="text-center">
              {{$requirement->hr_actions == 0 ? 'Actions' : 'Status'}}
            </th>
          </tr>
        </thead>
        <tbody id="experiencesTbody">
          @foreach($candidates as $candidate)
          <tr class="text-center">
            <td>{{$candidate->id}}</td>
            <td>{{ucwords($candidate->candidate_name)}}</td>
            <td>{{ucwords($candidate['education']->name)}}</td>
            <td>{{ucwords($candidate->email)}}</td>
            <td>{{$candidate->contact}}</td>
            <td class="text-center">
              <button class="btn btn-sm btn-info modalResume ml-2 " data-id="{{$candidate->id}}">
                <i class="fa fa-eye" style="font-size: 12px"></i>
              </button>
              <div class="modal fade" id="cvModal" role="dialog">
                   <div class="modal-dialog modal-lg" >
                    <div class="modal-content" >
                        <div class="modal-header">
                          <h4 class="modal-title">Candidate Details</h4>
                        </div>
                        <div class="modal-body table-responsive" id="cvTable" style="background: #ececec">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                  </div>
              </div>
            </td>
            <td class="text-center"><a href="{{route('download.resume', $candidate->id)}}"><i class="fa fa-arrow-down"></i> Download</a></td>
            <td>
              @if($requirement->hr_actions == 1)

                @if($candidate->recruiter_approval == 0)

                  <strong class="apprv_msg" style="display: none;" id="finalMsg_{{$candidate->id}}">Finalised</strong>
                   <button class="btn btn-sm btn-success finalCandidate" id="final_{{$candidate->id}}" data-id="{{$candidate->id}}">Finalise</button>
                @elseif($candidate->recruiter_approval == 1)
                  <strong class="apprv_msg" >FINALISED</strong>
                @elseif($candidate->recruiter_approval == 2)
                  <strong class="dec_msg" >REJECTED</strong>
                @endif
                  
              @elseif($requirement->hr_actions == 3)
                @if($candidate->hr_approval == 2)
                    <strong class="dec_msg" id="joinMsg_{{$candidate->id}}">REJECTED</strong>
                    
                  @elseif($candidate->hr_approval == 1)
                    <strong class="apprv_msg" id="joinMsg_{{$candidate->id}}">JOINED</strong>
                  @endif
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
    </table>
  </div>
</main>
<script>
$(document).ready(function(){

  $('#CandidatesTable').dataTable( {
    "ordering":   true,
    order : [[1, 'asc']],
    "columnDefs": [ 
      { "orderable": false, "targets": 0,  }
    ]
  });


  //Modal view
  $('.modalResume').on('click', function(e){
    e.preventDefault();
    var candidate_id = $(this).data('id');

    $.ajax({
      type:'get',
      url: "/recruit/candidates/"+candidate_id,
      //headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success:function(data){
        // alert(data);
        $('#cvModal').modal('show');
        $('#cvTable').html(data);         
      }
    })
  });

  //Finalise candidates

  $('.finalCandidate').on('click', function(){
    
    var user_id = $(this).data('id');

    $.ajax({

      type: 'POST',
      url: '/finalised/'+user_id+'/candidate',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success:function(res){

        $('#final_'+user_id).hide();
        $('#finalMsg_'+user_id).show();
      }
    })
  });

  //Join candidates

  $('.joinCandidate').on('click', function(){
    
    var user_id = $(this).data('id');

    $.ajax({

      type: 'POST',
      url: '/join/'+user_id,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success:function(res){

        $('#join_'+user_id).hide();
        $('#joinMsg_'+user_id).show();
      }
    })
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
