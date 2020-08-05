@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div style=" padding: 1.5rem; border: 1px solid white;background: white">
		<h1 style="font-size: 24px">Generate No Dues Request
			<a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Back</a>
		</h1><hr>
		<div>
			@if($message = Session::get('success'))
              <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{$message}}
              </div>
            @endif
	    </div>
			<h5>Employee Detail</h5><hr>
			<div class="row">
				<div class="col-6 form-group">
					<label for="">Employee Name</label>
					<input type="text" class="form-control" name="emp_name" value=" {{old('emp_name' , $nodues['employee']->emp_name  )}} " readonly="">
				</div>
				<div class="col-6 form-group">
					<label for="emp_code">Employee Code</label>
					<input type="text" class="form-control" name="emp_code" value=" {{old('emp_code' , $nodues['employee']->emp_code )}} " readonly="" >
					@error('emp_code')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
				<div class="col-6 form-group">
					<label for="department">Department</label>
					<input type="text" class="form-control" name="department" value="{{$nodues['department']->name}}" readonly="" >
					@error('department')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
					<input type="hidden" name="depart_id" value="{{$nodues['department']->id}}">
				</div>
				<div class="col-6 form-group">
					<label for="department_head">Department's Head</label>
					<input type="text" class="form-control" name="department_head" value="{{-- {{old('department_head') ?? (!empty($depart_hod) ? $depart_hod->emp_name : '')}}  --}}" readonly="" >

					@error('department_head')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
					<input type="hidden" name="depart_head_id" value="{{$nodues->emp_hod}}">
				</div>
			</div>
			<div class="row">
				<div class="col-6 form-group ">
					<label for="">Date of Joinning</label>
					<input type="text" class="form-control datepicker" name="date_join" value="{{old('date_join') ?? (!empty($request) ? $request->date_join : '') }}" id="date_join" autocomplete="off">
					@error('date_join')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>	
				<div class="col-6 form-group ">
					<label for="">Date of Leaving</label>
					<input type="text" name="date_leave" class="form-control datepicker" autocomplete="off" value="{{old('date_leave') ?? (!empty($request) ? $request->date_leave : '')}}">
					@error('date_leave')
		                  <span class="text-danger" role="alert">
		                      <strong>{{ $message }}</strong>
		                  </span>
		              @enderror
				</div>
			</div>
			<div class="row">
				<div class="col-6"><h5>Article/Assets Details </h5></div>
			</div>
			@foreach($items as $index)
			<hr>
			<div id="addRow">
				<div class="row col-12">
					<div class="col-3 form-group">
						<label for="serial">Serial no.</label>
						<input type="text" class="form-control" name="serial[]" value="{{$index->serial}}" readonly="true">
					</div>
					<input type="hidden" name="item_id[]" value="{{$index->id}}">
					<div class="col-3 form-group">
						<label for="name">Name</label>
						<input type="text" name="name[]" class="form-control" value="{{$index->name}}" readonly="true">
					</div>
					<div class="col-3 form-group">
						<label for="model">Model</label>
						<input type="text" name="model[]" class="form-control" value="{{$index->model}}" readonly="true">
					</div>
					<div class="col-3 form-group">
						<label for="color">Color</label>
						<input type="text" name="color[]" class="form-control" value="{{$index->color}}" readonly="true">
					</div>
					<div class="col-3 form-group">
						<label for="given_date">Issue Date</label>
						<input type="text" name="issue_date[]" class="form-control datepicker" autocomplete="off" value="{{$index->issue_date}}" readonly="true">
					</div>
					<div class="col-3 form-group">
						<label for="quantity">Quantity</label>
						<input type="number" min="1" name="quantity[]" class="form-control"  value="{{$index->quantity}}" readonly="true">
					</div>
					<div class="col-3 form-group">
						<label for="given_date">Received Date (By Employee)</label>
						<input type="text" name="received_date[]" class="form-control datepicker " autocomplete="off" value="{{$index->received_date}}" readonly="true">
					</div>
					<div class="col-3 form-group">
						<label for="given_date">Handover Date</label>
						<input type="text" name="handover_date[]" class="form-control datepicker " autocomplete="off" required id="handover_date" value="{{$index->handover_date}}">
					</div>
					<div class="col-3 form-group">
						<label for="given_date">Handover Acceptance Date</label>
						<input type="text" name="handover_aprpoval[]" class="form-control datepicker " autocomplete="off" required id="handover_{{$index->id}}" value="{{$index->handover_approval}}">
					</div>
					<div class="col-3 form-group" style="padding-top: 25px">

						<strong id="handoverMsg_{{$index->id}}" style="color: #3375ca; font-weight: bold;display: none">HANDOVERED APPROVED</strong>

						@if($index->handover_approval == null)
							<button type="button"  data-id="{{$index->id}}" class="btn btn-primary btn-sm action" value="3" id="handBtn_{{$index->id}}">approve handover</button>
						@else
							<div style="color: #3375ca; font-weight: bold;padding-top: 15px">HANDOVERED APPROVED</div>
						@endif
					</div>
				</div>
			</div>
			@endforeach
	</div><br>
</main>

<script type="text/javascript">
	$('.datepicker').datepicker({
		orientation: "bottom",
		format: "mm-dd-yyyy",
		autoclose: true,
		todayHighlight: true
	});

	$('.action').on('click', function(){

		var itemId	 = $(this).data('id');

		var value_btn = $(this).val();

		if(value_btn == 3){

			var handover_approval = $('#handover_'+itemId).val();

			if(handover_date != ''){

				$.ajax({
					type: 'PATCH',
					url: '/issue/my-indent/'+itemId,
					headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					data: {'handover_approval': handover_approval, 'value_btn': value_btn},
					success: function(){

						$('#handBtn_'+itemId).hide();
						$('#handoverMsg_'+itemId).show()
					}
				});

			}else{

				alert('Handover date can\'t be empty.');
			}
		}
	})

</script>
<style type="text/css">
.dangerCls{
	color : red;
}

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
