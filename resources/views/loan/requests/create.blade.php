@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	
	<div style=" padding: 1.5rem; border: 1px solid white;background: white">
		{{-- <div class="col-md-12 col-xl-12"> --}}
			<h1 style="font-size: 24px">Apply for Loan
				<a href="{{ route('loan-request.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
		</h1>
		{{-- </div> --}}
		@if($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				{{$message}}
			</div>
		@endif 
		
		<form action="{{route('loan-request.store')}}" method="POST" >
			@csrf
			<h5>Employee Detail</h5><hr>
			<div class="row">
				<div class="col-6 form-group">
					<label for="">Employee Name</label>
					<input type="text" class="form-control" name="emp_name" value="{{old('emp_name', $emp->emp_name)}}" readonly="">
					
				</div>
				<div class="col-6 form-group">
					<label for="emp_code">Employee Code</label>
					<input type="text" class="form-control" name="emp_code" value="{{old('emp_code', $emp->emp_code)}}" readonly="">
					@error('emp_code')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
			</div>
			<h5>Loan Application Detail</h5><hr>
			<div class="row">
				<div class="col-6 form-group ">
					<label for="">Interest Rate ( % )</label>
					<input type="text" class="form-control" name="interest_rate" value="{{$interest->description}}" readonly="" id="interest_rate">
					@error('interest_rate')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>	
				<div class="col-6 form-group ">
					<label for="">Loan Types</label>
					<select name="loan_type" class="custom-select form-control select2">
						<option value="">Select Type</option>
							@foreach($types as $type)
								<option value="{{$type->id}}">{{ucwords($type->name)}}</option>
							@endforeach
					</select>
					@error('loan_type')
		                  <span class="text-danger" role="alert">
		                      <strong>{{ $message }}</strong>
		                  </span>
		              @enderror
				</div>
				<div class="col-6 form-group">
					<label for="">Loan Amount (In INR)</label>
					<input type="text" class="form-control" name="loan_amount" value="{{old('loan_amount')}}" id="loan_amount">
					@error('loan_amount')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
				<div class="col-6 form-group">
					<label for="monthly_deduction">Monthly Deduction (In INR)</label>
					<input type="text" class="form-control" name="monthly_deduction" value="{{old('monthly_deduction')}}" readonly="" id="monthly_deduction" >
					@error('monthly_deduction')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>			
				<div class="col-6 form-group ">
					<label for="">Tenure ( Months )</label>
					<input type="number" class="form-control " name="tenure" value="{{old('tenure')}}" id="tenure" min="1">
					@error('tenure')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
				<div class="col-6 form-group ">
					<label for="">Total Interest (In INR)</label>
					<input type="text" class="form-control " name="total_interest" value="{{old('total_interest')}}" id="total_interest" min="1" readonly="" id="total_interest">
					@error('total_interest')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
				
				
				
				
			</div>
			<div class="row">
				<div class="col-12 form-group">
					<label for="reason">Reason 
						@error('reason')
				          	<span style="color: red">
								| {{ $message }}
							</span>
				      	@enderror</label>
					<textarea  class="form-control" id="reason" name="reason" >{{old('reason')}}</textarea>
				</div>
				
				<div class="col-12 form-group text-center">
					<button class="btn btn-info btn-sm" style="width: 20%">SAVE</button>
					{{-- <a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 30%">Cancel</a> --}}
				</div>
			</div>
				
			</div>
			<br>
			
		</form>
	</div>
</main>

<script type="text/javascript">
	$('.datepicker').datepicker({
		orientation: "bottom",
		format: "mm-dd-yyyy",
		autoclose: true,
		todayHighlight: true
	});

	$('#tenure').on('change', function(){

		var interest 	= parseFloat($('#interest_rate').val());
		var loan_amount = parseFloat($('#loan_amount').val());
		var tenure 		= parseFloat($('#tenure').val());

		//var total_amount = loan_amount/100*interest + loan_amount;
		var total_interest = loan_amount/100*interest * tenure;

		var total_amount = total_interest + loan_amount;

		var monthly_deduction = total_amount / tenure;

		//$('#monthly_deduction').val(monthly.toFixed(2));
		$('#monthly_deduction').val(monthly_deduction.toFixed(2));
		$('#total_interest').val(total_interest.toFixed(2));
	});

	/*$('#loan_amount').on('change', function(){

		var interest 	= parseFloat($('#interest_rate').val());
		var loan_amount	= parseFloat($('#loan_amount').val());

		var total_interest = loan_amount/100*interest;
		
		$('#total_interest').val(total_interest.toFixed(2));
	})*/
</script>

@endsection
