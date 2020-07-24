<div class="row">
	<div class="col-6"><h4>Issued Item Details</h4></div>
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
				<input type="text" name="received_date[]" id="received_{{$index->id}}" class="form-control datepicker" value="{{$index->received_date}}">
			</div>
			<div class="col-3 form-group" style="padding: 30px 0 0 0; text-align: center">
				@if($index->user_action == 0)
					<button type="button"  data-id="{{$index->id}}" class="btn btn-success btn-sm action" value="1" id="apprvBtn_{{$index->id}}">RECEIVE</button>

					<strong class="apprv_msg" id="apprv_msg_{{$index->id}}" style="display: none;font-weight: bold;" >RECEIVED</strong>
				@elseif($index->user_action == 1)
					<strong style="color: #0cac0c; font-weight: bold;">RECEIVED</strong>
				@endif
			</div>
		</div>
	</div>
@endforeach
<script type="text/javascript">
$(document).ready(function(){

	$('.action').on('click', function(){
		var itemId	 = $(this).data('id');

		var received_date = $('#received_'+itemId).val();

		if(received_date != ''){
			$.ajax({
				type: 'PATCH',
				url: '/issue/my-indent/'+itemId,
				headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: {'received_date': received_date},
				success: function(){

					$('#apprvBtn_'+itemId).hide();
					$('#apprv_msg_'+itemId).show();

				}
			});
		}else{

			alert('Receive date can\'t be empty.');
		}
	})

	$('')
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
