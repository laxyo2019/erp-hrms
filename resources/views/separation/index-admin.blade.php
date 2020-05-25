@extends('layouts.master')
@section('content')
<main class="app-content">
  <div class="row">
    <div class="col-md-12 col-xl-12">
      <div class="card shadow-xs">
        <div class="col-md-12 col-xl-12" style="margin-top: 15px"> 
          <h1 style="font-size: 24px">Staff Separation
              <a href="{{ route('separation.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
               @ability('hrms_admin', 'hrms-create|hrms-manage-staff-separation')
              <span class="ml-2">
                <a href="{{route('separation.create')}}" class="btn btn-sm btn-success" style="font-size: 13px">
              <span class="fa fa-plus "></span>Add</a>
             </span>
             @endability
          </h1>
        </div>
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
                <th>Name</th>
                <th>Emp Code</th>
                <th>Requested On</th>
                <th>Reason</th>
                <th>Separation Date</th>
                <th>SubADMIN</th>
                <th>HR</th>
                <th>Details</th>
                {{-- @ability('hrms_admin', 'hrms-edit') --}}
                  <th>Actions</th>
                {{-- @endability --}}
              </tr>
            </thead>
            <tbody>
          @php $count = 0; @endphp
           @foreach($separations as $index)
              <tr class="text-center" >
                <td> {{++$count}}</td>
                <td>{{ucwords($index->emp_name)}}</td>
                <td>{{$index->emp_code}}</td>
                <td>{{$index->requested_on}}</td>
                <td>{{$index->reason}}</td>
                <td></td>
                <td>
                  @if($index->subadmin_approval == 1)
                    <span style="color: #0cac0c;">SEPARATION APPROVED</span>
                  @else
                    <span style="color: grey;">PENDING</span>
                  @endif
                </td>
                <td>
                  @if($index->hr_approval == 1)
                    <span style="color: #0cac0c;">SEPARATION APPROVED</span>
                  @else
                    <span style="color: grey;">PENDING</span>
                  @endif
                </td>
                {{-- @ability('hrms_admin', 'hrms-edit') --}}
                <td>
                   <a href="{{route('staff-settlement.edit',$index->id)}}" class="btn btn-sm btn-info" >View</a>
                </td>
                <td class='d-flex' style="border-bottom:none">

                  @if($index->admin_approval == 0 && $index->subadmin_approval == 1)
                    <button type="button"  data-id="{{$index->id}}" class="btn btn-success btn-sm action" value="1" id="apprvBtn_{{$index->id}}">APPROVE</button>

                    <button type="button" data-id="{{$index->id}}" class="btn btn-danger btn-sm ml-2 action decline" value="2" id="decBtn_{{$index->id}}">DECLINE</button>

                    <strong class="apprv_msg" id="apprv_msg_{{$index->id}}" style="display: none;" >APPROVED</strong>
                    <strong class="dec_msg" id="dec_msg_{{$index->id}}" style="display: none;" >DECLINED</strong>

                  @elseif($index->admin_approval == 1)
                    <strong class="apprv_msg">APPROVED</strong>

                  @elseif($index->admin_approval == 2)
                    <strong class="rev_msg">REVERSED</strong>
                  @endif
                </td>
                {{-- @endability --}}
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


  // Approve/Decline requests.

  $('.action').on('click', function(){

    var action    = $(this).val();
    var request_id  = $(this).data('id');

    $.ajax({
      type: 'POST',
      url: "/separation-request/admin/"+request_id,
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