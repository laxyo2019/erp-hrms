@extends('layouts.master')
@section('content')
	<main class="app-content">
		<div class="row">
			<div class="col-md-12 col-xl-12">
				<h1 style="font-size: 24px">Leaves Request 
				<a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right" style="font-size:13px"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
			</div>
		</div>
		<div class="row mt-1 ">
			<div class="col-md-12 col-xl-12">
				<div class="card">
					<div class="card-body table-responsive">
						@if($message = Session::get('success'))
							<div class="alert alert-success alert-block">
								<button type="button" class="close" data-dismiss="alert" >×</button>
								{{$message}}
							</div>
						@endif 
						<table class="table table-stripped table-bordered" id="ClientsTable">
							<thead>
								<tr>
									<th>##</th>
									<th>EMPLOYEE</th>
									<th>TYPE</th>
									<th>DETAILS</th>
									<th>LEAVE PERIOD</th>
									<th>DURATION</th>
									<th>POSTED ON</th>
									<th>Reverse Leave</th>
									<th style="text-align: center;">ACTIONS</th>
								</tr>
							</thead>
							<tbody>
							@php $count = 0; @endphp
							@foreach($leave_request as $request)
								<tr>
									<td>{{++$count}} </td>
									<td>{{ucwords($request['employee']->emp_name)}}</td>
									<td>{{ucwords($request['leavetype']->name)}}</td>
									<td>
									<button class="btn btn-sm btn-info modalReq" data-id="{{$request->id}}">
										<i class="fa fa-eye" style="font-size: 12px;"></i>
									</button></td>
									<div class="modal fade" id="reqModal" role="dialog">
									    <div class="modal-dialog modal-lg" >
									    	<div class="modal-content" >
									        	<div class="modal-header">
									        		<h4 class="modal-title">Request Detail</h4>
									        	</div>
									        	<div class="modal-body table-responsive" id="detailTable" style="background: #ececec">
									        	</div>
									        	 <div class="modal-footer">
									          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
									        </div>
									        </div>
									    </div>
									</div>
									<td>
										@if($request->from && $request->to)
											{{date('d M', strtotime($request->from))}} <strong>To</strong> {{date('d M, Y', strtotime($request->to))}}
										@else
											{{date('d M, Y', strtotime($request->from))}}
										@endif
										</td>
									<td>
									@if($request->day_status == 0)
										First half
									@elseif($request->day_status == 1)
										Second half
									@elseif($request->day_status == 2)
										1 Day
									@elseif($request->day_status == 3)
										{{$request->count}} days
									@endif						
									</td>
									<td>{{date('d M, y', strtotime($request->created_at))}}</td>
									<td>

@if(!empty($request->status))
	@foreach($actions as $data)
		@if(!empty($data->reverse))
			<span class="ml-2">
				<form action="{{route('reverse.leave', $request->id)}}" method="POST" id="ression">
				@csrf
				<input type="hidden" name="leave_request" value="{{$request->id}}">
				<input type="hidden" name="action_id" value="{{$data->id}}" >
				<button  class="btn-sm" id="reverse"><i class="fa fa-undo" aria-hidden="true"></i> {{ucwords($data->name)}}</button>
				</form>
			</span>
		@endif
	@endforeach
@endif								</td>
									<td class='d-flex' style="border-bottom:none">
							
	@if($request->approver_id == null)
		@foreach($actions as $data)
		@if(empty($data->reverse))
		<span class="ml-2">
			<form action="{{url('approve_leave',$request->id)}}" method="POST" id="ression">
			@csrf
			<input type="hidden" name="leave_request" value="{{$request->id}}">
			<input type="hidden" name="action_id" value="{{$data->id}}" >
			<button  class="btn-sm" id="{{$data->name}}">{{ucwords($data->name)}}</button>
			</form>
		</span>
		@endif
		@endforeach

	@else
		<div class="col-sm-12">
			<strong>{{ ucwords($request['approvalaction']->name) }} </strong> <br>By <u>({{ucwords($request['approve_name']->emp_name)}})</u>			
		</div>
@endif
{{-- <form action="{{url('hrd/leaves')}}" method="POST" id="ression1">
		@csrf
		<input type="hidden" name="leave_request_id" value="{{$request->id}}">
		<input type="hidden" name="approval_action_id" value="{{$action->id}}">
		<input type="hidden" name="reason" value="">
		@if($action->name == 'decline')
			<button type="submit" class="btn btn-danger reason-decline" bootbox >{{$action->name}}</button>
		@elseif($action->name == 'approve')
			<button type="submit"  class="btn btn-success approved1" id='approved'>{{$action->name}}</button>
		<br><strong style="color:grey;" class="pending"> Pending</strong>
	</form> --}}
{{--  --}}
	
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

	('#')

    $(".reason-decline").click(function(){

  		var reason;
  		var text = prompt("Please enter the reason","Enter the reason");
	    if (!text){
	        return false;
	    }else {
			reason =  text;
			$('input[name="reason"]').val(reason);
		}
		
	});
	$(".approved1").click(function(){
	    if (!confirm("Do you want to approve")){
	      return false;
	    }
	  });
  });


</script>
<style type="text/css">
	#approve
	{
		background: #0cac0c;;
		color: white;
	}
	#decline
	{
		background: #ff1414;
		color: white;
	}
	#reverse
	{
		background: #3375ca;
		color: white;
	}
</style>

<script>	
	$(document).ready(function(){
		$('.modalReq').on('click', function(e){
			e.preventDefault();
			var leave_id = $(this).data('id');
			$.ajax({
				type: 'GET',
				url: '/hrd/leaves/'+leave_id,
				success:function(res){
					$('#detailTable').empty().html(res);
					$('#reqModal').modal('show');
				}
			})
		})


	});
</script>

@endsection