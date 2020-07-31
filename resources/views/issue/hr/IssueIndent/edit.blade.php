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
			<div class="row col-12">
				<div class="col-2" style="padding-top: 10px">
				<h5>Employee Detail</h5>
				</div>
				<div class="col-3">
				<button class="btn-sm btn btn-primary" id="history" data-id="{{$employee->user_id}}">history</button>
				<button class="btn-sm btn btn-primary" id="issueIndent" data-id="{{$employee->user_id}}" style="display: none"><i class="fa fa-angle-left" aria-hidden="true"></i>issue indent</button>
				</div>
			</div><br>
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
			<div id="switchPage">
			</div>
			<div class="row" id="addRow">
				 <div class="row col-12"><div class="col-6"><h4>Article/Items Details </h4></div><div class="col-6"><button class="btn-sm btn-primary rounded-sm" style="font-size:18px;float: right;" id="addMore" title="Add More Person"><i class="fa fa-plus"></i></button></div>
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

	//History button for those items which have been handover to company

	$('#history').on('click', function(e){
		e.preventDefault();

		var emp_id = $(this).data('id');

		$.ajax({
			type: 'GET',
			url: '/issue-indent/'+emp_id,
			headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(res){
				console.log(res)

				$('#history').hide()
				$('#issueIndent').show()
				$('#addRow').hide();
				$('#switchPage').show()
				$('#switchPage').html(res)

			}
		})
	})

	$('#issueIndent').on('click', function(e){
		e.preventDefault();
		var emp_id = $(this).data('id');

		$('#addRow').show();
		$('#history').show()
		$('#issueIndent').hide()
		$('#switchPage').hide()

	})



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


		while($i < $count_issued){ 
	@endphp
	var html = '<div id="row'+i+'"><hr><div class="row col-12"><div class="col-3 form-group"><label for="serial">Serial no.</label><input type="text" class="form-control" name="serial[]" value="{{$issued[$i]['serial']}}" {{$issued[$i]['user_action'] != 0 ? 'disabled="true"' : ''}} disabled="true"></div>';

		html +=	'<div class="col-3 form-group"><label for="name">Name</label><input type="text" name="name[]" class="form-control" value="{{$issued[$i]['name']}}" {{$issued[$i]['user_action'] != 0 ? 'disabled="true"' : ''}} disabled="true"></div>';

		html += '<div class="col-3 form-group"><label for="model">Model</label><input type="text" name="model[]" class="form-control" value="{{$issued[$i]['model']}}" {{$issued[$i]['user_action'] != 0 ? 'disabled="true"' : ''}} disabled="true"></div>';

		html += '<div class="col-3 form-group"><label for="color">Color</label><input type="text" name="color[]" class="form-control" value="{{$issued[$i]['color']}}" {{$issued[$i]['user_action'] != 0 ? 'disabled="true"' : ''}} disabled="true"></div>';

		html += '<div class="col-3 form-group"><label for="quantity">Quantity</label><input type="number" min="1" name="quantity[]"  class="form-control" value="{{$issued[$i]['quantity']}}" {{$issued[$i]['user_action'] != 0 ? 'disabled="true"' : ''}} disabled="true"></div>';

		html += '<div class="col-3 form-group"><label for="given_date">Issue Date</label><input type="text" name="given_date[]" class="form-control datepicker" value="{{$issued[$i]['issue_date']}}" {{$issued[$i]['user_action'] != 0 ? 'disabled="true"' : ''}} disabled="true"></div>';

		html += '<div class="col-3 form-group"><label for="received_date">Received Date</label><input type="text" name="received_date[]" disabled="true" class="form-control" value="{{$issued[$i]['received_date']}}" {{$issued[$i]['user_action'] != 0 ? 'disabled="true"' : ''}} disabled="true"></div>';

		html += '<div class="col-3 form-group"><label for="handover_date">Handover Date</label><input type="text" name="handover_date[]" disabled="true" class="form-control" value="{{$issued[$i]['handover_date']}}" {{$issued[$i]['user_action'] != 0 ? 'disabled="true"' : ''}} disabled="true"></div>';

		html += @if($issued[$i]['user_action'] != 0 || $issued[$i]['user_action'] != 1)
					'<div class="col-3 form-group"><label for="accept_date">Acceptance Date</label><input type="text" class="form-control datepicker" autocomplete="off" value="" {{$issued[$i]['user_action'] != 2 ? 'disabled="true"' : ''}} id="handoverApprov_{{$issued[$i]['id']}}"></div>'
				@endif

		html += '<input type="hidden" name="user_action[]" value="{{$issued[$i]['user_action']}}" {{$issued[$i]['user_action'] == 2 ? 'disabled="true"' : ''}}>';

		html += '<div class="row col-12"><div class="col-4 form-group" style="padding-top: 10px"><label>STATUS &nbsp  - &nbsp</label>';

		html += '<strong id="handApprovSts_{{$issued[$i]['id']}}" style="color: #0cac0c; font-weight: bold; display: none">HANDOVER APPROVED</strong>';

		html += @if($issued[$i]["user_action"] == 0)

					'<strong style="color: #0cac0c; font-weight: bold;">ISSUED</strong>'

				@elseif($issued[$i]["user_action"] == 1)

					'<strong style="color: #0cac0c; font-weight: bold;">RECEIVED</strong>'

				@elseif($issued[$i]["user_action"] == 2)

					'<strong id="handOverMsg_{{$issued[$i]['id']}}" style="color: #3375ca; font-weight: bold;">HANDOVERED</strong>'

				@elseif($issued[$i]["user_action"] == 3)

					'<strong id="handApprovMsg_{{$issued[$i]['id']}}" style="color: #3375ca; font-weight: bold;">HANDOVER APPROVED</strong>'

				@endif'</div><div class="col-3 form-group">';

		html += '</div><div class="col-3 form-group">';

		html += @if($issued[$i]["user_action"] == 2)
					'<button type="button"  data-id="{{$issued[$i]->id}}" class="btn btn-success btn-sm action" value="3" id="handOverBtn_{{$issued[$i]['id']}}">approve handover</button>'
				@endif
				'</div></div>';

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

		html += '<div class="col-2 form-group" align="center" style="padding-top: 15px; color:white"><div><label for="close"></label></div><a class="btn-danger btn-sm btn_remove" id="'+i+'"><span class="fa fa-lg fa-times"></span></a></div></div></div>';

			$('#addRow').append(html)

		i++;
	})

	//Handover Approval Button

	$('.action').on('click', function(){

		var itemId = $(this).data('id');

		var handover_approval = $('#handoverApprov_'+itemId).val();

		var value_btn = $(this).val();

		if(handover_approval != ''){

			$.ajax({
				type: 'PATCH',
				url: '/issue/my-indent/'+itemId,
				headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: {'handover_approval': handover_approval, 'value_btn': value_btn},
				success: function(){

					$('#handApprovSts_'+itemId).show();
					$('#handOverBtn_'+itemId).hide();
					$('#handOverMsg_'+itemId).hide()
					//$('#handApprovMsg_'+itemId).show()
				}
			})
		}else{
			alert('Receive date can\'t be empty.');
		}
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
