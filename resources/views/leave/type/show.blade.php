<div class="row" style="margin-top: 5px">
	<div class="col-6" style="border: 1px solid grey;">
		<h4>Leave Name</h4>
		<div>{{$leave_type->name}}</div>
	</div>
	<div class="col-6" style="border: 1px solid black;">
		<h4>Total Leaves</h4>
		<div>{{$leave_type->count}}</div>
	</div>
</div>
<div class="row" style="margin-top: 5px">
	<div class="col-6" style="border: 1px solid black;">
		<h4>Generates After</h4>
		<div >{{$leave_type->generates_in}}</div>
	</div>
	<div class="col-6" style="border: 1px solid black;">
		<h4>Can be applied min once</h4>
		<div >{{$leave_type->min_apply_once}}</div>
	</div>
</div>
<div class="row" style="margin-top: 5px">
	<div class="col-6 " style="border: 1px solid black;">
		<h4>Can be applied max once</h4>
		<div >{{$leave_type->max_apply_once}}</div>
	</div>
	<div class="col-6 " style="border: 1px solid black;">
		<h4>Max days in month</h4>
		<div >{{$leave_type->max_days_month}}</div>
	</div>
</div>
<div class="row" style="margin-top: 5px">
	<div class="col-6 " style="border: 1px solid black;">
		<h4>Can be applied max in month</h4>
		<div >{{$leave_type->max_apply_month}}</div>
	</div>
	<div class="col-6 " style="border: 1px solid black;">
		<h4>Can be applied max in year</h4>
		<div >{{$leave_type->max_apply_month}}</div>
	</div>
</div>
<div class="row" style="margin-top: 5px">
	<div class="col-6 " style="border: 1px solid black;">
		<h4>Can be carry forward</h4>
		@if($leave_type->carry_forward)
			<div>Yes</div>
		@else
			<div>No</div>
		@endif
	</div>
</div>
