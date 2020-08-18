<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Leave Period</h4>
		<div>
			@if($leave_req->day_status == 3)
				<strong>From - </strong> {{date('d M', strtotime($leave_req->from))}} <strong>To - </strong> {{date('d M, Y', strtotime($leave_req->to))}}
			@else
				{{date('d M, Y', strtotime($leave_req->from))}}
			@endif
		</div>
	</div>
	<div class="col-6" >
		<h4>Leave Type</h4>
		<div>{{ucwords($leave_req['leavetype']->name)}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Duration</h4>
		<div>
			@if($leave_req->day_status == 0)
				First half
			@elseif($leave_req->day_status == 1)
				Second half
			@elseif($leave_req->day_status == 2)
				1 Day
			@elseif($leave_req->day_status == 3)
				{{$leave_req->count}} days
			@endif
		</div>
	</div>
	<div class="col-6" >
		<h4>Reason</h4>
		<div>{{!empty($leave_req->reason) ? $leave_req->reason : 'Not Mentioned'}}</div>
	</div>
	
</div>
<div class="row card-body text-center">
	
	<div class="col-6" >
		<h4>Document</h4>
		<div>@if($leave_req->file_path != null)
				<a href="{{route('request.document', [$leave_req->id])}}"><i class="fa fa-arrow-down"></i>Download</a>
			@else
				Not Available
			@endif
		</div>
	</div>
	<div class="col-6" >
		<h4>Contact No</h4>
		<div>{{!empty($leave_req->contact_no) ? $leave_req->contact_no : 'Not Mentioned'}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Address</h4>
		<div>{{!empty($leave_req->addr_during_leave) ? $leave_req->addr_during_leave : 'Not Mentioned'}}</div>
	</div>
	<div class="col-6" >
		<h4>Leave Reversed</h4>
		<div>{{!empty($leave_req->carry) ? 'Yes' : ''}}</div>
	</div>
	
</div>

@if(!empty($leave_req['rejected_by']))
<hr>

<div class="row card-body text-center">
	
	<div class="col-12" >
		<h4>Leave canceled by - {{ucwords($leave_req['leave_rejected']->name)}}</h4>
		<div>{{$leave_req->approver_remark}}</div>
	</div>
	
</div>

@endif