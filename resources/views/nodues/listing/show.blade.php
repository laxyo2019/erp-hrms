{{-- <div class="row col-12">
	<div class="col-6 form-group">
		<span >Name :</span>
		{{ucwords($nodues['employee']->emp_name)}}
	</div>
	<div class="col-6 form-group">
		<b>Work Period :</b>
		{{$nodues->date_join}} to {{$nodues->date_leave}}
	</div>
	<div class="col-6 form-group">
		<b>Assets & Articles Description :</b>
		{{ucwords($nodues->assets_description)}}
	</div>
	<div class="col-6 form-group">
		<b>Reason of Resignation :</b>
		{{ucwords($nodues->reason_of_leaving)}}
	</div>
	<div class="col-6 form-group">
		<b>Loan Amount (In INR) :</b>
		{{ucwords($request->requested_amt)}}
	</div> 
	
</div><br> --}}


<div class="row card-body text-center">
	<div class="col-6" >
		<h5>Name </h5>
		<div>{{ucwords($nodues['employee']->emp_name)}}</div>
	</div>
	<div class="col-6" >
		<h5>Work Period </h5>
		<div>{{$nodues->date_join}} to {{$nodues->date_leave}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h5>Assets & Articles Description</h5>
		<div>{{ucwords($nodues->assets_description)}}</div>
	</div>
	<div class="col-6" >
		<h5>Reason of Resignation</h5>
		<div>{{ucwords($nodues->reason_of_leaving)}}</div>
	</div>
</div>
<h5>Hod Approval Detail</h5><hr>

<table class="table table-striped table-hover" id="RolesTable">
	<thead class="thead-dark">
		<tr class="text-center">
			<th>#</th>
	  		<th>Department Head</th>
	  		<th>Department</th>
	  		<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@php $count = 0; @endphp
		@foreach($hod as $index)
			<tr class="text-center">
				<td>{{++$count}}</td>
                <td>{{ucwords($index['employee']->emp_name)}}</td>
                <td>{{strtoupper($index['department']->name)}}</td>
                <td>Pending</td>
			</tr>
		@endforeach
	</tbody>
</table>
{{-- <div class="row card-body text-center">
	
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
	
</div> --}}