@extends('layouts.master')
 @push('script')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
  <main class="app-content">
    <div class="row">
      <div class="col-md-12 col-xl-12">
        <div class="card shadow-xs">
          <div class="col-md-12 col-xl-12" style="margin-top: 15px">
              <h1 style="font-size: 24px">Financial Year
                {{-- <span class="ml-2"> --}}
                  <button alt="View" class="btn btn-sm btn-success btn-modal" ><i class="fa fa-eye text-white" style="font-size: 12px;"></i></button>
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
                    <!-- End -->
                {{-- </span> --}}
              </h1>
            </div>
          <div class="card-body table-responsive">
            
            @if($message = Session::get('success'))
              <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{$message}}
              </div>
            @endif
            <table class="table table-striped table-hover" id="FinancialYearTable">
              <thead>
                <tr class="text-center">
                  <th>#</th>
                  <th>Financial Year</th>
                  <th>Description</th>
                  {{-- @ability('hrms_admin', 'hrms-edit|hrms-delete') --}}
                    <th>Actions</th>
                  {{-- @endpermission --}}
                </tr>
              </thead>
              <tbody>
               @php $count = 0; @endphp
                @foreach($yearList as $index)
                    <tr class="text-center" >
                      <td>{{++$count}}</td>
                      <td>{{$index->year_from }} : {{$index->year_to}}</td>
                      <td>{{$index->description}}</td>
                      <td>
                        <div class="row">
                          <div class="col" align="center">
                            <a href="{{route('financial-year.edit', $index->id)}}" class="btn btn-sm btn-info">EDIT</a>
                          </div>
                          <div class="col" align="left">
                            <form  action=" {{route('financial-year.destroy',$index->id)}} " method="POST" id="delform_{{ $index->id}}">
                              @csrf
                              @method('DELETE')
                              <a href="javascript:$('#delform_{{ $index->id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">DELETE</a>
                            </form>
                          </div>
                        </div>
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
<script>
$(document).ready(function(){

   $('#FinancialYearTable').dataTable( {
            "ordering":   true,
            order   : [[1, 'asc']],
            "columnDefs": [ 
                { "orderable": false, "targets": 0,  }
            ]
      });

   $('.btn-modal').on('click', function(){

    $.ajax({
      type: 'GET',
      url: '/hrpayroll/financial-year/create',
      success:function(res){
        $('#reqDetailTable').empty().html(res);
        $('#reqModal').modal('show');
      }
    });

  });
});
</script>
@endsection