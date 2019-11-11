@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div class="row">
			<div class="col-md-12 col-xl-12">
				<h1 style="font-size: 24px">Leave Application</h1>
			</div>
		</div>
	<div style="margin-top: 1.5rem; padding: 1.5rem; border: 1px solid grey;">
		@if($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				{{$message}}
			</div>
		@endif 
			<form action="{{url('employee/leaves')}}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="row">
					<div class="col-6 form-group">
							<label for="leave_type">Leave</label>
							<select name="leave_type_id" id="leave_type" class="custom-select">
								<option value="">Select</option>
								@foreach($leave_type as $leave_type)
								<option value="{{$leave_type->id}}">{{$leave_type->name}}</option>
								@endforeach
							</select>
							@error('leave_type_id')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
							@enderror
						</div>
						<div class="col-6 form-group">
						<label for="team_lead">Team Lead</label>
						<input type="text" id="team_lead" class="form-control" name="team_lead"	value="{{$team_lead->emp_name}}" disabled>
						<input type="hidden" name="team_lead_id" value="{{$team_lead->id}}">
						{{-- @error('team_lead')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror --}}
					</div>
						<div class="col-3 form-group">
						<label for="start_date">Start Date</label>
						<input type="text" class="form-control datepicker start" name="start_date" autocomplete="off" id="start_date">
						@error('start_date')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-3 form-group">
						<label for="end_date">End Date</label>
						<input type="text" class="form-control datepicker end" name="end_date"
						autocomplete="off" id="end_date">
						@error('end_date')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-3 form-group">
						<label for="end_date">Duration</label>
						<input type="text" class="form-control duration" name="end_date"
						id="end_date" disabled="" value="">
						{{-- @if() --}}
				          <span class="text-danger duration_alert" style="display:none" role="alert" >
				            <strong>You don't have adequate leave left.</strong> </span>
				      	{{-- @endif --}}
					</div>
					
					<div class="col-7 form-group">
						<label for="reason">Reason</label>
						<textarea  class="form-control" id="reason" name="reason" value=""></textarea>
						@error('reason')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-5 form-group">
						<label for="contact_no">Contact no</label>
						<input type="text" id="contact_no" class="form-control" name="contact_no"
						value="">
						@error('contact_no')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-7 form-group">
						<label for="file_path">Upload Documents</label>
    					<input type="file" name="file_path" class="form-control-file" id="file_path" value="">
					</div>
					<div class="col-6 form-group">
						<label for="address_leave">Address During Leave</label>
						<textarea class="form-control" id="address_leave" name="address_leave"	value=""></textarea>
						@error('address_leave')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-6 form-group">
						<label for="applicant_remark">Applicant's Remark</label>
						<textarea class="form-control" id="applicant_remark" name="applicant_remark" value=""></textarea>
						@error('applicant_remark')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-12 form-group text-center">
						<button class="btn btn-info btn-sm m-2">Save</button>
						<a class="btn btn-danger btn-sm" type="submit" href="javascript:location.reload()">Cancel</a>
					</div>
				</div>
			</form>
	</main>
	<script>
		$(document).ready(function(){
			
			$('.datepicker').datepicker({
				orientation: "bottom",
				format: "yyyy-mm-dd",
				autoclose: true,
				todayHighlight: true
			});

			$(".end").on("change",function(){

				var leave_type 	= $('select').children("option:selected").val();
		        var start 		= $('.start').val();
		        var end 		= $('.end').val();
		        var id 			= '<?php echo auth()->user()->id; ?>';

		        $.ajax({
				type:'get',
				url: '/balance/',
				data:{'leave_type': leave_type, 'start_date':start,'end_date':end, 'id': id },
				success:function(data){
					console.log('env',data);
					 var data = JSON.parse(data);
					 console.log("after parse",data.msg);

					$('.duration').val(data.days+' days');
					if(data.msg == 0 ){
						console.log('testing');
						$(".duration_alert").show();
						$('button').attr('disabled', 'true');
					}else{
						$(".duration_alert").hide();
						$('button').removeAttr('disabled');
					}
					
				}
			});

		    });
		    
		});
	</script>
@endsection
