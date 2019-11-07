@extends('layouts.master')
@section('content')
	<main class="app-content">
		<div class="row">
			<div class="col-md-12 col-xl-12">
				<h1 style="font-size: 24px">Leaves
					<span class="ml-2">
						<a href="{{url('employee/leaves/create')}}" class="btn btn-sm btn-success" style="font-size: 13px">
						<span class="fa fa-plus "></span> Add New</a>
					</span>
					<div class="row d-flex justify-content-center ">
						<div class="col-sm-3">
						<div class="column card-body">
						<center>
							<div class="card " style="min-height:150px;background-image: linear-gradient(to bottom,#1D976C, #62fb9b	);color: white;">
							<br>
							<h3>Privilege  Leave</h3>
							<h1></h1>
							<br>
							</div>
						</center>
						</div>
						</div>
						<div class="col-sm-3">
						<div class="column card-body">
						<center>
							<div class="card " style="min-height:150px;background-image: linear-gradient(to bottom,#1D976C, #62fb9b	);color: white;">
							<br>
							<h3>Privilege  Leave</h3>
							<h1></h1>
							<br>
							</div>
						</center>
						</div>
						</div>
						<div class="col-sm-3">
						<div class="column card-body">
						<center>
							<div class="card " style="min-height:150px;background-image: linear-gradient(to bottom,#1D976C, #62fb9b	);color: white;">
							<br>
							<h3>Privilege  Leave</h3>
							<h1></h1>
							<br>
							</div>
						</center>
						</div>
						</div>
						<div class="clearfix" style="margin-top:20px;margin-bottom:30px;"></div>

					</div>
				</h1>
				<hr>
			</div>
		</div>
		@if($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				{{$message}}
			</div>
		@endif
			<div class="row ">
			<div class="col-md-12 col-xl-12">
				<div class="card">
					<div class="card-body table-responsive">
						<table class="table table-stripped table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Leave Type</th>	
									<th>Leave starts</th>
									<th>Leave ends</th>
									<th>Duration</th>
									<th>Status</th>
									<th>Posted on</th>
									{{-- <th>Approver Remark</th> --}}
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@php $count = 0;@endphp
							@foreach($employee->leaveapplies as $leaveapply)
							<tr>
								<td>{{++$count}}</td>
								<td>{{$leaveapply['leavetype']->name}}</td>
								<td>{{date('d M Y' , strtotime($leaveapply->from))}}</td>
								<td>{{date('d M Y' , strtotime($leaveapply->to))}}</td>
								<td>1 day</td>
								<td>{{$leaveapply['approvalaction']->name}}</td>
								<td>{{date('d M Y' , strtotime($leaveapply->created_at))}}</td>							
								<td class='d-flex' style="border-bottom:none">
									<span>
										<a href="{{url('employee/leaves/'.$employee->id.'/edit')}}" class="btn btn-sm btn-success"><i class="fa fa-edit text-white" style="font-size: 12px;"></i></a>
									</span>
									<span class="ml-2">
										<a href="{{url('employee/leaves/'.$employee->id)}}" class="btn btn-sm btn-info"><i class="fa fa-eye text-white" style="font-size: 12px;"></i></a>
									</span>
									<span class="ml-2">
										<form action="{{url('employee/leaves/'.$employee->id)}}" method="POST" id="delform_{{ $employee->id}}">
												@csrf
												@method('DELETE')
											<a href="javascript:$('#delform_{{$employee->id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash text-white"  style="font-size: 12px;"></i></a>
										</form>
									</span> 
								</td>
								</tr>
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
	</script>
@endsection

