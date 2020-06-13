@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div style=" padding: 1.5rem; border: 1px solid white;background: white">
		<h1 style="font-size: 24px">Create Welfare
			<a href="{{ route('welfare.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Back</a><hr>
		</h1>
		@if($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				{{$message}}
			</div>
		@endif 
		<form action="{{route('welfare.store')}}" method="POST" >
			@csrf
			<div class="row">
				<div class="col-6 form-group ">
					<label for="code">Code for welfare</label>
					<input type="text" class="form-control" name="code" value="" id="code">
					@error('code')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
				<div class="col-6 form-group ">
					<label for="description">Description</label>
					<input type="text" class="form-control" name="description" value="" id="description">
					@error('description')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
				<div class="col-6 form-group ">
					<label for="">Ledger</label>
					<select name="ledger" class="custom-select form-control select2">
						<option value="">Select Type</option>
							@foreach($ledgers as $index)
								<option value="{{$index->id}}">{{ucwords($index->name)}}</option>
							@endforeach
					</select>
					@error('ledger')
		                  <span class="text-danger" role="alert">
		                      <strong>{{ $message }}</strong>
		                  </span>
		              @enderror
				</div>
				<div class="col-6 form-group ">
					<label for="cal_procedure">Calculation Procedure</label>
					<input type="text" class="form-control" name="cal_procedure" value="" id="cal_procedure">
					@error('cal_procedure')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>	
				<div class="col-6 form-group ">
					<label for="print_order">Print Order</label>
					<input type="text" class="form-control " name="print_order" value="{{old('order')}}" id="print_order" >
					@error('print_order')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
			</div>
			<div><h5>Other Details</h5></div><hr>
			<div class="row">
				<div class="col-4 form-group">
					<label for="type"><b>Type</b></label>
					<div class="input-group">
						<div class="input-group-prepend mt-1">
							<div class="animated-radio-button">
				              <label>
				                <input type="radio" value="1" name="type" class="mt-1 mr-1" {{old('type')}} ><span class="label-text">Earning</span>
				              </label>
				              <label class="ml-3">
				                <input type="radio" value="2" name="type" class="mt-1 mr-1 ml-3" {{old('type')}}><span class="label-text">Deduction</span>
				              </label>
				            </div>
						</div>
					</div>							
					@error('type')
	                    <span class="text-danger" role="alert">
	                        <strong>{{ $message }}</strong>
	                    </span>
                	@enderror
				</div>
			</div>
			<div class="row">
				<div class="col-3 form-group">
					<label for="name"><b>Active</b></label>
					<div class="input-group">
						<div class="input-group-prepend mt-1">
							<div class="animated-radio-button">
				              <label>
				                <input type="radio" value="1" name="active" class="mt-1 mr-1" {{old('active')}} ><span class="label-text">True</span>
				              </label>
				              <label class="ml-3">
				                <input type="radio" value="0" name="active" class="mt-1 mr-1 ml-3" {{old('active')}}><span class="label-text">False</span>
				              </label>
				            </div>
						</div>
					</div>							
					@error('active')
	                    <span class="text-danger" role="alert">
	                        <strong>{{ $message }}</strong>
	                    </span>
                	@enderror
				</div>
				<div class="col-3 form-group">
					<label for="name"><b>Prorated</b></label>
					<div class="input-group">
						<div class="input-group-prepend mt-1">
							<div class="animated-radio-button">
				              <label>
				                <input type="radio" value="1" name="prorated" class="mt-1 mr-1" {{old('prorated')}} ><span class="label-text">True</span>
				              </label>
				              <label class="ml-3">
				                <input type="radio" value="0" name="prorated" class="mt-1 mr-1 ml-3" {{old('prorated')}}><span class="label-text">False</span>
				              </label>
				            </div>
						</div>
					</div>							
					@error('prorated')
	                    <span class="text-danger" role="alert">
	                        <strong>{{ $message }}</strong>
	                    </span>
                	@enderror
				</div>
				{{-- <div class="col-3 form-group">
					<label for="deduction"><b>Deduction</b></label>
					<div class="input-group">
						<div class="input-group-prepend mt-1">
							<div class="animated-radio-button">
				              <label>
				                <input type="radio" value="1" name="deduction" class="mt-1 mr-1" {{old('deduction')}} ><span class="label-text">Yes</span>
				              </label>
				              <label class="ml-3">
				                <input type="radio" value="0" name="deduction" class="mt-1 mr-1 ml-3" {{old('deduction')}}><span class="label-text">No</span>
				              </label>
				            </div>
						</div>
					</div>							
					@error('deduction')
	                    <span class="text-danger" role="alert">
	                        <strong>{{ $message }}</strong>
	                    </span>
                	@enderror
				</div> --}}
			</div>
			<div class="row">
				
				<div class="col-3 form-group">
					<label for="employer_contri"><b>Employer Contribution</b></label>
					<div class="input-group">
						<div class="input-group-prepend mt-1">
							<div class="animated-radio-button">
				              <label>
				                <input type="radio" value="1" name="employer_contri" class="mt-1 mr-1" {{old('employer_contri')}} ><span class="label-text">True</span>
				              </label>
				              <label class="ml-3">
				                <input type="radio" value="0" name="employer_contri" class="mt-1 mr-1 ml-3" {{old('employer_contri')}}><span class="label-text">False</span>
				              </label>
				            </div>
						</div>
					</div>							
					@error('employer_contri')
	                    <span class="text-danger" role="alert">
	                        <strong>{{ $message }}</strong>
	                    </span>
                	@enderror
				</div>
				<div class="col-3 form-group">
					<label for="display_payslip"><b>Display In Payslip</b></label>
					<div class="input-group">
						<div class="input-group-prepend mt-1">
							<div class="animated-radio-button">
				              <label>
				                <input type="radio" value="1" name="display_payslip" class="mt-1 mr-1" {{old('display_payslip')}} ><span class="label-text">True</span>
				              </label>
				              <label class="ml-3">
				                <input type="radio" value="0" name="display_payslip" class="mt-1 mr-1 ml-3" {{old('display_payslip')}}><span class="label-text">False</span>
				              </label>
				            </div>
						</div>
					</div>							
					@error('display_payslip')
	                    <span class="text-danger" role="alert">
	                        <strong>{{ $message }}</strong>
	                    </span>
                	@enderror
				</div>
			</div>
			<div class="row">
				
			</div>
				

				<div class="col-12 form-group text-center">
					<button class="btn btn-info btn-sm" style="width: 20%">SAVE</button>
					<a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 20%">CANCEL</a>
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

	
</script>

@endsection
