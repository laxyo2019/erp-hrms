<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Job Title</h4>
		<div>{{ ucwords($request->job_title) }}</div>
	</div>
	<div class="col-6" >
		<h4>Company</h4>
		<div>{{ucwords($request['company']->name)}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>City</h4>
		<div>{{ucwords($request->city)}}</div>
	</div>
	<div class="col-6" >
		<h4>Department</h4>
		<div>{{ucwords($request['department']->name)}}</div>
	</div>
	
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Employement Type</h4>
		<div>{{ucwords($request['employement']->name)}}</div>
	</div>
	<div class="col-6" >
		<h4>Education Level</h4>
		<div>{{ucwords($request['education']->name)}}</div>
	</div>
	
</div>
<div class="row card-body text-center">
	
	<div class="col-6">
		<h4>Experience Level</h4>
		<div>{{ucwords($request['experience']->name)}}</div>
	</div>
	
</div>
<div class="row card-body text-center">
	<div class="col-12" >
		<h4>Job Requirement</h4>
		<div>{{$request->requirements}}</div>
	</div>
	
</div>