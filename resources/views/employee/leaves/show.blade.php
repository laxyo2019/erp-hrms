<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Leave Period</h4>
		<div>
			@if($leave_req->from && $leave_req->to)
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
		<div>{{ !empty($leave_req->first_half || $leave_req->second_half) ? 'Half day' : $leave_req->count.' days'}}
		</div>
	</div>
	<div class="col-6" >
		<h4>Status</h4>
		<div>{{!empty($leave_req['approvalaction']->name) ? ucwords($leave_req['approvalaction']->name) : 'Pending' }}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Reason</h4>
		<div>{{!empty($leave_req->reason) ? $leave_req->reason : 'Not Mentioned'}}</div>
	</div>
	<div class="col-6" >
		<h4>Document</h4>
		<div>@if($leave_req->file_path != null)
				<a href="{{route('request.document', [$leave_req->id])}}"><i class="fa fa-arrow-down"></i>Download</a>
			@else
				Not Available
			@endif
		</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Contact No</h4>
		<div>{{!empty($leave_req->contact_no) ? $leave_req->contact_no : 'Not Mentioned'}}</div>
	</div>
	<div class="col-6" >
		<h4>Address</h4>
		<div>{{!empty($leave_req->address) ? $leave_req->address : 'Not Mentioned'}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Applicant's Remark</h4>
		<div>{{!empty($leave_req->applicant_remark) ? $leave_req->applicant_remark : 'Not Mentioned'}}</div>
	</div>
</div>