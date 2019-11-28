<div class="row card-body text-center">
	<div class="col-6" style="border: 1px solid black;border-radius: 6px;">
		<h4>Type</h4>
		<div>{{$leave_req['leavetype']->name}}</div>
	</div>
	<div class="col-6" style="border: 1px solid black;border-radius: 6px;">
		<h4>Leave Start</h4>
		<div>{{$leave_req->from}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" style="border: 1px solid black;border-radius: 6px;">
		<h4>Leave Ends</h4>
		<div>{{$leave_req->to}}</div>
	</div>
	<div class="col-6" style="border: 1px solid black;border-radius: 6px;">
		<h4>Duration</h4>
		<div>{{$leave_req->count}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" style="border: 1px solid black;border-radius: 6px;">
		<h4>Status</h4>
		<div>{{$leave_req['approvalaction']->name}}</div>
	</div>
	<div class="col-6" style="border: 1px solid black;border-radius: 6px;">
		<h4>Reason</h4>
		<div>{{$leave_req->reason}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" style="border: 1px solid black;border-radius: 6px;">
		<h4>Document</h4>
		<div>@if($leave_req->file_path != null)
				<a href="{{route('request.document', [$leave_req->id])}}"><i class="fa fa-arrow-down"></i>Download</a>
			@endif
		</div>
	</div>
	<div class="col-6" style="border: 1px solid black;border-radius: 6px;">
		<h4>Contact No</h4>
		<div>{{$leave_req->contact_no}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" style="border: 1px solid black;border-radius: 6px;">
		<h4>Address</h4>
		<div>{{$leave_req->status}}</div>
	</div>
	<div class="col-6" style="border: 1px solid black;border-radius: 6px;">
		<h4>Applicant's Remark</h4>
		<div>{{$leave_req->applicant_remark}}</div>
	</div>
</div>