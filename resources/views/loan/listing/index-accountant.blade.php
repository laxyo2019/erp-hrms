@extends('layouts.master')
@section('content')
<main class="app-content">
  <div class="row">
    <div class="col-md-12 col-xl-12">
      <div class="card shadow-xs">
        <div class="col-md-12 col-xl-12" style="margin-top: 15px"> 
          <h1 style="font-size: 24px">Loan Listing
              <a href="{{URL::previous() }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
                {{-- @ability('hrms_admin', 'hrms-create|hrms-manage-staff-separation')
             <span class="ml-2">
                <a href="{{route('loan-request.create')}}" class="btn btn-sm btn-success" style="font-size: 13px">
              <span class="fa fa-plus "></span>Apply</a>
             </span>
             @endability --}}
          </h1>
        </div>
        {{-- 
        
        0 = Pending 
        1 = Disbursed
        2 = Declined

        --}}
        <div class="card-body table-responsive">
          @if($message = Session::get('success'))
            <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button>
              {{$message}}
            </div>
          @endif
          <table class="table table-striped table-hover" id="SeparationTable">
            <thead>
              <tr class="text-center">
                <th>#</th>
                <th>Employee</th>
                <th>Loan Type</th>
                <th>Loan Amt</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Details</th>
                {{-- @ability('hrms_admin', 'hrms-edit') --}}
                  <th>Actions</th>
                {{-- @endability --}}
              </tr>
            </thead>
            <tbody>
          @php $count = 0; @endphp
           @foreach($requests as $index)
              <tr class="text-center" >
                <td> {{++$count}}</td>
                <td>{{strtoupper($index['employee']->emp_name)}}</td>
                <td>{{ucwords($index['loanType']->name)}}</td>
                <td>{{$index->requested_amt}}</td>
                <td>{{$index->reason}}</td>
                <td>
                  @if($index->accountant_approval == 1)
                    <strong class="apprv_msg">DISBURSED</strong>
                  @elseif($index->admin_approval == 1)
                    <strong class="rev_msg">SANCTIONED</strong>
                  @else
                    <strong style="color: grey;">PENDING</strong>
                  @endif
                </td>
                
               {{--  <td>
                  @if($index->hr_approval == 0)
                    <strong style="color: grey;">PENDING</strong>
                  @elseif($index->hr_approval == 1)
                    <strong style="color: #0cac0c;">APPROVED</strong>
                  @elseif($index->hr_approval == 2)
                    <strong style="color: #3375ca;">DECLINED</strong>
                  @elseif($index->hr_approval == 3)
                    <strong class="dec_msg">DISBURSED</strong>
                  @endif
                </td>
                <td>
                  @if($index->subadmin_approval == 0)
                    <strong style="color: grey;">PENDING</strong>
                  @elseif($index->subadmin_approval == 1)
                    <strong style="color: #0cac0c;">APPROVED</strong>
                  @elseif($index->subadmin_approval == 2)
                    <strong style="color: #3375ca;">DECLINED</strong>
                  @elseif($index->subadmin_approval == 3)
                    <strong class="dec_msg">DISBURSED</strong>
                  @endif
                </td> --}}
                {{-- @ability('hrms_admin', 'hrms-edit') --}}
                <td>
                 <span>
                    <button alt="View" class="btn btn-sm btn-info modalReq" data-id="{{$index->id}}"><i class="fa fa-eye text-white" style="font-size: 12px;"></i></button>
                      <!-- Modal -->
                    <div class="modal fade" id="reqModal" role="dialog">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Loan Request Details</h4>
                          </div>
                          <div class="modal-body table-responsive" id="reqDetailTable" style="background: #ececec">
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </span>

                </td>
                <td class='text-center' style="border-bottom:none">
                  @if($index->accountant_approval == 0)
                    <span class="ml-2">
                      
                      <a href="{{route('loan-listing.edit',$index->id)}}" class="btn btn-sm btn-info"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                    </span>
                  @elseif($index->accountant_approval == 1)
                      <span class="ml-2">
                        <a href="{{route('loan-listing.history',$index->id)}}" class="btn btn-sm btn-info"><i class="fa fa-flickr" aria-hidden="true"></i> History</a>
                      </span>
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

  $('#SeparationTable').dataTable( {
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
      url: '/loan-listing/'+req_id,
      success:function(res){
        $('#reqDetailTable').empty().html(res);
        $('#reqModal').modal('show');
      }
    });

  });

  // Approve/Decline requests.

  $('.action').on('click', function(){

    var action      = $(this).val();
    var request_id  = $(this).data('id');

    $.ajax({
      type: 'POST',
      url: "/loan-listing/accountant/"+request_id,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: {'action':action},
      success:function(res){

        $('#apprvBtn_'+request_id).hide();
        $('#decBtn_'+request_id).hide();

        if(res == 1){
          
          $('#apprv_msg_'+request_id).show();    

        }else if(res == 2){

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