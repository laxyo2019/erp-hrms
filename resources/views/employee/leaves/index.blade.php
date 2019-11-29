@extends('layouts.master')
@section('content')
{{-- . /usr/bin/libreoffice --}}
	<main class="app-content">
		<div class="row">
			<div class="col-md-12 col-xl-12">
				<h1 style="font-size: 24px">Leaves
					<span class="ml-2">
						<a href="{{url('employee/leaves/create')}}" class="btn btn-sm btn-success" style="font-size: 13px">
						<span class="fa fa-plus "></span> Apply for Leave</a>
					</span>
					<div class="row d-flex justify-content-center ">
						@php if(!empty($balance['allotments'])){ @endphp
						@foreach($balance['allotments'] as $index)					
						<div class="col-sm-3">
							<div class="column card-body">
								<center>
									<div class="card " style="min-height:150px;background-image: linear-gradient(to bottom,#31c54a, #6fb183);color: white;">
									<br>
									<h3>{{$index['leaves']->name}}</h3>
									<h1>{{$index->current_bal}}</h1>
									<br>
									</div>
								</center>
							</div>
						</div>
						@endforeach
						 @php } @endphp
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
									<th class="text-center">Actions</th>
								</tr>
							</thead>
							<tbody>
								@php $count = 0;

								if(!empty($employee['leaveapplies'])){
								@endphp
								@foreach($employee['leaveapplies'] as $leaveapply)
								<tr>
									<td>{{++$count}}</td>
									<td>{{$leaveapply['leavetype']->name}}</td>
									<td>{{$leaveapply->from}}</td>
									<td>{{$leaveapply->to}}</td>
									<td>{{$leaveapply->count}} days</td>
									<td>
										<strong style="font-weight: 700">
										{{empty($leaveapply['approvalaction']->name) ? 'PENDING' : strtoupper($leaveapply['approvalaction']->name)}}</strong>
									</td>
									<td>{{date('d M Y' , strtotime($leaveapply->created_at))}}</td>
									<td class='d-flex' style="border-bottom:none">
										<button class="btn btn-sm btn-info modalLeave ml-2" data-id="{{$leaveapply->id}}">
											<i class="fa fa-eye" style="font-size: 12px"></i>
										</button>
										<div class="modal fade" id="expModal" role="dialog">
										     <div class="modal-dialog modal-lg" >
										    	<div class="modal-content" >
										        	<div class="modal-header">
										        		<h4 class="modal-title">Experience</h4>
										        	</div>
										        	<div class="modal-body table-responsive" id="modalTable">
										        	</div>
										        	<div class="modal-footer">
										          		<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
										        	</div>
										        </div>
										    </div>
										</div>
										{{-- @if($leaveapply['approvalaction']->name == 'Pending') --}}
										<span class="ml-2">
											<a href="{{url('employee/leaves/'.$leaveapply->id.'/edit')}}" class="btn btn-sm btn-success"><i class="fa fa-edit text-white" style="font-size: 12px;"></i></a>
										</span>										
										<span class="ml-2">
											<form action="{{url('employee/leaves/'.$leaveapply->id)}}" method="POST" id="delform_{{ $leaveapply->id}}">
													@csrf
													@method('DELETE')
												<a href="javascript:$('#delform_{{$leaveapply->id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash text-white"  style="font-size: 12px;"></i></a>
											</form>
										</span> 
										{{-- @endif --}}
									</td>
								</tr>
								@endforeach
								@php } @endphp
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
</main>
<script type="text/javascript">
	$(document).ready(function(){

		$('.modalLeave').on('click', function(e){
			e.preventDefault();
			var id = $(this).data('id');
			//alert(id);
			$.ajax({
				type:'get',
				url: "/leave-show/"+id,
				//headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				success:function(data){
					alert(data);
					$('#expModal').modal('show');
					$('#modalTable').html(data);					
				}
			})
		})
	});
</script>
@endsection

