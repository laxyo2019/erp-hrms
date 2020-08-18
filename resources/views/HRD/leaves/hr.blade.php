@extends('layouts.master')
@section('content')
	<main class="app-content">
		<div class="row mt-1 ">	
			<div class="col-md-12 col-xl-12">
				<div class="card">
					<div class="col-md-12 col-xl-12" style="margin-top: 15px">
						<h1 style="font-size: 24px">LEAVE REQUESTS
						<a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right" style="font-size:13px"  style="{background-color: #e7e7e7; color: black;}" >Back</a>
					</div>
					<div class="card-body table-responsive">
						@if($message = Session::get('success'))
							<div class="alert alert-success alert-block">
								<button type="button" class="close" data-dismiss="alert" >×</button>
								{{$message}}
							</div>
						@endif
						<div class="row col-12">
							<div class="col-2">
								<label for="">From</label>
								<input name="from" aria-controls="ClientsTable" class="form-control form-control-sm datepicker" id="fromDate" autocomplete="off" placeholder="">
							</div>
							<div class="col-2">
								<label for="">To</label>
								<input name="from" aria-controls="ClientsTable" class="form-control form-control-sm datepicker" id="toDate" autocomplete="off">
							</div>
							<div class="col-2">
								<label for="">Status</label>
									<select name="status" id="leaveStatus" aria-controls="ClientsTable" class="custom-select custom-select-sm form-control form-control-sm">
									<option value="">Select status</option>
									<option value="0">PENDING</option>
									<option value="1">APPROVED</option>
								</select>
							</div>
						</div><br>
						<div id="teamLeadStatus">
							@include('HRD.leaves.status.hr-status')
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</main>
<script>
$(document).ready(function(){

$('.datepicker').datepicker({
	orientation: "auto",
	format: "yyyy-mm-dd",
	autoclose: true,
	todayHighlight: true
});
	//Open detail view of leave requests.

	$('.modalReq').on('click', function(e){
		e.preventDefault();

		var leave_id = $(this).data('id');
		$.ajax({
			type: 'GET',
			url: '/hrd/leaves/'+leave_id,
			success:function(res){
				$('#detailTable').empty().html(res);
				$('#reqModal').modal('show');
			}
		})
	});

	// Approve/Decline requests.

	$('.action').on('click', function(){

		var action 		= $(this).val();
		var request_id 	= $(this).data('id');

		//alert([action, request_id]);

		if(action == 2){

			var txt = prompt('Please enter reason.');

			if(txt != null){

				$('.decline').attr('value', txt);

			}else{
				return false;
			}
		}

		$.ajax({
			type: 'POST',
			url: "/leave-request/hr/"+request_id,
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {'action':action, 'text':txt},
			success:function(res){

				if(res.flag == 1){
					
					$('#apprvBtn_'+request_id).hide();
					$('#decBtn_'+request_id).hide();
					if(res.action == 1){
						$('#apprv_msg_'+request_id).show();
					}else if(res.flag == 0){
						
						$('#dec_msg_'+request_id).show();
					}
				}else if(res.flag == 0){

					location.reload();
				}
			}
		});
	});

	//Reverse leaves
	
	$('.reverse').on('click', function(){

		var request_id 	= $(this).val();
		$.ajax({
			type: 'POST',
			url: '/reverse/hr/'+request_id,
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			//data: {action:'action'},
			success:function(res){

				if(res.flag == 1){

					$('#revBtn_'+request_id).hide();
					$('#rev_msg_'+request_id).show();
				}else if( res.msg == 0)
					
					location.reload();
			}
		});
	});

	//Search Filter
	$('#leaveStatus').on('change', function(){

		var leaveStatus = $(this).val()

		// Date
		var role 	 = 'hr';
		var fromDate = $('#fromDate').val();
		var toDate	 = $('#toDate').val();

		// $.ajax({
		// 	type: 'POST',
		// 	url: '{{route('leave.status')}}',
		// 	data: {'leaveStatus': leaveStatus, 'role': role, 'fromDate': fromDate, 'toDate': toDate},
		// 	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		// 	success: function(res){

		// 		$('#teamLeadStatus').empty().html(res);
		// 	}
		// })
		if(leaveStatus != ''){
			$.ajax({
				type: 'POST',
				url: '{{route('leave.status')}}',
				data: {'leaveStatus': leaveStatus, 'role': role, 'fromDate': fromDate, 'toDate': toDate},
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				success: function(res){
					 console.log(res)

					 $('#teamLeadStatus').html(res);
				}
			});
		}
	})

	/*$('#toDate').on('changeDate', function(){
		var fromDate = $('#fromDate').val();
		var toDate	 = $(this).val();
		var type 	 = 2;
		var role 	 = 'hr';

		$.ajax({
			type: 'POST',
			
			data: {'fromDate': fromDate, 'toDate': toDate, 'type': type, 'role': role},
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(res){
				console.log(res)
				$('#teamLeadStatus').html(res)
			}
		})
	})*/

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

@endsection