<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Candidate  Name</h4>
		<div>{{ucwords($candidate->candidate_name)}}</div>
	</div>
	<div class="col-6" >
		<h4>Candidate Email</h4>
		<div>{{ucwords($candidate->email)}}</div>
	</div>
	
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Candidate's Contact</h4>
		<div>{{ucwords($candidate->contact)}}</div>
	</div>
	<div class="col-6" >
		<h4>Alternate No. </h4>
		<div>{{ucwords($candidate->alt_contact)}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h4>Education Level</h4>
		<div>{{ucwords($candidate['education']->name)}}</div>
	</div>
	
	<div class="col-6" >
		<h4>Candidate's CV</h4>
		<div></div>
	</div>
</div>
<hr>
<div class="row card-body text-center">
	<div class="col-4" >
		<h4>Details</h4>
	</div>
	<div class="col-8" width="10px" >
		<p>{{$candidate->candidate_details}}</p>
	</div>
	
	
</div>