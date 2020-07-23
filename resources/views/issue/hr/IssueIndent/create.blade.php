@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div style=" padding: 1.5rem; border: 1px solid white;background: white">
		<h1 style="font-size: 24px">Generate Issue Indent
			<a href="{{ route('issue-indent.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Back</a>
		</h1><hr>
		<div>
			@if($message = Session::get('success'))
              <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{$message}}
              </div>
            @endif
	    </div>
		<form action="{{route('issue-indent.store')}}" method="POST" >
			@csrf
			<h5>Employee Detail</h5><br>
			<div class="row col-12">
				<div class="col-6 form-group">
					<label for="">Employee Name</label>
					<select name="employees" class="form-control" id="select2">
						<option value=""></option>
						@foreach($employees as $index)
							<option data-id="{{$index->dept_id == null ? '' : $index->dept_id }}" value="{{$index->user_id}}">{{strtoupper($index->emp_code)}} : {{strtoupper($index->emp_name)}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-6 form-group">
					<label for="emp_code">Employee Code</label>
					<input type="text" class="form-control" name="emp_code" id="emp_code" value="{{old('emp_code')}}" readonly="" >
					@error('emp_code')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
			</div>
			<div class="row">
				<div class="col-6"><h5>Item Detail </h5></div>
				<div class="col-6">
					<button class="btn-sm btn-primary rounded-sm" style="font-size:18px;float: right;" id="addMore" title="Add More Person"><i class="fa fa-plus"></i></button>
				</div>
			</div>
			{{-- <div> Item - 1</div> --}}
			<hr>
			<div id="addRow">
			<div class="row col-12">
				<div class="col-3 form-group">
					<label for="serial">Serial no.</label>
					<input type="text" class="form-control" name="serial[]" id="emp_code" value="{{old('emp_code')}}" >
				</div>
				<div class="col-3 form-group">
					<label for="name">Name</label>
					<input type="text" name="name[]" class="form-control" >
				</div>
				<div class="col-3 form-group">
					<label for="model">Model</label>
					<input type="text" name="model[]" class="form-control">
				</div>
				<div class="col-3 form-group">
					<label for="color">Color</label>
					<input type="text" name="color[]" class="form-control">
				</div>
				<div class="col-3 form-group">
					<label for="given_date">Issue Date</label>
					<input type="text" name="given_date[]" class="form-control datepicker" autocomplete="off">
				</div>
				<div class="col-3 form-group">
					<label for="quantity">Quantity</label>
					<input type="number" min="1" name="quantity[]" class="form-control">
				</div>
				{{-- <div class="col-3 form-group">
					<label for="received_date">Received Date</label>
					<input type="text" name="received_date[]" class="form-control">
				</div> --}}
			</div>
			</div>
			<div class="col-12 form-group text-center">
				<button class="btn btn-info btn-sm" style="width: 20%">SAVE</button>
			</div>
		</form>
	</div><br>
</main>
<style type="text/css">
.select2 {
	width:100%!important;
}
</style>

<script type="text/javascript">

$('.datepicker').datepicker({
		orientation: "bottom",
		format: "mm-dd-yyyy",
		autoclose: true,
		todayHighlight: true
	});
$(document).ready(function(){

	

	$('#select2').select2({
		placeholder: "Select employees",
    	allowClear : true,

	});

	$('#select2').on('change', function(){
		
		var user_id = $(this).val();
		var name 	= $("#select2 option:selected").text();
		var code = name.split(' ');

		$('#emp_code').val(code[0]);
	});
	
	//Add row in table 

	var i = 2;

	$('#addMore').on('click', function(e){
		e.preventDefault();
		var html = '<div id="row'+i+'"><hr><div class="row col-12"><div class="col-3 form-group"><label for="emp_code">Serial no.</label><input type="text" class="form-control" name="serial[]" ></div><div class="col-3 form-group"><label for="emp_code">Name</label><input type="text" name="name[]" class="form-control"></div><div class="col-3 form-group"><label for="emp_code">Model</label><input type="text" name="model[]" class="form-control"></div><div class="col-3 form-group">		<label for="emp_code">Color</label><input type="text" name="color[]" class="form-control"></div><div class="col-3 form-group"><label for="emp_code">Issue Date</label><input type="text" name="given_date[]" class="form-control datepicker"></div><div class="col-3 form-group"><label for="emp_code">Quantity</label><input type="number" min="1" name="quantity[]" class="form-control"></div><div class="col-3 form-group" align="center" style="padding-top: 10px;width="50px"><div><label for="emp_code"></label></div><button class="btn-danger btn-sm btn_remove" id="'+i+'"><span class="fa fa-lg fa-times"></span></button></div></div></div>';

			$('#addRow').append(html)

		i++;
	})

	$(document).on('click', '.btn_remove', function(){
		var button_id = $(this).attr("id");
		$('#row'+button_id+'').remove();
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
