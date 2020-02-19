@extends('layouts.master')
@section('content')
<main class="app-content">
		<div class="row">
			<div class="col-md-12 col-xl-12">
				<h1 style="font-size: 24px">Employees
					<span class="ml-2">
						<button class="btn btn-sm btn-info"  data-toggle="modal" data-target="#import-modal" style="font-size:13px" >
							<form action="{{route('employees.import')}}" method="POST" enctype="multipart/form-data">
								@csrf
								<input type="file" onchange="this.form.submit()" name="import" class="hidden" style="display:none" id="FileUpload">
								<i class="fa fa-cloud-upload" id="btnFileUpload"> Import Employees</i> </label>
							</form>
						</button>
					</span>
					<span class="ml-2">
						<a  class="btn btn-sm btn-primary export" style="font-size:13px; color: white" id="export">
							<span class="fa fa-download"></span> Export Employees
						</a>
						<a hidden href="{{route('employees.export')}}" class="btn btn-sm btn-primary export" style="font-size:13px" id="exportone">
							<span class="fa fa-download"></span> Export Employeess
						</a>
					</span>
				</h1>
				<hr>
			</div>
		</div>
			<div class="row ">
			<div class="col-md-12 col-xl-12">
				<div class="card">
			 	<!-- <div class="card-header">
					<ul class="nav nav-pills">
					  <li class="nav-item">
					    <a class="nav-link {{call_user_func_array('Request::is', (array)['*/']) ? 'active' : ''}}" href="">Active Employees</a>
					  </li>
					  <li class="nav-item">
					    <a class="nav-link {{call_user_func_array('Request::is', (array)['**']) ? 'active' : ''}}"  href="">Inactive Employees</a>
					  </li>
					</ul>
				</div> -->
					<div class="card-body table-responsive">
						@if($message = Session::get('success'))
							<div class="alert alert-success alert-block">
								<button type="button" class="close" data-dismiss="alert">×</button>
								{{$message}}
							</div>
						@endif
						<table class="table table-stripped table-bordered" id="ClientsTable">
							<thead>
								<tr>
									<th><input type="checkbox" id="checkedall"> # </th>
									<th>Employee Name </th>
									<th>Employee Code</th>
									<th>Grade Code</th>
									<th>Designation</th>
									<th>Leaves</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							@php $count = 0; @endphp
							@foreach($employees as $employee)
								<tr>
									<td ><input type="checkbox" value="{{$employee->user_id}}" class="emp" name="checked"> {{$employee->user_id}} </td>
									<td>{{ucwords($employee->emp_name)}}</td>
									<td>{{$employee->emp_code}}</td>
									{{-- <td>@if($employee->company!=null) {{$employee->company->comp_name}} @endif</td> --}}
									<td>@if($employee->grade!=null) {{$employee->grade->name}} @endif</td>
									<td>{{$employee->designation['desg_name']}}</td>
									<td>

							{{-- hide allotment button if leave is not created --}}
							@if(count($leaves) == null)

								No leaves to assign

							@else
								@if($employee->leave_allotted == 0)
								<button class="btn btn-sm btn-info ml-2 modalAllot" data-id="{{$employee->user_id}}">
								<span style="font-size: 12px">Allot</span>
								</button>
								<div class="modal fade" id="allotmentsModal" role="dialog">
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
								</div>
								@else
								Allotted
								@endif
							@endif
									</td>
									<td >
							<div class="row">
							@if($employee->status == 0)
			                  	<div  class="col" align="center">
			                    <form  action="{{route('active', $employee->user_id)}}" method="POST" id="active_{{ $employee->user_id}}">
			                      @csrf
			                      <input type="hidden" name="flag" value="">
			                      <a href="javascript:$('#active_{{ $employee->user_id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Activate employee ?')">Active</a>
			                      </form>
			                    </div>
			                @else
			                	<div class="col" align="center">
			                    <form  action="{{route('active', $employee->user_id)}}" method="POST" id="active_{{ $employee->user_id}}">
			                      @csrf
			                      <input type="hidden" name="flag" value="{{date("Y-m-d H:i:s", time())}}">
			                      <a href="javascript:$('#active_{{ $employee->user_id}}').submit();" class="btn btn-sm btn-primary" onclick="return confirm('Deactivate employee ?')">Deactive</a>
			                      </form>
			                    </div>
			                @endif
							</div>

                  			</td>
									
									<td class='d-flex' style="border-bottom:none">
										<span>
											<a href="{{route('employee.view-details',['id'=>$employee->user_id,'view'=>'personal'])}}" class="btn btn-sm btn-info"><i class="fa fa-eye text-white" style="font-size: 12px;"></i></a>
										</span>
										<span class="ml-2">
<a href="
{{route('employee.show_page',['id'=>$employee->user_id,'tab'=>'personal'])}}" class="btn btn-sm btn-success"><i class="fa fa-edit text-white" style="font-size: 12px;"></i></a>
										</span>
										<span class="ml-2">
<form action="
{{route('employees.destroy', ['id' => $employee->user_id])}}" method="POST" id="delform_{{ $employee->user_id}}">
												@csrf
												@method('DELETE')
												<a href="javascript:$('#delform_{{$employee->user_id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash text-white"  style="font-size: 12px;"></i></a>			
											</form>
										</span>
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
	$('#ClientsTable').dataTable( {
	        "columnDefs": [
	    { "orderable": false, "targets": 0 }
	  ]
	} );
	$('#btnFileUpload').on('click', function(){
        $('#FileUpload').trigger('click');

    });

	$('.modalAllot').on('click', function(e){
        e.preventDefault();
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