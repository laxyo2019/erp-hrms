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
								<i class="fa fa-cloud-upload" id="btnFileUpload"></i> Upload Files</label>
							</form>
						</button>
					</span>
					<span class="ml-2">
						<a href="{{route('employees.export')}}" class="btn btn-sm btn-primary" style="font-size:13px">
							<span class="fa fa-download"></span> Export
						</a>
					</span>
				</h1>
				<hr>
			</div>
		</div>
			<div class="row ">
			<div class="col-md-12 col-xl-12">
				<div class="card">
			{{-- 	<div class="card-header">
					<ul class="nav nav-pills">
					  <li class="nav-item">
					    <a class="nav-link {{call_user_func_array('Request::is', (array)['*/employees']) ? 'active' : ''}}" href="{{route('employees.index')}}">Active Employees</a>
					  </li>
					  <li class="nav-item">
					    <a class="nav-link {{call_user_func_array('Request::is', (array)['*inactiveEmployees*']) ? 'active' : ''}}"  href="{{route('employees.inactiveEmployees')}}">Inactive Employees</a>
					  </li>
					</ul>
				</div> --}}
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
									<th>ID</th>
									<th>Employee Name</th>
									<th>Employee Code</th>
									{{-- <th>Company</th> --}}
									<th>Grade Code</th>
									<th>Designation</th>
									<th>Status</th>
									<th>Leaves</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							@php $count = 0; @endphp
							@foreach($employees as $employee)
								<tr>
									<td>{{++$count}}</td>
									<td>{{ucwords($employee->emp_name)}}</td>
									<td>{{$employee->emp_code}}</td>
									{{-- <td>@if($employee->company!=null) {{$employee->company->comp_name}} @endif</td> --}}
									<td>@if($employee->grade!=null) {{$employee->grade->name}} @endif</td>
									<td>{{$employee->designation['desg_name']}}</td>
									<td>{{$employee->active ==1 ? 'Active' : 'Inactive'}}</td>
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
										        	{{-- <div class="modal-footer">
										          		<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
										        	</div> --}}
										        </div>
										    </div>
										</div>
										@else
											<span style="color: green">Allotted</span>
										@endif
									</td>
									<td class='d-flex' style="border-bottom:none">
										<span>
											<a href="{{route('employee.view-details',['id'=>$employee->id,'view'=>'official'])}}" class="btn btn-sm btn-info"><i class="fa fa-eye text-white" style="font-size: 12px;"></i></a>
										</span>
										<span class="ml-2">
											{{-- Edit by kishan developer --}}
											<a href="{{route('employee.show_page',['id'=>$employee->id,'tab'=>'official'])}}" class="btn btn-sm btn-success"><i class="fa fa-edit text-white" style="font-size: 12px;"></i></a>
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
	$('#ClientsTable').DataTable();

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
 });
</script>
@endsection