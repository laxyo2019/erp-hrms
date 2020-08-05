<div class="row">
	<div class="col-6"><h4>Issued Article/Items Details</h4></div>
</div>
@foreach($history as $index)
	<hr>
	<div class="row col-12">
		<div class="col-6 form-group">
			<label for=""><b>Name : </b></label>
			{{empty($index->name)?'': strtoupper($index->name)}}
		</div>
		<div class="col-6 form-group">
			<label for=""><b>Serial : </b></label>
			{{empty($index->serial)?'': strtoupper($index->serial)}}
		</div>
		<div class="col-6 form-group">
			<label for=""><b>Model : </b></label>
			{{empty($index->model)?'': strtoupper($index->model)}}
		</div>
		<div class="col-6 form-group">
			<label for=""><b>Quantity : </b></label>
		{{ empty($index->quantity) ? '' : $index->quantity }}
		</div>
		<div class="col-6 form-group">
			<label for=""><b>Color : </b></label>
		{{ empty($index->color) ? '' : strtoupper($index->color) }}
		</div>
	</div>
	<div class="row col-12">
		<div class="col-6 form-group">
			<label for=""><b>Issue Date : </b></label>
		{{ empty($index->issue_date) ? '' : $index->issue_date }}
		</div>
		<div class="col-6 form-group">
			<label for=""><b>Received Date : </b></label>
		{{ empty($index->received_date) ? '' : $index->received_date }}
		</div>
		<div class="col-6 form-group">
			<label for=""><b>Handover Date : </b></label>
			{{ empty($index->handover_date) ? '' : $index->handover_date }}
		</div>
		<div class="col-6 form-group">
			<label for=""><b>Handover Approval Date : </b></label>
		{{ empty($index->handover_approval) ? '' : $index->handover_approval }}
		</div>
    </div>
@endforeach
<style type="text/css">
	.approve
	{
		background: #0cac0c;
		color: white;
	}
	.decline
	{
		background: #ff1414;
		color: white;
	}
	.reverse
	{
		background: #3375ca;
		color: white;
	}
	.apprv_msg{
		color: #0cac0c;
	}
	.dec_msg{
		color: #ff1414;
	}
	.rev_msg{
		color: #3375ca;
	}

</style>
