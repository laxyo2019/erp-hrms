@extends('layouts.master')
@section('content')
	<main class="app-content">
		<div class="row">
			<div class="col-md-12 col-xl-12">
				<h1 style="font-size: 24px">Leaves
					@if(count($balance['allotments']) != 0)
						@if($balance['allotments'][0]->status == 1)
							<span class="ml-2">
								<a href="{{url('employee/leaves/create')}}" class="btn btn-sm btn-success" style="font-size: 13px">
								<span class="fa fa-plus "></span> Apply for Leave</a>
							</span>
						@endif
					@endif
						<a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right" style="font-size:13px"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a></h1>

					<div class="row d-flex justify-content-center ">
						@php if(!empty($balance['allotments'])){ @endphp
						@foreach($balance['allotments'] as $index)	

						@if(empty($index['leaves']->dont_show))				
						<div class="col-sm-3">
							<div class="column card-body">
								<center>
									<div class="card " style="min-height:150px;background-image: linear-gradient(to bottom,#31c54a, #6fb183);color: white;">
									<br>
									<h3>{{ucwords($index['leaves']->name)}}</h3>
									<h1>{{$index->initial_bal}}</h1>
									<br>
									{{-- dd(index->current_bal); --}}
									</div>
								</center>
							</div>
						</div>
						@endif
						@endforeach
						 @php } @endphp
						<div class="clearfix" style="margin-top:20px;margin-bottom:30px;"></div>
					</div>
				</h1>
				<hr>
			</div>
		</div>
		<div class="row mt-1">
			<div class="col-md-12 col-xl-12">
				<div class="card">
					<div class="card-body table-responsive">
						<table class="table table-stripped table-bordered" id="ClientsTable">
							<thead>
								<tr>
									<th>#</th>
									<th>Leave Type</th>	
									<th>Leave Period</th>
									<th>Duration</th>
									<th>Posted on</th>
									<th>Status</th>
									{{-- <th>Approver Remark</th> --}}
									<th class="text-center">Actions</th>
								</tr>
							</thead>
							<tbody>
								{{-- @foreach($employee as $leaveapply)
								@endforeach --}}
							@php $count = 0; @endphp
								@if( !empty($leaves) )
								{{-- {{dd($leaves)}} --}}
								@foreach($leaves as $leaveapply)
								<tr>{{-- {{empty($leaveapply['approvalaction']->name)}} --}}
									<td>{{++$count}}</td>
									<td>{{ucwords($leaveapply['leavetype']->name)}}</td>
									<td>@php 
											$date = date('d M', strtotime($leaveapply->from)).' To '.date('d M, Y', strtotime($leaveapply->to));
											$date2 = date('M d, Y', strtotime($leaveapply->from));
										@endphp

										{{!empty($leaveapply->from && $leaveapply->to) ? $date : $date2}}
									</td>
									<td>
										{{-- {{ !empty($leaveapply->first_half || $leaveapply->second_half) ? 'Half day' : $leaveapply->count.' days'}} --}}
										
										@if($leaveapply->day_status == 0)
											First half
										@elseif($leaveapply->day_status == 1)
											Second half
										@elseif($leaveapply->day_status == 2)
											1 Day
										@elseif($leaveapply->day_status == 3)
											{{$leaveapply->count}} days
										@endif
									</td>
									<td>{{date('d M Y' , strtotime($leaveapply->created_at))}}</td>
									<td>
{{-- @if($leaveapply->status =='17' )
	<div >
	<strong style="color: red;">
	DECLINE
	</strong>
	</div>
	<div>
	<u>@if(!empty($leaveapply->approve_name) )
	{{'By'.' ' }}
	({{$leaveapply['approve_name']->name}})
	</u>@endif
	</div> 
--}}
										 
						@if(empty($leaveapply->status))
							<div >
							 	<strong style="color: grey;">
							 		PENDING
								</strong>
							</div>
						@else
							<div >
							 	<strong style="color: green;">
							 		{{ucwords($leaveapply['approvalaction']->name)}} 
							 	</strong>by
							 	<p>
							 		{{ucwords($leaveapply['approve_name']->emp_name)}}</p>
							</div>
						@endif
						{{-- <div>
							<u>
								@if($leaveapply->approve_name)
									by
									{{ucwords($leaveapply['approve_name']->emp_name)}}
								@endif</u>
						</div> --}}
							{{-- {{empty($leaveapply['approvalaction']->name) ? 'Decline'  : strtoupper($leaveapply['approvalaction']->name)}} --}}
								</td>
									
									<td class='d-flex' style="border-bottom:none">
										<button class="btn btn-sm btn-info modalLeave ml-2" data-id="{{$leaveapply->id}}">
											<i class="fa fa-eye" style="font-size: 12px"></i>
										</button>
										<div class="modal fade" id="expModal" role="dialog">
										     <div class="modal-dialog modal-lg" >
										    	<div class="modal-content" >
										        	<div class="modal-header">
										        		<h4 class="modal-title">Leave Details</h4>
										        	</div>
										        	<div class="modal-body table-responsive" id="modalTable" style="background: #ececec">
										        	</div>
										        	<div class="modal-footer">
										          		<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
										        	</div>
										        </div>
										    </div>
										</div>
										@if(empty($leaveapply->status))
										{{-- <span class="ml-2">
											<a href="{{url('employee/leaves/'.$leaveapply->id.'/edit')}}" class="btn btn-sm btn-success"><i class="fa fa-edit text-white" style="font-size: 12px;"></i></a>
										</span>	 --}}									
										<span class="ml-2">
<form action="{{url('employee/leaves/'.$leaveapply->id)}}" method="POST" id="delform_{{ $leaveapply->id}}">
		@csrf
		@method('DELETE')
	<a href="javascript:$('#delform_{{$leaveapply->id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash text-white"  style="font-size: 12px;"></i></a>
</form>
										</span> 
										@endif
									</td>
								</tr>
								@endforeach
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
</main>

<script type="text/javascript">
	$(document).ready(function(){
		// $('#ClientsTable').DataTable();
	 
		$('.modalLeave').on('click', function(e){
			e.preventDefault();
			var id = $(this).data('id');
			//alert(id);
			$.ajax({
				type:'get',
				url: "/leave-show/"+id,
				//headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				success:function(data){
					// alert(data);
					$('#expModal').modal('show');
					$('#modalTable').html(data);					
				}
			})
		})
	});

</script>
@endsection

