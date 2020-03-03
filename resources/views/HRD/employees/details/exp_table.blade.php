<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Last company name</h4>
		<div>{{$exp->comp_name}}</div>
	</div>
	<div class="col-6" >
		<h4>Job Type</h4>
		<div>{{$exp->job_type}}</div>
	</div>
</div>
<div class="row card-body text-center">
	
	<div class="col-6" >
		<h4>Designation</h4>
		<div>{{$exp->desg}}</div>
	</div>
	<div class="col-6" >
		<h4>Monthly CTC</h4>
		<div>{{$exp->monthly_ctc}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Company Location</h4>
		<div>{{$exp->comp_loc}}</div>
	</div>
	{{-- @can('download documents') --}}
	<div class="col-6" >
		<h4>Certificate</h4>
		<div>
			<td>
				@if($exp->file_path != null)
				<a href="{{route('employees.download', ['db_table' => 'hrms_emp_exp', $exp->id])}}"><i class="fa fa-arrow-down"></i>Download</a>
				@else
					Not Available
				@endif
			</td>
		</div>
	</div>
	{{-- @endcan --}}
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Company Email</h4>
		<div>{{$exp->comp_email}}</div>
	</div>
	<div class="col-6" >
		<h4>Company Website</h4>
		<div>{{$exp->comp_website}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Job Period Date</h4>
		<div> <b>From - </b>{{date('M d, Y', strtotime($exp->start_dt))}} <b>To - </b> {{date('M d, Y', strtotime($exp->end_dt))}}</div>
	</div>
	<div class="col-6" >
		<h4>Reason of Leaving</h4>
		<div>{{$exp->reason_of_leaving}}</div>
	</div>
</div>