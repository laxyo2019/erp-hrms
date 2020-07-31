@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div style=" padding: 1.5rem; border: 1px solid white;background: white">
		<h1 style="font-size: 24px">Edit Issue Indent
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
		<form action="{{route('issue-indent.update', $employee->user_id)}}" method="POST" >
			@method('PUT')
			@csrf
			<h5>Employee Detail</h5><br>
			<div class="row col-12">
				<div class="col-6 form-group">
					<label for="">Employee Name</label>
					<select name="employees" class="form-control" id="select2">
						<option value=""></option>
						@foreach($employees as $index)
							<option data-id="{{$index->dept_id == null ? '' : $index->dept_id }}" value="{{$index->user_id}}" {{($employee->user_id == $index->user_id) ? 'selected' : ''}}>{{strtoupper($index->emp_code)}} : {{strtoupper($index->emp_name)}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-6 form-group">
					<label for="emp_code">Employee Code</label>
					<input type="text" class="form-control" name="emp_code" id="emp_code" value="{{$employee->emp_code}}" readonly="" >
					@error('emp_code')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
			</div>
			<div class="row" id="addRow">
			</div>
			<div class="col-12 form-group text-center">
				<button class="btn btn-info btn-sm" style="width: 20%">SAVE</button>
			</div>
		</form>

		{{-- <div class="col-3 form-group"><label for="name">Name</label><input type="text" name="name[]" {{$issued[0]['user_action'] == 1 ? 'disabled="true"' : ''}} class="form-control" value="{{$issued[0]['name']}}"></div> --}}
	</div><br>
</main>
<style type="text/css">
.select2 {
	width:100%!important;
}
</style>

<script type="text/javascript">

// $(document).ready(function() {

$('.datepicker').datepicker({
		orientation: "bottom",
		format: "mm-dd-yyyy",
		autoclose: true,
		todayHighlight: true
	});
// });

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
	var i = 0;
	@php
		$i = 0; 
		$count_issued = count($issued);
		
	@endphp

	var html = '<div id="row'+i+'"><br><div class="row col-12"><div class="col-6"><h4>Article/Assets Details </h4></div><div class="col-6"><button class="btn-sm btn-primary rounded-sm" style="font-size:18px;float: right;" id="addMore" title="Add More Person"><i class="fa fa-plus"></i></button></div><br>';
	
	html += '<div class="row col-12"><div class="col-3 form-group"><label for="serial">Serial no.</label><input type="text" class="form-control" name="serial[]" value="{{$issued[0]['serial']}}" {{$issued[0]['user_action'] == 1 ? 'disabled="true"' : ''}}></div>';

	html += '<div class="col-3 form-group"><label for="name">Name</label><input type="text" name="name[]" class="form-control" value="{{$issued[0]['name']}}" {{$issued[0]['user_action'] == 1 ? 'disabled="true"' : ''}}></div>';

	html += '<div class="col-3 form-group"><label for="model">Model</label><input type="text" name="model[]" class="form-control" value="{{$issued[0]['model']}}" {{$issued[0]['user_action'] == 1 ? 'disabled="true"' : ''}}></div>';

	html += '<div class="col-3 form-group"><label for="color">Color</label><input type="text" name="color[]" class="form-control" value="{{$issued[0]['color']}}" {{$issued[0]['user_action'] == 1 ? 'disabled="true"' : ''}}></div>';

	html += '<div class="col-3 form-group"><label for="issued">Issue Date</label><input type="text" name="given_date[]" class="form-control datepicker" value="{{$issued[0]['issue_date']}}" {{$issued[0]['user_action'] == 1 ? 'disabled="true"' : ''}}></div>';

	html += '<div class="col-3 form-group"><label for="quantity">Quantity</label><input type="number" min="1" name="quantity[]" class="form-control" value="{{$issued[0]['quantity']}}" {{$issued[0]['user_action'] == 1 ? 'disabled="true"' : ''}}></div>';

	html += '<div class="col-3 form-group"><label for="received_date">Received Date</label><input type="text" name="received_date[]" disabled="true" class="form-control" value="{{$issued[0]['received_date']}}" {{$issued[0]['user_action'] == 1 ? 'disabled="true"' : ''}}></div>';

	html += '<div class="col-3 form-group" style="text-align:center;padding-top: 40px;">';

	html += @if($issued[$i]['user_action'] == 1)'<strong style="color: #0cac0c; font-weight: bold;">RECEIVED</strong>'@elseif($issued[$i]['user_action'] == 0)''@endif;

	html += '</div></div></div></div><input type="hidden" name="user_action[]" value="{{$issued[0]['user_action']}}" {{$issued[0]['user_action'] == 1 ? 'disabled="true"' : ''}}>';

		$('#addRow').append(html)

	i++;
	@php
	$i++;
		while($i < $count_issued){ 
	@endphp
	var html = '<div id="row'+i+'"><hr><div class="row col-12"><div class="col-3 form-group"><label for="serial">Serial no.</label><input type="text" class="form-control" name="serial[]" value="{{$issued[$i]['serial']}}" {{$issued[$i]['user_action'] == 1 ? 'disabled="true"' : ''}}></div>';

		html +=	'<div class="col-3 form-group"><label for="name">Name</label><input type="text" name="name[]" class="form-control" value="{{$issued[$i]['name']}}" {{$issued[$i]['user_action'] == 1 ? 'disabled="true"' : ''}}></div>';

		html += '<div class="col-3 form-group"><label for="model">Model</label><input type="text" name="model[]" class="form-control" value="{{$issued[$i]['model']}}" {{$issued[$i]['user_action'] == 1 ? 'disabled="true"' : ''}}></div>';

		html += '<div class="col-3 form-group"><label for="color">Color</label><input type="text" name="color[]" class="form-control" value="{{$issued[$i]['color']}}" {{$issued[$i]['user_action'] == 1 ? 'disabled="true"' : ''}}></div>';

		html += '<div class="col-3 form-group"><label for="given_date">Issue Date</label><input type="text" name="given_date[]" class="form-control datepicker" value="{{$issued[$i]['issue_date']}}" {{$issued[$i]['user_action'] == 1 ? 'disabled="true"' : ''}}></div>';

		html += '<div class="col-3 form-group"><label for="quantity">Quantity</label><input type="number" min="1" name="quantity[]"  class="form-control" value="{{$issued[$i]['quantity']}}" {{$issued[$i]['user_action'] == 1 ? 'disabled="true"' : ''}}></div>';

		html += '<div class="col-3 form-group"><label for="received_date">Received Date</label><input type="text" name="received_date[]" disabled="true" class="form-control" value="{{$issued[$i]['received_date']}}" {{$issued[$i]['user_action'] == 1 ? 'disabled="true"' : ''}}></div>';

		html += @php if($issued[$i]["user_action"] == 0) { @endphp'<div class="col-3 form-group" align="center" style="padding-top: 40px; color: white;"><div></div><a class="btn-danger btn-sm btn_remove" id="'+i+'"><span class="fa fa-lg fa-times"></span></a></div>'@php } elseif($issued[$i]["user_action"] == 1){ @endphp '<div class="col-3 form-group" style="text-align:center;padding-top: 40px;"><strong style="color: #0cac0c; font-weight: bold;">RECEIVED</strong></div>'@php  } @endphp;

		html += '<input type="hidden" name="user_action[]" value="{{$issued[$i]['user_action']}}" {{$issued[$i]['user_action'] == 1 ? 'disabled="true"' : ''}}>';

			$('#addRow').append(html);
	 	
	 @php 
	 	$i++;
	 }

	 @endphp
	 i = "{{$i}}";

	$('#addMore').on('click', function(e){
		e.preventDefault();
		var html = '<div id="row'+i+'"><hr><div class="row col-12"><div class="col-3 form-group"><label for="serial">Serial no.</label><input type="text" class="form-control" name="serial[]" ></div>';
		
		html += '<div class="col-3 form-group"><label for="name">Name</label><input type="text" name="name[]" class="form-control"></div><div class="col-3 form-group"><label for="model">Model</label><input type="text" name="model[]" class="form-control"></div>';
		
		html += '<div class="col-3 form-group"><label for="color">Color</label><input type="text" name="color[]" class="form-control"></div>';

		html += '<div class="col-3 form-group"><label for="given_date">Issue Date</label><input type="text" name="given_date[]" class="form-control datepicker" autocomplete="off"></div>';

		html += '<div class="col-3 form-group"><label for="quantity">Quantity</label><input type="number" min="1" name="quantity[]" class="form-control"></div>';

		html += '<div class="col-2 form-group" align="center" style="padding-top: 18px; color:white"><div><label for="close"></label></div><a class="btn-danger btn-sm btn_remove" id="'+i+'"><span class="fa fa-lg fa-times"></span></a></div></div></div>';

			$('#addRow').append(html)

		i++;
	})

	$(document).on('click', '.btn_remove', function(){

		var button_id = $(this).attr("id");

		$('#row'+button_id+'').remove();
	});

});
$('body').on('focus', '.datepicker', function(){
	   $(this).datepicker({
	   		orientation: "bottom",
			format: "mm-dd-yyyy",
			autoclose: true,
			todayHighlight: true
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
