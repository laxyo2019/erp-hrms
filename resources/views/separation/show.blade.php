@extends('layouts.master')
@section('content')
<main class="app-content">
	<div style="padding: 1.5rem; border: 1px solid white;background: white">
		<div class="row">
		<div class="col-md-12 col-xl-12">
			<h1 style="font-size: 24px">Final Settlement
			@role('hrms_hr')
				<a href="{{ route('separation-hr.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
			@endrole
			@role('hrms_subadmin')
				<a href="{{ route('separation-subadmin.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
			@endrole
			@role('hrms_admin')
				<a href="{{ route('separation-admin.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
			@endrole</h1>
		</div>
	</div>
		@if($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				{{$message}}
			</div>
		@endif
		<br>
    <div>
      <h4 style="color: grey">Employee Name - {{strtoupper($emp->emp_name)}}</h4>
      <h4 style="color: grey">Status - 
      	@if($separation->status == 0)
      		<span style="color: #0cac0c;" id="openSts">OPEN</span>
<<<<<<< HEAD
		@if($settlement->complete_form == 1)
=======
      		@if($settlement->complete_form == 1)
>>>>>>> 0f05885b5dd5bc72d02beabcf0d3236b80a896ca
      			<span style="color: #3375ca;display: none;" id="closeSts">CLOSED</span>
      			&nbsp&nbsp<button class="btn btn-info btn-sm" id="closeAccount">CLOSE THE ACCOUNT</button>
      		@endif
      	@elseif($separation->status == 1)
      		<span style="color: #3375ca;" >CLOSED</span>
      	@endif
       </h4> 
    </div>
<<<<<<< HEAD
		@if($separation->status == 0)
=======
    @if($separation->status == 0)
>>>>>>> 0f05885b5dd5bc72d02beabcf0d3236b80a896ca
		<form action="{{route('staff-settlement.update', $separation->id)}}" method="POST" id="form">
	@endif
			@csrf
			@method('PATCH')
			<div class="row">
				<div class="col-6 form-group">
					<label for="gratuity">Gratuity (In INR)</label>
					<input type="text" class="form-control" name="gratuity" 
					value="{{$settlement->gratuity}}" id="gratuity">
					@error('gratuity')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
				<div class="col-6 form-group">
					<label for="pending_salary">Net Pending Salary (In INR)</label>
					<input type="text" class="form-control" name="pending_salary" value="{{$settlement->pending_salary}}" id="pending_salary">
					@error('pending_salary')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
				<div class="col-6 form-group ">
					<label for="">Loan & Advance Recovery (In INR)</label>
					<input type="text" class="form-control" name="loan_advance_recovery" value="{{$settlement->loan_advance_recovery}}" id="loan_advance_recovery">
					@error('loan_advance_recovery')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
				<div class="col-6 form-group ">
					<label for="">Other Recovery (In INR)</label>
					<input type="text" class="form-control " name="other_recovery" value="{{$settlement->other_recovery}}" id="other_recovery">
					@error('other_recovery')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
				<div class="col-6 form-group ">
					<label for="">Pay From</label>
					<input type="text" class="form-control " name="pay_from" value="{{$settlement->pay_from}}" >
					@error('pay_from')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
				<div class="col-6 form-group ">
					<label for="">Net Settlement Amount</label>
					<input type="text" class="form-control " name="settlement_amt" value="{{$settlement->settlement_amt}}" readonly="readonly" id="settlement_amt">
					@error('settlement_amount')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
			</div>
			<div><h5>TOOL's PROVIDED BY COMPANY</h5></div><hr>
			<div class="row">
				<div class="col-6 form-group">
					<label for="name"><b>LAPTOP</b> </label>
					<div class="input-group">
						<div class="input-group-prepend mt-1">
							<div class="animated-radio-button">
				              <label>
				                <input type="radio" value="0" name="laptop" class="mt-1 mr-1" {{old('laptop', $settlement->laptop) == 0 ? 'checked' : ''}} ><span class="label-text">Handed Over </span>
				              </label>
				              <label class="ml-3">
				                <input type="radio" value="1" name="laptop" class="mt-1 mr-1 ml-3" {{old('laptop', $settlement->laptop) == 1 ? 'checked' : '' }}><span class="label-text">Not Provided</span>
				              </label>
				            </div>
						</div>
					</div>							
					@error('laptop')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                	@enderror
				</div>
				<div class="col-6 form-group">
					<label for="name"><b>SIM</b> </label>
					<div class="input-group">
						<div class="input-group-prepend mt-1">
							<div class="animated-radio-button">
				              <label>
				                <input type="radio" value="0" name="sim" class="mt-1 mr-1" {{old('sim', $settlement->sim) == 0 ? 'checked' : '' }} ><span class="label-text">Handed Over </span>
				              </label>
				              <label class="ml-3">
				                <input type="radio" value="1" name="sim" class="mt-1 mr-1 ml-3" {{old('sim', $settlement->sim) == 1 ? 'checked' : '' }}><span class="label-text">Not Provided</span>
				              </label>
				            </div>
						</div>
					</div>							
					@error('sim')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                	@enderror
				</div>
			</div>
			<div><h5>INSURANCE</h5></div><hr>
			<div class="row">
				<div class="col-6 form-group">
					<label for="name"><b>MEDICLAIM</b> </label>
					<div class="input-group">
						<div class="input-group-prepend mt-1">
							<div class="animated-radio-button">
				              <label>
				                <input type="radio" value="0" name="mediclaim" class="mt-1 mr-1" {{old('mediclaim', $settlement->mediclaim) == 0 ? 'checked' : '' }} ><span class="label-text">Canceled </span>
				              </label>
				              <label class="ml-3">
				                <input type="radio" value="1" name="mediclaim" class="mt-1 mr-1 ml-3" {{old('mediclaim', $settlement->mediclaim) == 1 ? 'checked' : '' }}><span class="label-text">Not Provided</span>
				              </label>
				            </div>
						</div>
					</div>							
					@error('mediclaim')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                	@enderror
				</div>
				<div class="col-6 form-group ">
					<label for="">OTHERS</label>
					<input type="text" class="form-control " name="others" value="{{$settlement->others}}">
					@error('others')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
			</div>
			<div><h5>DISABLE/DELETATION OF IDs PROVIDED BY COMPANY</h5></div><hr>
			<div class="row">
				<div class="col-6 form-group">
					<label for="name"><b>LAXYO &nbspEMAIL&nbsp ID</b> </label>
					<div class="input-group">
						<div class="input-group-prepend mt-1">
							<div class="animated-radio-button">
				              <label>
				                <input type="radio" value="0" name="laxyo_email" class="mt-1 mr-1" {{old('laxyo_email', $settlement->laxyo_email) == 0 ? 'checked' : '' }} ><span class="label-text">Disable/Deleted </span>
				              </label>
				              <label class="ml-3">
				                <input type="radio" value="1" name="laxyo_email" class="mt-1 mr-1 ml-3" {{old('laxyo_email', $settlement->laxyo_email) == 1 ? 'checked' : '' }}><span class="label-text">Not Provided</span>
				              </label>
				            </div>
						</div>
					</div>							
					@error('laxyo_email')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                	@enderror
				</div>
				<div class="col-6 form-group">
					<label for="name"><b>LAXYO &nbspCONNECT&nbsp ID</b> </label>
					<div class="input-group">
						<div class="input-group-prepend mt-1">
							<div class="animated-radio-button">
				              <label>
				                <input type="radio" value="0" name="laxyo_connect" class="mt-1 mr-1" {{old('laxyo_connect', $settlement->laxyo_connect) == 0 ? 'checked' : '' }} ><span class="label-text">Disable/Deleted </span>
				              </label>
				              <label class="ml-3">
				                <input type="radio" value="1" name="laxyo_connect" class="mt-1 mr-1 ml-3" {{old('laxyo_connect', $settlement->laxyo_connect) == 1 ? 'checked' : '' }}><span class="label-text">Not Provided</span>
				              </label>
				            </div>
						</div>
					</div>							
					@error('laxyo_connect')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                	@enderror
				</div>
				<div class="col-6 form-group">
					<label for="name"><b>LAXYO &nbspERP&nbsp ID</b> </label>
					<div class="input-group">
						<div class="input-group-prepend mt-1">
							<div class="animated-radio-button">
				              <label>
				                <input type="radio" value="0" name="erp_id" class="mt-1 mr-1" {{old('erp_id', $settlement->erp_id) == 0 ? 'checked' : '' }} ><span class="label-text">Disable/Deleted </span>
				              </label>
				              <label class="ml-3">
				                <input type="radio" value="1" name="erp_id" class="mt-1 mr-1 ml-3" {{old('erp_id', $settlement->erp_id) == 1 ? 'checked' : '' }}><span class="label-text">Not Provided</span>
				              </label>
				            </div>
						</div>
					</div>							
					@error('erp_id')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                	@enderror
				</div>
			</div>
			@php $display = 'style=display:none' @endphp
			<div class="col-12 form-group text-center" {{$separation->status == 1 ? $display : '' }}>
				<button class="btn btn-info btn-sm" style="width: 20%" id="update">UPDATE</button>
				<a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 20%" id="cancel">Cancel</a>
			</div>
			</div>
			<br>
<<<<<<< HEAD
		@if($separation->status == 0)
		</form>
	@endif
		
=======
			@if($separation->status == 0)
		</form>
		@endif
>>>>>>> 0f05885b5dd5bc72d02beabcf0d3236b80a896ca
	</div>
</main>

<script type="text/javascript">
	/*$('.datepicker').datepicker({
		orientation: "bottom",
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true
		});
*/
	$('#other_recovery').keyup(function(){
		var gratuity 				= parseFloat($('#gratuity').val());
		var pending_salary			= parseFloat($('#pending_salary').val());
		var loan_advance_recovery	= parseFloat($('#loan_advance_recovery').val());
		var other_recovery			= parseFloat($('#other_recovery').val());

		var total = gratuity + pending_salary + loan_advance_recovery + other_recovery;

		$('#settlement_amt').val(total);
	})

	//Close Account

	$('#closeAccount').on('click', function(){

		var separation_id = '{{$separation->id}}';

		$.ajax({
			type: 'POST',
			url: '/separation/close-account/'+separation_id,
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success:function(res){
				$('#closeAccount').hide();
				$('#openSts').hide();
				$('#closeSts').show();
				$('#update').hide();
				$('#cancel').hide();
				$('#form').content().unwrap();
<<<<<<< HEAD
=======

>>>>>>> 0f05885b5dd5bc72d02beabcf0d3236b80a896ca
			}
		})
	});

	
</script>

@endsection
