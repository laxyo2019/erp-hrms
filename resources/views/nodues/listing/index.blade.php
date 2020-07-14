@extends('layouts.master')
@section('content')
	<main class="app-content">
			<div class="row">
      <div class="col-md-12 col-xl-12">
        <div class="card shadow-xs">
          <div class="col-md-12 col-xl-12" style="margin-top: 15px"> 
              <h1 style="font-size: 24px">No Dues Listing
                <a href="{{ route('no-dues-request.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Back</a>
              </h1>
            </div>
          <div class="card-body table-responsive">
            @if($message = Session::get('success'))
              <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{$message}}
              </div>
            @endif
            <table class="table table-striped table-hover" id="NoDuesListingTable">
              <thead>
                <tr class="text-center">
                  <th>#</th>
                  <th>Employee</th>
                  <th>Department Head</th>
                  <th>Department</th>
                  <th>Posted</th>
                  {{-- @ability('hrms_admin', 'hrms-edit|hrms-delete') --}}
                    <th>ACTIONS</th>
                  {{-- @endability --}}
                </tr>
              </thead>
              <tbody>
            @php $count = 0; @endphp
              @foreach($request as $index)
              <tr class="text-center">
                <td>{{++$count}}</td>
                <td >{{ucwords($index['employee']->emp_name)}}</td>
                <th>321</th>
                <td >{{ucwords($index['department']->name)}}</td>
                <td >{{date('M d, Y', strtotime($index->posted))}}</td>
				<td>
					<button type="button"  data-id="{{$index->id}}" class="btn btn-info btn-sm actionShow" id="{{$index->id}}">SHOW</button>
					<!-- Modal -->
          <div class="modal fade" id="reqModal" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">No Dues Approval</h4>
                </div>
                <div class="modal-body table-responsive" id="noDuesTable" style="background: #ececec">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

					{{-- <button type="button"  data-id="{{$index->id}}" class="btn btn-success btn-sm action" value="1" id="apprvBtn_{{$index->id}}">APPROVE</button>

                    <button type="button" data-id="{{$index->id}}" class="btn btn-danger btn-sm ml-2 action decline" value="2" id="decBtn_{{$index->id}}">DECLINE</button> --}}
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

  $('#NoDuesListingTable').dataTable( {
    "ordering":   true,
    order   : [[1, 'asc']],
    "columnDefs": [ 
      { "orderable": false, "targets": 0,  }
    ]
  });


  $('.actionShow').on('click', function(){

  		var request_id	= $(this).data('id');

  		$.ajax({
  			type: 'post',
  			url: "/no-dues/department-head/show/",
  			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
  			data: {'request_id': request_id},
  			success: function(res){
  				$('#noDuesTable').empty().html(res);
  				$('#reqModal').modal('show');
  			}

  		})
  })
 
});
</script>
@endsection