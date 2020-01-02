@extends('layouts.master')
@section('content')
<main class="app-content">
		<div class="row">
			<div class="col-md-12 col-xl-12">
				<h1 style="font-size: 24px">Employees
					<a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right" style="font-size:13px"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
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
						<a  class="btn btn-sm btn-primary export" style="font-size:13px" id="export">
							<span class="fa fa-download"></span> Export Employees
						</a>
						<a hidden href="{{route('employees.export')}}" class="btn btn-sm btn-primary export" style="font-size:13px" id="exportone">
							<span class="fa fa-download"></span> Export Employees
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
									<th>ID <input type="checkbox" id="checkedall"></th>
									<th>Employee Name </th>
									<th>Employee Code</th>
									<!-- <th>Company</th> -->
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
									<td >{{++$count}} <input type="checkbox" value="{{$employee->id}}" class="emp" name="checked"></td>
									<td>{{ucwords($employee->emp_name)}}</td>
									<td>{{$employee->emp_code}}</td>
									{{-- <td>@if($employee->company!=null) {{$employee->company->comp_name}} @endif</td> --}}
									<td>@if($employee->grade!=null) {{$employee->grade->name}} @endif</td>
									<td>{{$employee->designation['desg_name']}}</td>
									<td>
		@if(empty($employee->leave_allotted))
			<button class="btn btn-sm btn-info ml-2 modalAllot" data-id="{{$employee->id}}">
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
<button class="btn btn-sm btn-danger ml-2">
	<form action="{{route('hold.leave',$employee->id)}}" method="POST" id="holdLeave{{ $employee->id}}">
		@csrf
		
		<a href="javascript:$('#holdLeave{{$employee->id}}').submit();" style="color: white" onclick="return confirm('Are you sure?')">Hold</i></a>			
	</form>
</button>

		@endif
									</td>
									<td ><span class="btn btn-success active-enactive" id="{{$employee->id}}"> @if('{{$employee->active ==1}}') {{'Active'}}</span> </span> @else <span class=" btn btn-danger">{{'Inactive'}}@endif </td>
									<td class='d-flex' style="border-bottom:none">
										<span>
											<a href="{{route('employee.view-details',['id'=>$employee->id,'view'=>'personal'])}}" class="btn btn-sm btn-info"><i class="fa fa-eye text-white" style="font-size: 12px;"></i></a>
										</span>
										<span class="ml-2">
											{{-- Edit by kishan developer --}}
											<a href="{{route('employee.show_page',['id'=>$employee->id,'tab'=>'personal'])}}" class="btn btn-sm btn-success"><i class="fa fa-edit text-white" style="font-size: 12px;"></i></a>
											{{-- End edit by kishan developer --}}
										</span>
										<span class="ml-2">
											<form action="{{route('employees.destroy',$employee->id)}}" method="POST" id="delform_{{ $employee->id}}">
												@csrf
												@method('DELETE')
												<a href="javascript:$('#delform_{{$employee->id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash text-white"  style="font-size: 12px;"></i></a>			
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
        var emp_id = $(this).data('id');	
		$.ajax({
			type: 'GET',
			url: '{{route('allotments.create')}}'												,
			data: {'emp_id': emp_id},
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
    		data:{id:emp},
    		success:function(data){
    			 window.location.href = $('#exportone').attr('href');
    		}
    	})
	});
	/*for active inactive employee*/
	// $(".active-enactive").click(function(){
	// 	var id = $(this).val();
	// 	alert(id);
	// 	exit();
	// 	id = '4';
	// 	$.ajax({
 //    		type:'POST',
 //    		url:'{{route('employee.active-inactive')}}',
 //    		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
 //    		data:{id:id},
 //    		success:function(data){
 //    			alert(data);
 //    		}
 //    	})
	// });
	
/*select all employee using checkbox*/
	var clicked = false;
	$("#checkedall").on("click", function() {
	  	$(".emp").prop("checked", !clicked);
	  clicked = !clicked;
	});
});
</script>
@endsection