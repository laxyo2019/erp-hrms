@extends('layouts.master')
@section('content')
<main class="app-content">
	<div style="margin-top: 1.5rem; padding: 1.5rem;" class="tile">
		<h1 style="font-size: 24px">Loan History
			<a href="{{URL::previous() }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
              </h1>
		@if($message = Session::get('success'))
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>
			{{$message}}
		</div>
		@elseif($message = Session::get('failed'))
		<div class="alert alert-danger alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>
			{{$message}}
		</div>
		@endif
		<br>
		<div class="row col-12">
        	<div class="col-6 form-group">
				<b>Name : </b>
				{{ucwords($request['employee']->emp_name)}}
			</div>
			<div class="col-6 form-group">
				<b>Account No. : </b>
				{{ucwords($request->account_no)}}
			</div>
			<div class="col-6 form-group">
				<b>Request Status : </b>
				{{ucwords($request->tenure)}}
			</div>
			<div class="col-6 form-group">
				<b>Loan Type : </b>
				{{ucwords($request['loanType']->name)}}
			</div>
			<div class="col-6 form-group">
				<b>Loan Amount (In INR): </b>
				{{ucwords($request->requested_amt)}}
			</div> 
			<div class="col-6 form-group">
				<b>Interest Rate : </b>
				{{ucwords($request->interest_rate)}}%
			</div>
			<div class="col-6 form-group">
				<b>Tenure (In Month) : </b>
				{{ucwords($request->tenure)}}
			</div>
			<div class="col-6 form-group">
				<b>Sanctioned date: </b>
				{{ucwords($request->sanctioned_date)}}
			</div>
			<div class="col-6 form-group">
				<b>Disburse Date : </b>
				{{ucwords($request->disburse_date)}}
			</div>
			<div class="col-6 form-group">
				<b>Disburse Amount (In INR) : </b>
				{{ucwords($request->disburse_amt)}}
			</div>
			<div class="col-6 form-group">
				<b>Monthly Deduction (In INR) : </b>
				{{ucwords($request->monthly_deduction)}}
			</div>
			<div class="col-6 form-group">
				<b>Total Interest (In INR) : </b>
				{{ucwords($request->total_interest)}}
			</div>
		</div><br>
		@ability('hrms_admin|hrms_hr', 'Hrms-manage-loan-request')
		<h5>Add Deduction Detail</h5><br>
		<form action="{{route('history.update', $request->id)}}" method="POST">
			@csrf
			@method('PUT')
		
			<div class="row">
				<div class="col-6 form-group">
					<label for="">Balance (In INR)</label>
					<input type="text" class="form-control" name="balance" value="{{old('balance')}}">
					@error('balance')
	          		<span class="text-danger" role="alert">
	            		<strong>* {{ $message }}</strong>
	          		</span>
	      			@enderror
				</div>
			</div>
			<div class="row">
				<div class="col-6 form-group">
					<label for="">Monthly Deduction (In INR)</label>
					<input type="text" class="form-control contact" name="deduction" value="{{ old('deduction')}}">
					@error('deduction')
	          		<span class="text-danger" role="alert">
	            		<strong>* {{ $message }}</strong>
	          		</span>
	      			@enderror
				</div>
				
			</div>
			<div class="row">
			<div class="col-6 form-group text-center">
					<button class="btn btn-info btn-sm" style="width: 15">Save</button>
					<a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 15">Cancel</a>
				</div>
			</div>
		</form>
		@endability
			<h5>Deduction Detail</h5><br>
		<hr>
		{{-- @endif --}}
		<table class="table table-striped table-hover table-bordered" id="CandidatesTable">
				<thead class="thead-dark">
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Balance</th>
						<th class="text-center">Monethly Deduction</th>
						@ability('hrms_admin', 'Hrms-manage-loan-request')
							<th class="text-center">Actions</th>
						@endability
					</tr>
				</thead>
				@php $count = 0; @endphp
				<tbody id="experiencesTbody">
				@foreach($history as $index)
					<tr class="text-center">
						<td>{{++$count}}</td>
						<td>{{$index->balance}}</td>
						<td>{{$index->deduction}}</td>
						@ability('hrms_admin', 'Hrms-manage-loan-request')
						<td>
							<span class="text-center">
								<form action="{{route('history.destroy', $index->id)}}" method="POST" id="delform_{{ $index->id}}">
										@csrf
										@method('DELETE')
									<a href="javascript:$('#delform_{{$index->id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash text-white"  style="font-size: 12px;"></i></a>
								</form>
							</span>
							
						</td>
						@endability
					</tr>
				@endforeach
				</tbody>
		</table>
	</div>
</main>
<script>
$(document).ready(function(){

	$('#CandidatesTable').dataTable( {
		"ordering":   true,
		order : [[1, 'asc']],
		"columnDefs": [ 
		  { "orderable": false, "targets": 0,  }
		]
	});

});
</script>
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
@endsection
