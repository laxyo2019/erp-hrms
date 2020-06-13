<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Code</h4>
		<div>{{ucwords($welfare->code)}}</div>
	</div>
	<div class="col-6" >
		<h4>Description</h4>
		<div>{{$welfare->description}}</div>
	<div>
		
</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Type</h4>
		<div>{{$welfare->prorated}}</div>
	</div>
	<div class="col-6" >
		<h4>Active</h4>
		<div>{{$welfare->active}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Prorated</h4>
		<div>{{$welfare->prorated}}&nbspRs</div>
	</div>
	<div class="col-6" >
		<h4>Ledger</h4>
		<div>{{$welfare['ledger']->name}} &nbspRs.</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6">
		<h4>Employer Contribution</h4>
	</div>
	<div class="col-6" >
		
		<div>{{$welfare->emp_contribution}}</div>
	</div>
</div>
{{-- <div class="row card-body text-center">
	
	<div class="col-6" >
		<h4>Disburse Date</h4>
		<div>{{$request->disburse_date}}</div>
	</div>
	<div class="col-6" >
		<h4>Disburse Amount</h4>
		<div>{{$request->disburse_amt}}</div>
	</div>
</div> --}}

