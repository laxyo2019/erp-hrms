<table class="table table-stripped table-bordered" id="RequestTable">
	<thead>
		<tr>
			<th>#</th>
			<th>EMPLOYEE</th>
			<th>TYPE</th>
			<th>LEAVE PERIOD</th>
			<th>DURATION</th>
			<th>POSTED ON</th>
			<th>HR</th>
			<th>ADMIN</th>
			<th>DETAILS</th>
			<th style="text-align: center;">ACTIONS</th>
		</tr>
	</thead>
	<tbody>
		@php $count = 0; @endphp
		@foreach($leave_request as $data)
			<tr>
				<td>{{++$count}} </td>
				<td>{{ucwords($data['employee']->emp_name)}}</td>
				<td>{{ucwords($data['leavetype']->name)}}</td>
				<td>
					@if($request->day_status == 3)
						{{date('d M', strtotime($request->from))}} <strong>To</strong> {{date('d M, Y', strtotime($request->to))}}
					@else
						{{date('d M, Y', strtotime($request->from))}}
					@endif
				</td>
				<td>
					@if($data->day_status == 0)
						First half
					@elseif($data->day_status == 1)
						Second half
					@elseif($data->day_status == 2)
						1 Day
					@elseif($data->day_status == 3)
						{{$data->count}} days
					@endif						
				</td>
				<td>{{date('d M, y', strtotime($data->created_at))}}</td>

				@if($data->subadmin_approval == 0)
					<td><strong style="color: grey;">PENDING</strong></td>
				@elseif($data->subadmin_approval == 1)
					<td><strong class="apprv_msg">APPROVED</strong></td>
				@elseif($data->subadmin_approval == 2)
					<td><strong class="dec_msg">DECLINED</strong></td>
				@elseif($data->subadmin_approval == 3)
					<td><strong class="rev_msg">REVERSED</strong></td>
				@endif

				@if($data->admin_approval == 0)
					<td><strong style="color: grey;">PENDING</strong></td>
				@elseif($data->admin_approval == 1)
					<td><strong class="apprv_msg">APPROVED</strong></td>
				@elseif($data->admin_approval == 2)
					<td><strong class="dec_msg">DECLINED</strong></td>
				@elseif($data->admin_approval == 3)
					<td><strong class="rev_msg">REVERSED</strong></td>
				@endif
				<td>
					<button class="btn btn-sm btn-info modalReq" data-id="{{$data->id}}">
						<i class="fa fa-eye" style="font-size: 12px;"></i>
					</button></td>
					<div class="modal fade" id="reqModal" role="dialog">
					    <div class="modal-dialog modal-lg" >
					    	<div class="modal-content" >
					        	<div class="modal-header">
					        		<h4 class="modal-title">data Detail</h4>
					        	</div>
					        	<div class="modal-body table-responsive" id="detailTable" style="background: #ececec">
					        	</div>
					        	 <div class="modal-footer">
					          <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
					        </div>
					        </div>
					    </div>
					</div>
					<td style="border-bottom:none; text-align: center;">

	{{-- TEAM-LEAD --}}

{{-- 	Approve/Decline button for TeamLead 	--}}

					@if($data->teamlead_approval == 0 && auth()->user()->hasrole('hrms_teamlead'))

						<strong class="apprv_msg" id="apprv_msg_{{$data->id}}" style="display: none;" >APPROVED</strong>
						<strong class="dec_msg" id="dec_msg_{{$data->id}}" style="display: none;" >DECLINED</strong>

						<button type="button" data-id="{{$data->id}}" class="btn btn-success btn-sm action" value="1" id="apprvBtn_{{$data->id}}">APPROVE</button>

						<button type="button" data-id="{{$data->id}}" class="btn btn-danger btn-sm ml-2 action decline" value="2" id="decBtn_{{$data->id}}">DECLINE</button>

				{{-- Reverse Leave button for TeamLead --}}

					@elseif($data->teamlead_approval == 1 && $data->subadmin_approval == 1 && $data->admin_approval == 1 && auth()->user()->hasrole('hrms_teamlead'))
						
						<div class="rev_msg" id="rev_msg_{{$data->id}}" style="display: none;">REVERSED</div>

						<button type="button" data-id="{{$data->id}}" class="btn btn-sm reverse" value="{{$data->id}}" id="revBtn_{{$data->id}}">REVERSE</button>

				{{-- Approve/Decline/Reverse message for TeamLead --}}

					@elseif($data->teamlead_approval == 1 && auth()->user()->hasrole('hrms_teamlead'))
						
						<strong class="apprv_msg">APPROVED</strong>

					@elseif($data->teamlead_approval == 2 && auth()->user()->hasrole('hrms_teamlead'))
						
						<strong class="dec_msg">DECLINED</strong>

				{{-- When subadmin appproved and admin reversed the data --}}
				{{-- @elseif($data->teamlead_approval == 1 && $data->admin_approval == 3 && auth()->user()->hasrole('hrms_hr'))
					
					<strong class="apprv_msg">APPROVE</strong> --}}

					@elseif($data->teamlead_approval == 3 && auth()->user()->hasrole('hrms_teamlead'))
						<strong class="rev_msg">REVERSED</strong>
					@endif
				</td>
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