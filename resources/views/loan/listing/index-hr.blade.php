@extends('layouts.master')
@section('content')
<main class="app-content">
  <div class="row">
    <div class="col-md-12 col-xl-12">
      <div class="card shadow-xs">
        <div class="col-md-12 col-xl-12" style="margin-top: 15px"> 
          <h1 style="font-size: 24px">Loan Request
              <a href="{{ route('loan-request.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
               {{-- @ability('hrms_admin', 'hrms-create|hrms-manage-staff-separation') --}}
              <span class="ml-2">
                <a href="{{route('loan-request.create')}}" class="btn btn-sm btn-success" style="font-size: 13px">
              <span class="fa fa-plus "></span>Apply</a>
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
          <table class="table table-striped table-hover" id="SeparationTable">
            <thead>
              <tr class="text-center">
                <th>#</th>
                <th>Requested Amt</th>
                <th>Sanctioned Amt</th>
                <th>Sanctioned On</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Disbursed Amt</th>
                <th>Details</th>
                {{-- @ability('hrms_admin', 'hrms-edit') --}}
                  <th>Actions</th>
                {{-- @endability --}}
              </tr>
            </thead>
            <tbody>
          @php $count = 0; @endphp
           {{-- @foreach($separations as $index) --}}
              <tr class="text-center" >
                <td> {{++$count}}</td>
                <td>{{-- {{$index->emp_code}} --}}</td>
                <td>{{-- {{$index->requested_on}} --}}</td>
                <td>{{{-- {$index->reason}} --}}</td>
                <td></td>
                <td>
                 {{--  @if($index->admin_approval == 1)
                    <strong style="color: #0cac0c;">SEPARATION APPROVED</strong>
                  @elseif($index->admin_approval == 2)
                    <strong class="dec_msg">DECLINED</strong>
                  @else
                    <strong style="color: grey;">PENDING</strong>
                  @endif --}}
                </td>
                <td>
                 {{-- @if($index->subadmin_approval == 1)
                    <strong style="color: #0cac0c;">SEPARATION APPROVED</strong>
                  @elseif($index->subadmin_approval == 2)
                    <strong class="dec_msg">DECLINED</strong>
                  @else
                    <strong style="color: grey;">PENDING</strong>
                  @endif --}}
                </td>
                {{-- @ability('hrms_admin', 'hrms-edit') --}}
                <td>
                  {{--  <a href="{{route('staff-settlement.edit',$index->id)}}" class="btn btn-sm btn-info" ><i class="fa fa-angle-double-right fa-5x" aria-hidden="true"></i></a> --}}

                </td>
                <td class='d-flex' style="border-bottom:none">

                  {{-- @if($index->status != 1)
                    <span class="ml-2">
                      <a href="{{route('separation.edit',$index->id)}}" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    </span>
                  @endif
                  <span class="ml-2">
                   <form  action="{{route('separation.destroy',$index->id)}}" method="POST" id="delform_{{ $index->id}}">
                  @csrf
                  @method('DELETE')
                  <a href="javascript:$('#delform_{{ $index->id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></a>
                  </form>
                  </span> --}}
                </td>
               
                {{-- @endability --}}
              </tr>
            {{-- @endforeach --}}
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