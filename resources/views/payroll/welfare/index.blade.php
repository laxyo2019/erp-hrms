@extends('layouts.master')
@section('content')
  <main class="app-content">
    <div class="row">
      <div class="col-md-12 col-xl-12">
        <div class="card shadow-xs">
          <div class="col-md-12 col-xl-12" style="margin-top: 15px">
              <h1 style="font-size: 24px">Welfare
                <a href="" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Back</a>
                <span class="ml-2">
                  <a href="{{route('welfare.create')}}" class="btn btn-sm btn-success" style="font-size: 13px">
                  <span class="fa fa-plus "></span> Add Welfare</a>
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
            <table class="table table-striped table-hover" id="WelfareTable">
              <thead>
                <tr class="text-center">
                  <th>#</th>
                  <th>Type</th>
                  <th>Code</th>
                  <th>Description</th>
                  <th>Active</th>
                  <th>Prorated</th>
                  <th>Ledger</th>
                  <th>Details</th>
                  {{-- @ability('hrms_admin', 'hrms-edit|hrms-delete') --}}
                    <th>Actions</th>
                  {{-- @endpermission --}}
                </tr>
              </thead>
              <tbody>
               @php $count = 0; @endphp
                @foreach($welfares as $index)
                    <tr class="text-center" >
                      <td>{{++$count}}</td>
                      <td>{{$index->type == 1 ? 'Earning' : 'Deduction'}}</td>
                      <td>{{strtoupper($index->code)}}</td>
                      <td>{{ucwords($index->description)}}</td>
                      <td>{{$index->active == 1 ? 'True' : 'False'}}</td>
                      <td>{{$index->protated == 1 ? 'True' : 'False'}}</td>
                      <td>{{ucwords($index['ledger']->name)}}</td>
                      <td>
                          <button alt="View" class="btn btn-sm btn-info modalWelfare" data-id="{{$index->id}}"><i class="fa fa-eye text-white" style="font-size: 12px;"></i></button>
                          <!-- Modal -->
                          <div class="modal fade" id="reqModal" role="dialog">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Welfare Details</h4>
                                </div>
                                <div class="modal-body table-responsive" id="WelfareDetail" style="background: #ececec">
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div>
                      </td>
                      <td>
                        <div class="row">
                          <div class="col" align="center">
                            <a href="{{route('welfare.edit', $index->id)}}" class="btn btn-sm btn-info">EDIT</a>
                          </div>
                          <div class="col" align="left">
                            <form  action="{{route('welfare.destroy',$index->id)}}" method="POST" id="delform_{{ $index->id}}">
                              @csrf
                              @method('DELETE')
                              <a href="javascript:$('#delform_{{ $index->id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">DELETE</a>
                            </form>
                          </div>
                        </div>
                      </td>
                    
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>
<script>
$(document).ready(function(){

   $('#WelfareTable').dataTable( {
            "ordering":   true,
            order   : [[1, 'asc']],
            "columnDefs": [ 
                { "orderable": false, "targets": 0,  }
            ]
      });

   $('.modalWelfare').on('click', function(){

    var req_id = $(this).data('id');
    $.ajax({
      type: 'GET',
      url: '/hrpayroll/welfare/'+req_id,
      success:function(res){
        $('#WelfareDetail').empty().html(res);
        $('#reqModal').modal('show');
      }
    });

  });
});
</script>
@endsection