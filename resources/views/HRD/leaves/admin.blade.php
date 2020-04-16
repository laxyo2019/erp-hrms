@extends('layouts.master')
@section('content')
	<main class="app-content">
		<div class="row mt-1 ">	
			<div class="col-md-12 col-xl-12">
				<div class="card">
					<div class="col-md-12 col-xl-12" style="margin-top: 15px">
						<h1 style="font-size: 24px">LEAVE REQUESTS
						<a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right" style="font-size:13px"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
					</div>
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
									<th>#</th>
									<th>EMPLOYEE</th>
									<th>TYPE</th>
									<th>LEAVE PERIOD</th>
									<th>DURATION</th>
									<th>POSTED ON</th>
									<th>TEAM LEAD</th>
									<th>HR</th>
									<th>DETAILS</th>
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

				@if($request->teamlead_approval == 0)
					<td><strong style="color: grey;">PENDING</strong></td>
				@elseif($request->teamlead_approval == 1)
					<td><strong class="apprv_msg">APPROVED</strong></td>
				@elseif($request->teamlead_approval == 2)
					<td><strong class="dec_msg">DECLINED</strong></td>
				@elseif($request->teamlead_approval == 3)
					<td><strong class="rev_msg">REVERSED</strong></td>
				@endif


				@if($request->subadmin_approval == 0)
					<td><strong style="color: grey;">PENDING</strong></td>
				@elseif($request->subadmin_approval == 1)
					<td><strong class="apprv_msg">APPROVED</strong></td>
				@elseif($request->subadmin_approval == 2)
					<td><strong class="dec_msg">DECLINED</strong></td>
				@elseif($request->subadmin_approval == 3)
					<td><strong class="rev_msg">REVERSED</strong></td>
				@endif
		</td>
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
		
<td class='d-flex' style="border-bottom:none">

	{{-- ADMIN --}}

{{-- 		Approve/Decline button for ADMIN 		--}}

@if($request->subadmin_approval == 1 && auth()->user()->hasrole('hrms_admin') && $request->admin_approval == 0 )
	<strong class="apprv_msg" id="apprv_msg_{{$request->id}}" style="display: none;">APPROVED</strong>
	<strong class="dec_msg" id="dec_msg_{{$request->id}}" style="display: none;">DECLINED</strong>

	<button type="button" data-id="{{$request->id}}" class="btn btn-success btn-sm action" value="1" id="apprvBtn_{{$request->id}}">APPROVE</button>

	<button type="button" class="btn btn-danger btn-sm ml-2 action decline" value="2" data-id="{{$request->id}}" id="decBtn_{{$request->id}}">DECLINE</button>

{{-- Reverse button for ADMIN --}}

@elseif($request->teamlead_approval == 1 && $request->subadmin_approval == 1 && $request->admin_approval == 1 && auth()->user()->hasrole('hrms_admin'))
	<strong class="rev_msg" id="rev_msg_{{$request->id}}" style="display: none;" >REVERSED</strong>

	<button type="button" data-id="{{$request->id}}" class="btn btn-sm reverse" value="{{$request->id}}" id="revBtn_{{$request->id}}">REVERSE</button>

{{-- Approve/Decline message for Admin --}}

@elseif($request->admin_approval == 1 && auth()->user()->hasrole('hrms_admin') )

	<strong class="apprv_msg">APPROVED</strong>

@elseif($request->subadmin_approval == 1 && $request->admin_approval == 2 && auth()->user()->hasrole('hrms_admin') )
	
	<strong class="dec_msg">DECLINED</strong>

{{-- Reverse Leave message for Admin --}}

@elseif($request->subadmin_approval == 1 && $request->admin_approval == 3 && auth()->user()->hasrole('hrms_admin'))
	
	<strong class="rev_msg">REVERSED</strong>
@endif


	{{-- <div class="col-sm-12">
	<strong>{{ ucwords($request['approvalaction']->name) }} </strong> <br>by <u>{{ucwords($request['approve_name']->emp_name)}}</u>	
	</div>  --}}
	
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

	//Open detail view of leave requests.

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
	});

	// Approve/Decline requests.

	$('.action').on('click', function(){

		var action 		= $(this).val();
		var request_id 	= $(this).data('id');

		//alert([action, request_id]);

		if(action == 2){

			var txt = prompt('Please enter reason.');

			if(txt != null){

				$('.decline').attr('value', txt);

			}else{
				return false;
			}
		}

		$.ajax({
			type: 'POST',
			url: "/leave-request/admin/"+request_id,
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {'action':action, 'text':txt},
			success:function(res){

				if(res.flag == 1){
					$('#apprvBtn_'+request_id).hide();
					$('#decBtn_'+request_id).hide();
					if(res.action == 1){
						$('#apprv_msg_'+request_id).show();
					}else{
						
						$('#dec_msg_'+request_id).show();
					}
				}
			}
		})
	});

	//Reverse leaves
	
	$('.reverse').on('click', function(){
		
		var request_id 	= $(this).val();
		$.ajax({
			type: 'POST',
			url: '/reverse/admin/'+request_id,
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			//data: {action:'action'},
			success:function(res){

				if(res.flag == 1){
					$('#revBtn_'+request_id).hide();
					$('#rev_msg_'+request_id).show();
				}else if(res.flag ==  0){
					alert(res.msg)
					location.reload();
				}
			}
		});
	});
  });


</script>
<style type="text/css">
	.approve
	{
		background: #0cac0c;
		color: white;
	}
	.decline
	{
		background: #ff1414;
		color: white;
	}
	.reverse
	{
		background: #3375ca;
		color: white;
	}
	.apprv_msg{
		color: #0cac0c;
	}
	.dec_msg{
		color: #ff1414;
	}
	.rev_msg{
		color: #3375ca;
	}

</style>

@endsection