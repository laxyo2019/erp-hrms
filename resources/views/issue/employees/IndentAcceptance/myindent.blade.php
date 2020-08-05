<div class="row">
	<div class="col-6"><h4>Issued Article/Items Details</h4></div>
</div>
@foreach($indent as $index)
	<hr>
	<div id="addRow">
		<div class="row col-12">
			<div class="col-3 form-group">
				<label for="serial">Serial no.</label>
				<input type="text" class="form-control" name="serial[]" value="{{$index->serial}}"  disabled="true">
			</div>
			<div class="col-3 form-group">
				<label for="name">Name</label>
				<input type="text" name="name[]" class="form-control" value="{{$index->name}}"  disabled="true">
			</div>
			<div class="col-3 form-group">
				<label for="model">Model</label>
				<input type="text" name="model[]" class="form-control" value="{{$index->model}}" disabled="true">
			</div>
			<div class="col-3 form-group">
				<label for="color">Color</label>
				<input type="text" name="color[]" class="form-control" value="{{$index->color}}" disabled="true">
			</div>
			<div class="col-3 form-group">
				<label for="given_date">Issue Date</label>
				<input type="text" value="{{$index->issue_date}}" name="given_date[]" class="form-control datepicker" autocomplete="off" disabled="true">
			</div>
			<div class="col-3 form-group">
				<label for="quantity">Quantity</label>
				<input type="number" min="1" name="quantity[]" value="{{$index->quantity}}" class="form-control" disabled="true">
			</div>
			<div class="col-3 form-group">
				<label for="received_date">Received Date</label>
				<input type="text" name="received_date[]" id="received_{{$index->id}}" class="form-control datepicker" autocomplete="off" value="{{$index->received_date}}">
			</div>
			@if($index->user_action != 0 || $index->user_action == 1)
			<div class="col-3 form-group">
				<label for="received_date">Handover Date</label>
				<input type="text" name="handover_date[]" id="handover_{{$index->id}}" class="form-control datepicker" autocomplete="off" value="{{$index->handover_date}}">
			</div>
			@endif
		</div><br>
		<div class="row col-12">
			<div class="col-3 form-group" style="padding-top: 10px">
				<label>STATUS &nbsp  - &nbsp</label>

					<strong id="recvMsg_{{$index->id}}" style="color: #0cac0c; font-weight: bold; display: none">RECEIVED</strong>
					<strong id="handMsg_{{$index->id}}" style="color: #3375ca; font-weight: bold; display: none">HANDOVERED</strong>

				@if($index->user_action == 0)
					<strong id="issueMsg_{{$index->id}}" style="color: #0cac0c; font-weight: bold;">ISSUED</strong>
				@elseif($index->user_action == 1)
					<strong id="receiveMsg_{{$index->id}}" style="color: #0cac0c; font-weight: bold;">RECEIVED</strong>
				@elseif($index->user_action == 2)
					<strong id="handoverMsg_{{$index->id}}" style="color: #3375ca; font-weight: bold;">HANDOVERED</strong>
				@elseif($index->user_action == 3)
					<strong id="acceptance_{{$index->id}}" style="color: #3375ca; font-weight: bold;">ACCEPTED</strong>
				@endif
			</div>
			<div class="col-3 form-group">

				<button type="button" style="display: none" data-id="{{$index->id}}" class="btn btn-primary btn-sm action" value="2" id="handBtn_{{$index->id}}">handover</button>


				@if($index->user_action == 0)

					<button type="button"  data-id="{{$index->id}}" class="btn btn-success btn-sm action" value="1" id="recvBtn_{{$index->id}}">received</button>

				@elseif($index->user_action == 1)

					<button type="button"  data-id="{{$index->id}}" class="btn btn-primary btn-sm action" value="2" id="handBtnraw_{{$index->id}}">handover</button>

				@endif
			</div>
		</div>
	</div>
@endforeach
<script type="text/javascript">
$(document).ready(function(){

	$('.action').on('click', function(){

		var itemId	 = $(this).data('id');

		var value_btn = $(this).val();

		if(value_btn == 1){

			var received_date = $('#received_'+itemId).val();

			if(received_date != ''){
				$.ajax({
					type: 'PATCH',
					url: '/issue/my-indent/'+itemId,
					headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					data: {'received_date': received_date, 'value_btn': value_btn},
					success: function(){

						if(value_btn == 1){

							$('#recvBtn_'+itemId).hide();
							$('#recvMsg_'+itemId).show();
							$('#issueMsg_'+itemId).hide()
							//$('#handBtn_'+itemId).show()
						}
					}
				});
			}else{

				alert('Receive date can\'t be empty.');
			}

		}else if(value_btn == 2){

			var handover_date = $('#handover_'+itemId).val();

			if(handover_date != ''){

				$.ajax({
					type: 'PATCH',
					url: '/issue/my-indent/'+itemId,
					headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					data: {'handover_date': handover_date, 'value_btn': value_btn},
					success: function(){

						$('#handBtnraw_'+itemId).hide();
						$('#receiveMsg_'+itemId).hide();
						$('#handMsg_'+itemId).show()
					}
				});

			}else{

				alert('Handover date can\'t be empty.');
			}
		}
	})
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
