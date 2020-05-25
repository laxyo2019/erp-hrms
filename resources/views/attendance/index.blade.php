@extends('layouts.master')
@section('content')
<main class="app-content">
	<div class="row ">
		<div class="col-md-12 col-xl-12">
			<div class="card">
			 	<div class="col-md-12 col-xl-12" style="margin-top: 15px">
					<h1 style="font-size: 24px">Attendance
						<span class="ml-2">
							<button class="btn btn-sm btn-info"  data-toggle="modal" data-target="#import-modal" style="font-size:13px" >
								<form action="{{route('employees.import')}}" method="POST" enctype="multipart/form-data">
								@csrf
								<input type="file" onchange="this.form.submit()" name="import" class="hidden" style="display:none" id="FileUpload">
								<i class="fa fa-cloud-upload" id="btnFileUpload"> Attendance</i> </label>
								</form>
							</button>
						</span>
						<span class="ml-2">
							<a  class="btn btn-sm btn-primary export" style="font-size:13px; color: white" id="export">
								<span class="fa fa-download"></span> Export Attendance
							</a>
							<a hidden href="{{route('employees.export')}}" class="btn btn-sm btn-primary export" style="font-size:13px" id="exportone">
								<span class="fa fa-download"></span> Export Employeess
							</a>
						</span>
					</h1>
				</div>
				{{-- @php dd(request()->segment(2)); @endphp --}}
				 <div class="card-body table-responsive">
          @if($message = Session::get('success'))
            <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button>
              {{$message}}
            </div>
          @endif
          <table class="table table-striped table-hover" id="UsersTable">
            <thead>
              <tr class="text-center">
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                
                  <th>Actions</th>
                
              </tr>
            </thead>
            <tbody>
         {{--  @php $count = 0; @endphp
            @foreach($users as $index)
                    <tr class="text-center" >
                      <td> {{++$count}}</td>
                      <td>{{ucwords($index->name)}}</td>
                      <td>{{$index->email}}</td>
                      @ability('hrms_admin', 'hrms-edit')
                        <td >
                          <div class="row">
                            
                              <div class="col" align="center">
                              <a href="{{route('users.edit',$index->id)}}" class="btn btn-sm btn-info">EDIT</a>
                              </div>
                            
                          </div>
                        </td>
                      @endability
                    </tr>
                @endforeach --}}
            </tbody>
          </table>
        </div>
			</div>
		</div>
	</div>
	{{-- <div class="modal fade" id="allotmentsModal" role="dialog">
		<div class="modal-dialog modal-lg" >
			<div class="modal-content" >
				<div class="modal-header">
					<h4 class="modal-title">Leaves Allotments</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body table-responsive" id="modalform">
				</div>
			</div>
		</div>
	</div> --}}
</main>
<script type="text/javascript">
$(document).ready(function(){
	$('#EmployeesTable').dataTable( {
		
		order: [[1, 'asc']],

	    "columnDefs": [
	    { "orderable": false, "targets": 0 }
	  ]
	} );
	$('#btnFileUpload').on('click', function(){
        $('#FileUpload').trigger('click');

    });

	$(document).on('click','.modalAllot1', function(event){
        event.preventDefault();
        var user_id = $(this).data('id');
		$.ajax({
			type: 'GET',
			url: '{{route('allotments.create')}}'												,
			data: {'user_id': user_id},
			//headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(data){
				$('#allotmentsModal').modal('show');
				$('#modalform').html(data);
			}
		});
	});
/*	create by kishan for export data using checkbox or unchecheked*/

    $("#export").click(function(){
    	var emp = [];
    	$.each($("input[name='checked']:checked"), function(){
        	emp.push($(this).val());
    	});

    	$.ajax({
    		type:'POST',
    		url:'{{route('employee.save_session')}}',
    		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    		data:{user_id:emp},
    		success:function(data){
    			 window.location.href = $('#exportone').attr('href');
    		}
    	})
	});
/***/
	
	
/*select all employee using checkbox*/
	var clicked = false;
	$("#checkedall").on("click", function() {
	  	$(".emp").prop("checked", !clicked);
	  clicked = !clicked;
	});
});
</script>
@endsection