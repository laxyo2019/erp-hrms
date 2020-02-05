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
									@if(auth()->user()->hasrole('admin'))
										<th>HR</th>
									@else
										<th>ADMIN</th>
									@endif
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
	
			@if($request->admin_approval == 1 && auth()->user()->hasrole('hr manager'))
				<strong style="color: green;">APPROVED</strong>

			@elseif($request->admin_approval == 2 && auth()->user()->hasrole('hr manager'))
				<strong style="color: #ff4545;">DECLINED</strong>

			@elseif($request->admin_approval == 3 && auth()->user()->hasrole('hr manager'))
				<strong style="color: #5858ff;">REVERSED</strong>

			@elseif($request->subadmin_approval == 1 && auth()->user()->hasrole('admin'))
				<strong style="color: green;">APPROVED</strong>

			@elseif($request->admin_approval == 0 && auth()->user()->hasrole('hr manager'))
				<strong style="color: grey;">PENDING</strong>

			@endif

		</td>
		
<td class='d-flex' style="border-bottom:none">

{{-- 	Approve/Decline button for SubAdmin 	--}}

@if($request->subadmin_approval == 0 && auth()->user()->hasrole('hr manager'))
	<strong class="msg_approve" hidden="" style="color: green;">APPROVED</strong>
	<strong class="msg_decline" hidden="" style="color: #ff4545;">DECLINED</strong>

	<button type="button" id="approve" data-id="{{$request->id}}" class="btn btn-success btn-sm action" value="1">APPROVE</button>

	<button type="button" id="decline" data-id="{{$request->id}}" class="btn btn-danger btn-sm ml-2 action" value="2">DECLINE</button>

{{-- Reverse Leave button for SubAdmin --}}

@elseif($request->subadmin_approval == 1 && $request->admin_approval == 1 && auth()->user()->hasrole('hr manager'))
	
	<div class="msg_reverse" hidden="">REVERSED</div>
	<button type="button" id="reverse"  class="btn btn-success btn-sm reverse" value="{{$request->id}}">REVERSE</button>

{{-- Approve/Decline/Reverse message for SubAdmin --}}

@elseif($request->subadmin_approval == 1 && auth()->user()->hasrole('hr manager'))
	
	<strong style="color: green;">APPROVED</strong>

@elseif($request->subadmin_approval == 2 && auth()->user()->hasrole('hr manager'))
	
	<strong style="color: #ff4545;">DECLINED</strong>

{{-- When subadmin appproved and admin reversed the request --}}
@elseif($request->subadmin_approval == 1 && $request->admin_approval == 3 && auth()->user()->hasrole('hr manager'))
	
	<strong style="color: green;">APPROVE</strong>

{{-- Reverse button for SubAdmin --}}

@elseif($request->subadmin_approval == 1 && $request->admin_approval == 1 && auth()->user()->hasrole('hr manager'))
	
	<div class="msg_reverse" hidden="">REVERSED</div>
	<button type="button" id="reverse"  class="btn btn-success btn-sm reverse" value="{{$request->id}}">REVERSE</button>

{{-- 		Approve/Decline button for ADMIN 		--}}

@elseif($request->subadmin_approval == 1 && auth()->user()->hasrole('admin') && $request->admin_approval == 0 )

	<button type="button" id="reverse_{{$request->id}}" onclick="dodo({{$request->id}})"  class="btn btn-success btn-sm reverse" value="{{$request->id}}">REVERSE</button>
	{{-- <strong class="msg_approve" style="color: green;" hidden="">APPROVED</strong> --}}
	<strong class="msg_decline" style="color: #ff4545;" hidden="">DECLINED</strong>

	<button type="button" id="approve" data-id="{{$request->id}}" class="btn btn-success btn-sm action" value="1" >APPROVE</button>

	<button type="button" id="decline" class="btn btn-danger btn-sm ml-2 action" value="2" data-id="{{$request->id}}">DECLINE</button>

{{-- Reverse button for ADMIN --}}

@elseif($request->subadmin_approval == 1 && $request->admin_approval == 1 && auth()->user()->hasrole('admin'))
	
	<div class="msg_reverse" hidden="" style="color: #5858ff;">REVERSED</div>
	<button type="button" id="reverse"  class="btn btn-success btn-sm reverse" value="{{$request->id}}">REVERSE</button>


{{-- Approve/Decline message for Admin --}}

@elseif($request->subadmin_approval == 1 && $request->admin_approval == 2 && auth()->user()->hasrole('admin') )
	
	<strong style="color: #ff4545;">DECLINED</strong>

{{-- Reverse Leave message for Admin --}}

@elseif($request->subadmin_approval == 1 && $request->admin_approval == 3 && auth()->user()->hasrole('admin'))
	
	<strong style="color: #5858ff;">REVERSED</strong>

@endif

{{--
	<div class="col-sm-12">
	<strong>{{ ucwords($request['approvalaction']->name) }} </strong> <br>by <u>{{ucwords($request['approve_name']->emp_name)}}</u>	
	</div> 
--}}


	
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

	//Store remark while declineing requests.

	$('.actions').on('click',function(){
		var btn = $(this).attr('id');

		if(btn == 1){

			var txt = prompt('Please enter reason.');

			if(txt != null){
				$('#reason').attr('value', txt);
			}else{
				return false;
			}
		}
	});

	// Approve/Decline requests.

	$('.action').on('click', function(){
		
		var action 		= $(this).val();
		var request_id 	= $(this).data('id');
		//alert([action, request_id]);
		$.ajax({
			type: 'POST',
			url: "/approve_leave/"+request_id,
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {'action':action},
			success:function(res){

				$('#approve, #decline').attr('hidden', true);
				if(res.action == 1){

					$('.msg_approve').attr('hidden', false);
				}else{
					
					$('.msg_decline').attr('hidden', false);
				}
			}
		})
	});

	//Reverse leaves
	
	//$('.reverse').on('click', function(){
	function dodo(id)	{
		//var request_id 	= $(this).val();
		alert('ohig')
		$.ajax({
			type: 'POST',
			url: '/leave-request/reverse/'+id,
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			//data: {action:'action'},
			success:function(res){

				$('#reverse').attr('hidden', true);
				$('.msg_reverse').attr('hidden', false);

			}
		});
	}

	$(".approved1").click(function(){
	    if (!confirm("Do you want to approve")){
	      return false;
	    }
	  });
  });


</script>
<style type="text/css">
	.approve
	{
		background: #0cac0c;;
		color: white;
	}
	.decline
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

@endsection