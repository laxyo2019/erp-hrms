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
                  <th>Title</th>
                  <th>Company</th>
                  <th>City</th>
                  <th>Department</th>
                  <th>HR</th>
                  <th>Details</th>
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
              @foreach($postings as $index)
              <tr class="text-center">
                <td>{{++$count}}</td>
                <td >{{ucwords($index->job_title)}}</td>
                <td >{{ucwords($index['company']->name)}}</td>
                <td >{{ucwords($index->city)}}</td>
                <td >{{ucwords($index['department']->name)}}</td>
                <td >
                  @if($index->hr_approval == 0)
                    <strong style="color: grey;">PENDING</strong>
                  @elseif($index->hr_approval == 1)
                    <strong class="apprv_msg">APPROVED</strong>
                  @elseif($index->hr_approval == 2)
                    <strong class="dec_msg">DECLINED</strong>
                  @endif
                </td>
                {{-- <td >
                  @if($index->subadmin_approval == 0)
                    <strong style="color: grey;">PENDING</strong>
                  @elseif($index->subadmin_approval == 1)
                    <strong class="apprv_msg">APPROVED</strong>
                  @elseif($index->subadmin_approval == 2)
                    <strong class="dec_msg">DECLINED</strong>
                  @endif
                </td> --}}
                <td class='d-flex' >
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
                    <div class='d-flex'>
                      @if($index->admin_approval == 0)
                      <strong class="apprv_msg" id="apprv_msg_{{$index->id}}" style="display: none;">APPROVED</strong>
                      <strong class="dec_msg" id="dec_msg_{{$index->id}}" style="display: none;">DECLINED</strong>


                      <button type="button" data-id="{{$index->id}}" class="btn btn-success btn-sm action" value="1" id="apprvBtn_{{$index->id}}"><i class="fa fa-check " style="font-size: 20px" aria-hidden="true"></i>
                      </button>

                      <button type="button" class="btn btn-danger btn-sm ml-2 action decline" value="2" data-id="{{$index->id}}" id="decBtn_{{$index->id}}"><i  style="font-size: 22px" class="fa fa-times " aria-hidden="true"></i>
                      </button>
                      @elseif($index->admin_approval == 1)
                        <strong class="apprv_msg">APPROVED</strong>
                      @elseif($index->admin_approval == 2)
                        <strong class="dec_msg">DECLINED</strong>
                      @endif
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

  $('.action').on('click', function(){

    var action    = $(this).val();
    var request_id  = $(this).data('id');

    if(action == 2){

      var txt = prompt('Please enter reason.');

      if(txt != null){

        $('.decline').attr('value', txt);

      }else{
        return false;
      }
    }

    $.ajax({
      type: 'POST',
      url: "/recruit-posting/admin/"+request_id,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: {'action':action, 'text':txt},
      success:function(res){

        
          $('#apprvBtn_'+request_id).hide();
          $('#decBtn_'+request_id).hide();

          if(res.flag == 1){
            $('#apprv_msg_'+request_id).show();
          }else if(res.flag == 2){
            
            $('#dec_msg_'+request_id).show();
          }
        
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