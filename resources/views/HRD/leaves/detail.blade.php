<div class="row card-body text-center">
	<div class="col-6" style="border: 1px solid black;border-radius: 6px;">
		<h4>Employee</h4>
		<div>{{$data['employees']->emp_name}}</div>
	</div>
	<div class="col-6" style="border: 1px solid black;border-radius: 6px;">
		<h4>Type</h4>
		<div>{{$data['leavetype']->name}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" style="border: 1px solid black;border-radius: 6px;">
		<h4>Leave Start</h4>
		<div>{{$data->from}}</div>
	</div>
	<div class="col-6" style="border: 1px solid black;border-radius: 6px;">
		<h4>Leave Ends</h4>
		<div>{{$data->to}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" style="border: 1px solid black;border-radius: 6px;">
		<h4>Duration</h4>
		<div>{{$data->count}}</div>
	</div>
	<div class="col-6" style="border: 1px solid black;border-radius: 6px;">
		<h4>Status</h4>
		<div>{{$data->status}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" style="border: 1px solid black;border-radius: 6px;">
		<h4>Reason</h4>
		<div>{{$data->reason}}</div>
	</div>
	<div class="col-6" style="border: 1px solid black;border-radius: 6px;">
		<h4>Contact No</h4>
		<div>{{$data->contact_no}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" style="border: 1px solid black;border-radius: 6px;">
		<h4>Address</h4>
		<div>{{$data->address}}</div>
	</div>
	<div class="col-6" style="border: 1px solid black;border-radius: 6px;">
		<h4>Applicant's Remark</h4>
		<div>{{$data->applicant_remark}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" style="border: 1px solid black;border-radius: 6px;">
		<h4>Document</h4>
		@if($data->file_path != null)
			<td><a href="{{route('request.document', [$data->id])}}"><i class="fa fa-arrow-down"></i>Download</a></td>
		@else
			<td>Not Avalable</td>
		@endif
	</div>
</div>