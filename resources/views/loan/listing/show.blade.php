<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Loan Type</h4>
		<div>{{ucwords($request['loanType']->name)}}</div>
	</div>
	<div class="col-6" >
		<h4>Requested Date</h4>
		<div>{{$request->posted}}</div>
	<div>
		
</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Interest Rate (%)</h4>
		<div>{{$request->interest_rate}}</div>
	</div>
	<div class="col-6" >
		<h4>Tenure (In Months)</h4>
		<div>{{$request->tenure}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Loan Amount</h4>
		<div>{{$request->requested_amt}}&nbspRs</div>
	</div>
	<div class="col-6" >
		<h4>Monthly Deduction</h4>
		<div>{{$request->monthly_deduction}} &nbspRs.</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6">
		<h4>Reason</h4>
	</div>
	<div class="col-6" >
		
		<div>{{$request->reason}}</div>
	</div>
</div>
<div class="row card-body text-center">
	
	<div class="col-6" >
		<h4>Disburse Date</h4>
		<div>{{$request->disburse_date}}</div>
	</div>
	<div class="col-6" >
		<h4>Disburse Amount</h4>
		<div>{{$request->disburse_amt}}</div>
	</div>
</div>

