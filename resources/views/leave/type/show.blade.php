<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Leave Name</h4>
		<div>{{$leave_type->name}}</div>
	</div>
	<div class="col-6" >
		<h4>Total Leaves</h4>
		<div>{{!empty($leave_type->count) ? $leave_type->count : 'Not Available'}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Generates After</h4>
		<div>{{$leave_type->generates_after}}</div>
	</div>
	<div class="col-6" >
		<h4>Can be applied min once</h4>
		<div>{{$leave_type->min_apply_once}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Can be applied max once</h4>
		<div>{{!empty($leave_type->max_apply_once) ? $leave_type->max_apply_once : 'As Many as Available.'}}</div>
	</div>
	<div class="col-6" >
		<h4>Max days in month</h4>
		<div>{{!empty($leave_type->max_days_month) ? $leave_type->days_month : 'As Many as Available.'}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Can be applied max in month</h4>
		<div>{{!empty($leave_type->max_apply_month) ? $leave_type->max_apply_month : 'As Many as Available.'}}</div>
	</div>
	<div class="col-6" >
		<h4>Can be applied max in year</h4>
		<div>{{!empty($leave_type->max_apply_month) ? $leave_type->max_apply_month : 'As Many as Available.'}}</div>        
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Applicant's Remark</h4>
		<div>{{!empty($leave_req->applicant_remark) ? $leave_req->applicant_remark : 'Not Mentioned'}}</div>
	</div>																			
</div>



