<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Employee</h4>
		<div>{{!empty($data['employee']->emp_name) ? ucwords($data['employee']->emp_name) : 'Not Available' }}</div>
	</div>
	<div class="col-6" >
		<h4>Report To</h4>
		<div>{{ucwords($data['reportsto']->emp_name)}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6">
		<h4>Leave Start</h4>
		<div>
			@if($data->from && $data->to)
				{{date('d M', strtotime($data->from))}} <strong>To</strong> {{date('d M, Y', strtotime($data->to))}}
			@else
				{{date('d M, Y', strtotime($data->from))}}
			@endif
		</div>
	</div>
	<div class="col-6">
		<h4>Type</h4>
		<div>{{ucwords($data['leavetype']->name)}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Duration</h4>
		<div>
			@if($data->day_status == 0)
				First half
			@elseif($data->day_status == 1)
				Second half
			@elseif($data->day_status == 2)
				1 Day
			@elseif($data->day_status == 3)
				{{$data->count}} days
			@endif
{{--
{{ !empty($data->first_half || $data->second_half) ? 'Half day' : $data->count.' days'}} --}}
		</div>
	</div>
	<div class="col-6" >
		<h4>Contact No</h4>
		<div>{{!empty($data->contact_no) ? $data->contact_no : 'Not Mentioned'}}</div>
	</div>
	
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Reason</h4>
		<div>{{!empty($data->reason) ? $data->reason : 'Not Mentioned'}}</div>
	</div>
	<div class="col-6">
		<h4>Document</h4>
		@if($data->file_path != null)
			<td><a href="{{route('request.document', [$data->id])}}"><i class="fa fa-arrow-down"></i>Download</a></td>
		@else
			<td>Not Avalable</td>
		@endif
		
	</div>
	
</div>
<div class="row card-body text-center">
	<div class="col-6">
		<h4>Address</h4>
		<div>{{!empty($data->addr_during_leave) ? $data->addr_during_leave : 'Not Mentioned'}}</div>
	</div>
	<div class="col-6" >
		<h4>Applicant's Remark</h4>
		<div>{{!empty($data->applicant_remark) ? $data->applicant_remark : 'Not Mentioned'}}</div>
	</div>
</div>

@if(!empty($data['leave_rejected']))
	<hr>
	<div class="row card-body text-center">
		<div class="col-12" >
		<h4>Leave canceled by - {{ucwords($data['leave_rejected']->name)}}</h4>
		<div>{{$data->approver_remark}}</div>
	</div>
	</div>

@endif