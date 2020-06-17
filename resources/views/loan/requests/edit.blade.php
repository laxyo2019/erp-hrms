@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	
	<div style=" padding: 1.5rem; border: 1px solid white;background: white">
			<h1 style="font-size: 24px">Edit Loan Request
				<a href="{{ route('loan-request.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
		</h1>
		@if($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				{{$message}}
			</div>
		@endif
		<div>
	    </div>
		@if($request->hr_approval == 0 )
		<form action="{{route('loan-request.update', $request->id)}}" method="POST" >
			@csrf
			@method('PATCH')
		@endif
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
					<input type="text" class="form-control" name="interest_rate" value="{{$request->interest_rate}}" readonly="" id="interest_rate">
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
								<option value="{{$type->id}}" {{old('loan_type', $request->loan_type_id) == $type->id ? 'selected' : ''}}>{{ucwords($type->name)}}</option>
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
					<input type="text" class="form-control" name="loan_amount" value="{{$request->requested_amt}}" id="loan_amount">
					@error('loan_amount')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
				<div class="col-6 form-group">
					<label for="monthly_deduction">Monthly Deduction (In INR)</label>
					<input type="text" class="form-control" name="monthly_deduction" value="{{$request->monthly_deduction}}" readonly="" id="monthly_deduction" >
					@error('monthly_deduction')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>			
				<div class="col-6 form-group ">
					<label for="">Tenure ( Months )</label>
					<input type="number" class="form-control " name="tenure" value="{{$request->tenure}}" id="tenure" min="1">
					@error('tenure')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
				<div class="col-6 form-group ">
					<label for="">Total Interest (In INR)</label>
					<input type="text" class="form-control " name="total_interest" value="{{$request->total_interest}}" id="total_interest" min="1" readonly="" id="total_interest">
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
					<textarea  class="form-control" id="reason" name="reason" >{{$request->reason}}</textarea>
				</div>
			
			{{-- <h5>Account Detail</h5><hr>
			<div class="row">
				<div class="col-6 form-group ">
					<label for="">Account Holder Name</label>
					<input type="text" class="form-control " name="total_interest" value="{{old('total_interest')}}" id="total_interest" min="1"  id="total_interest">
					@error('total_interest')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
				<div class="col-6 form-group ">
					<label for="">IFSC Code</label>
					<input type="text" class="form-control " name="total_interest" value="{{old('total_interest')}}" id="total_interest" min="1"  id="total_interest">
					@error('total_interest')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
				<div class="col-6 form-group ">
					<label for="">Account No.</label>
					<input type="text" class="form-control " name="total_interest" value="{{old('total_interest')}}" id="total_interest" min="1"  id="total_interest">
					@error('total_interest')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
			</div> --}}
			@if($request->hr_approval == 0 )	
				<div class="col-12 form-group text-center">
					<button class="btn btn-info btn-sm" style="width: 20%">SAVE</button>
					{{-- <a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 30%">Cancel</a> --}}
				</div>
			@endif
			</div>		
			</div>
			<br>
		@if($request->hr_approval != 0 )
			</form>
		@endif
	</div>
</main>

<script type="text/javascript">
	$('.datepicker').datepicker({
		orientation: "bottom",
		format: "mm-dd-yyyy",
		autoclose: true,
		todayHighlight: true
	});

	//Monthly Deduction Formula or EMI
	$('#tenure').on('change', function(){

		var interest 	= parseFloat($('#interest_rate').val());
		var loan_amount = parseFloat($('#loan_amount').val());
		var tenure 		= parseFloat($('#tenure').val());

		var total_amount = loan_amount/100*interest + loan_amount;

		var monthly = total_amount/tenure;

		$('#monthly_deduction').val(monthly.toFixed(2));
	});

	$('#loan_amount').on('change', function(){

		var interest 	= parseFloat($('#interest_rate').val());
		var loan_amount	= parseFloat($('#loan_amount').val());

		var total_interest = loan_amount/100*interest;
		
		$('#total_interest').val(total_interest.toFixed(2));
	})
</script>

@endsection
