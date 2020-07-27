<table class="table table-stripped table-bordered" id="RequestTable">
	<thead>
		<tr>
			<th>#</th>
			<th>EMPLOYEE</th>
			<th>TYPE</th>
			<th>LEAVE PERIOD</th>
			<th>DURATION</th>
			<th>POSTED ON</th>
			<th>TEAM LEAD</th>
			<th>ADMIN</th>
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
					<td><strong style="
					color: grey;">PENDING</strong></td>
				@elseif($request->teamlead_approval == 1)
					<td><strong class="apprv_msg">APPROVED</strong></td>
				@elseif($request->teamlead_approval == 2)
					<td><strong class="dec_msg">DECLINED</strong></td>
				@elseif($request->teamlead_approval == 3)
					<td><strong class="rev_msg">REVERSED</strong></td>
				@elseif($request->teamlead_approval == 4)
					<td><strong >N/A</strong></td>
				@endif

				@if($request->admin_approval == 0)
					<td><strong style="color: grey;">PENDING</strong></td>
				@elseif($request->admin_approval == 1)
					<td><strong class="apprv_msg">APPROVED</strong></td>
				@elseif($request->admin_approval == 2)
					<td><strong class="dec_msg">DECLINED</strong></td>
				@elseif($request->admin_approval == 3)
					<td><strong class="rev_msg">REVERSED</strong></td>
				@endif
				<td>
					<button class="btn btn-sm btn-info modalReq" data-id="{{$request->id}}">
						<i class="fa fa-eye" style="font-size: 12px;"></i>
					</button>
				</td>
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
				<td style="border-bottom:none; text-align: center;">

					{{-- SUB-ADMIN --}}

				{{-- 	Approve/Decline button for SubAdmin 	--}}

				@if($request->teamlead_approval == 1 && $request->subadmin_approval == 0 && auth()->user()->hasrole('hrms_hr') || $request->teamlead_approval == 4 && $request->subadmin_approval == 0 && auth()->user()->hasrole('hrms_hr'))

					<strong class="apprv_msg" id="apprv_msg_{{$request->id}}" style="display: none;" >APPROVED</strong>
					<strong class="dec_msg" id="dec_msg_{{$request->id}}" style="display: none;" >DECLINED</strong>

					<button type="button"  data-id="{{$request->id}}" class="btn btn-success btn-sm action" value="1" id="apprvBtn_{{$request->id}}">APPROVE</button>

					<button type="button" data-id="{{$request->id}}" class="btn btn-danger btn-sm ml-2 action decline" value="2" id="decBtn_{{$request->id}}">DECLINE</button>

				{{-- Reverse Leave button for SubAdmin --}}

				@elseif($request->teamlead_approval == 1 && $request->subadmin_approval == 1 && $request->admin_approval == 1 && auth()->user()->hasrole('hrms_hr') || $request->teamlead_approval == 4 && $request->subadmin_approval == 1 && $request->admin_approval == 1 && auth()->user()->hasrole('hrms_hr'))
					
					<div class="rev_msg" id="rev_msg_{{$request->id}}" style="display: none;">REVERSED</div>

					<button type="button" data-id="{{$request->id}}" class="btn btn-sm reverse" value="{{$request->id}}" id="revBtn_{{$request->id}}">REVERSE</button>

				{{-- Approve/Decline/Reverse message for SubAdmin --}}

				@elseif($request->subadmin_approval == 1 && auth()->user()->hasrole('hrms_hr'))
					
					<strong class="apprv_msg">APPROVED</strong>

				@elseif($request->subadmin_approval == 2 && auth()->user()->hasrole('hrms_hr'))
					
					<strong class="dec_msg">DECLINED</strong>

				{{-- When subadmin appproved and admin reversed the request --}}
				{{-- @elseif($request->subadmin_approval == 1 && $request->admin_approval == 3 && auth()->user()->hasrole('hrms_hr'))
					
					<strong class="apprv_msg">APPROVE</strong> --}}

				@elseif($request->subadmin_approval == 3 && $request->admin_approval == 1 && auth()->user()->hasrole('hrms_hr'))
					<strong class="rev_msg">REVERSED</strong>
				@endif
			</tr>
		@endforeach
	</tbody>
</table>
<script type="text/javascript">
	$('#RequestTable').dataTable( {
	    "ordering":   true,
	    order   : [[1, 'asc']],
	    "columnDefs": [ 
	      { "orderable": false, "targets": 0,  }
	    ]
	});
</script>