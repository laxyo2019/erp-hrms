<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Employee</h4>
		<div>{{!empty($data['employee']->emp_name) ? ucwords($data['employee']->emp_name) : 'Not Available' }}</div>
	</div>
	<div class="col-6" >
		<h4>Leave Start</h4>
	<div>
		@if($data->from && $data->to)
			{{date('d M', strtotime($data->from))}} <strong>To</strong> {{date('d M, Y', strtotime($data->to))}}
		@else
			{{date('d M, Y', strtotime($data->from))}}
		@endif
</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Type</h4>
		<div>{{ucwords($data['leavetype']->name)}}</div>
		
	</div>
	<div class="col-6" >
		<h4>Duration</h4>
		<div>
{{ !empty($data->first_half || $data->second_half) ? 'Half day' : $data->count.' days'}}
			{{-- {{$data->count}} --}}
			Days
		</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Status</h4>
		<div>{{!empty($data['approvalaction']->name) ? ucwords($data['approvalaction']->name) : 'Pending'}}</div>
	</div>
	<div class="col-6" >
		<h4>Reason</h4>
		<div>{{!empty($data->reason) ? $data->reason : 'Not Mentioned'}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Document</h4>
		@if($data->file_path != null)
			<td><a href="{{route('request.document', [$data->id])}}"><i class="fa fa-arrow-down"></i>Download</a></td>
		@else
			<td>Not Avalable</td>
		@endif
		
	</div>
	<div class="col-6" >
		<h4>Address</h4>
		<div>{{!empty($data->address) ? $data->address : 'Not Mentioned'}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Contact No</h4>
		<div>{{!empty($data->contact_no) ? $data->contact_no : 'Not Mentioned'}}</div>
	</div>
	<div class="col-6" >
		<h4>Applicant's Remark</h4>
		<div>{{!empty($data->applicant_remark) ? $data->applicant_remark : 'Not Mentioned'}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		
	</div>
</div>