@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div class="row">
		<div class="col-md-12 col-xl-12">
			<h1 style="font-size: 24px">Leave Application
				<a href="{{ url('employee/leaves') }}" class="btn btn-sm btn-primary pull-right" style="font-size:13px"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
			</h1>
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
						<label for="leave_type">Leave 
							@error('leave_type_id')
								<span style="color: red">
									| {{ $message }}
								</span>
							@enderror
						</label>
						<select name="leave_type_id" id="leave_type" class="custom-select">
							<option value="">Select</option>
							@foreach($leave_type as $leave_types)
								<option value="{{$leave_types->id}}">{{ucwords($leave_types->name)}}</option>
							@endforeach
						</select>
					</div>
					<div class="col-6 form-group">
					<label for="reports_to">Reports To
						@error('team_lead_id')
				          	<span style="color: red">
								| {{ $message }}
							</span>
				      	@enderror
					</label>
					<input type="text" id="reports_to" class="form-control" name="reports_to"	value="{{!empty($reports_to) ? $reports_to->emp_name : null}}" disabled>
					<input type="hidden" name="team_lead_id" value="{{!empty($reports_to) ?$reports_to->id : null}}">
				</div>
	    	</div>
	    	<div class="row"   style="padding-top: 1%">
				<div class="col-1 form-group">
					<button type="button" id="multi" class="btn btn-primary active">Multiple</button>
				</div>
				<div class="col-1 form-group">
					<button type="button" id="full" class="btn btn-primary " >Full Day</button>
				</div>
				<div class="col-1 form-group">
					<button type="button" id="half" class="btn btn-primary ">Half Day</button>
				</div>
	    	</div>
	    	<div class="row">
				<div class="col-4">
					<label for="start_date">Start Date
						@error('start_date')
				          	<span style="color: red">
								| {{ $message }}
							</span>
			      	@enderror
					</label>
					<input type="text" class="form-control datepicker start" name="start_date" autocomplete="off" id="start_date">
			      	<input type="hidden" name="full_day" id="full_day">
			    </div>
				<div class="col-4 form-group">
					<span id="end_date"><label for="end_date">End Date <span id="small-date" style="color: 'red"></span></label>
					<input type="text" class="form-control datepicker end" name="end_date" autocomplete="off" id="end_date">
			      	</span>
			      	<span id="checkday" style="display: none;">
				      	<label class="">
						    <input type="radio" name="half_day" value="1" autocomplete="off"> First Half
						</label>
						<label class="">
						    <input type="radio"  name="half_day" value="2" autocomplete="off"> Second Half
						</label>
					</span>
				</div>
				<div class="col-4 form-group">
					<label for="duration">Duration ( In days )</label>
					<input type="text" class="form-control duration" name="duration" id="duration" disabled="" value="">
					<input type="hidden" name="count" id="count" >
					<span class="text-danger duration_alert" role="alert" style="display:none">
		    			<strong> &nbsp;&nbsp;&nbsp; You don't have adequate leaves left.</strong>
		    		</span>
		    		<div>
		    		<span class="text-danger rule_alert" role="alert" style="display:none">
		    			<strong> &nbsp;&nbsp;&nbsp; Your leaves falling into sandwich rule.</strong>
		    		</span>
		    		</div>
				</div>
	    	</div>
	    	<div class="row">
				<div class="col-7 form-group">
					<label for="reason">Reason 
						@error('reason')
				          	<span style="color: red">
								| {{ $message }}
							</span>
				      	@enderror</label>
					<textarea  class="form-control" id="reason" name="reason" value=""></textarea>
					
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
					<label for="file_path">Upload Documents 
						<span id="docs_error" style="color: red"></span>
						@error('file_path')
				          <span class="text-danger" role="alert">
				            <strong>| {{ $message }}</strong>
				          </span>
				      	@enderror
					</label>
					<input type="file" name="file_path" class="form-control-file" id="file_path" value="">
					{{-- @error('file_path')
			          <span class="text-danger" role="alert">
			            <strong>* {{ $message }}</strong>
			          </span>
			      	@enderror --}}
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
				<div class="col-6 form-group">
					<label for="address_leave">Address During Leave</label>
					<textarea class="form-control" id="address_leave" name="address_leave"	value=""></textarea>
					{{-- @error('address_leave')
			          <span class="text-danger" role="alert">
			            <strong>* {{ $message }}</strong>
			          </span>
			      	@enderror --}}
				</div>
				<div class="col-12 form-group text-center">
					<button class="btn btn-info btn-sm m-2" id="submit" style="width: 30%">Save</button>
					<a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 30%">Clear</a>
				</div>
			</div>
		</form>
	</div>
</main>
<script>

	$(document).ready(function(){

			$('.datepicker').datepicker({
				orientation: "bottom",
				format: "yyyy-mm-dd",
				autoclose: true,
				todayHighlight: true,
				startDate: '-0m',
				minDate:'0'
			});

		//Hide full & half day for Privilege leave
		$('#leave_type').on('change', function(){

			var value = $(this).children("option:selected").val();
			var name  = $(this).children("option:selected").text();
			var leave = name.trim().toLowerCase();

			//Check if privilege id or string meet then hide other tabs
			if(value == 1 || leave.includes('privilege')){
				
				$('#checkday').attr('hidden', true);
				$('#full, #half').attr('hidden', true);
				$('#docs_error').text('')
				$('#end_date').show();
				$('#submit').removeAttr('disabled', false);
			}
			else if(value == 2 || leave.includes('sick')){
				$('#docs_error').text('| This field is mandatory')
				$('#file_path').attr('name', 'file_path')

			}else{
				$('#full, #half').removeAttr('hidden');
				$('#submit').removeAttr('disabled', false);
				$('#docs_error').text('')
			}
		});

		$('#multi').on('click', function(e){
	    	e.preventDefault();
	    	$(this).addClass('active');
	    	$('#end_date').show();
	    	$('#half, #full').removeClass('active');
	    	$('#checkday').hide();

	    });

	    $(".end").on("change",function(){
			var leave_type 	= $('select').children("option:selected").val();
	        var start 		= $('.start').val();
	        var end 		= $('.end').val();
	        var id 			= "{{Auth::id()}}";
	        var day 		= $('#multi').attr('id');

        	$('#submit').removeAttr('disabled')

			if( Date.parse(start) < Date.parse(end) ){ // Check if End date is higher or not
	        	$('#small-date').empty();
				$.ajax({
				type:'get',
				url: '/balance/',
				data:{'leave_type': leave_type, 'start_date':start,'end_date':end, 'id': id, 'day': day},

					success:function(data){
						console.log(data.days)
						 var data = JSON.parse(data);

						$('.duration').val(data.days+' days');
						$('#count').val(data.days);

						//0 - If you have enough leave balance
						if(data.msg == 0 ){
							$(".duration_alert").hide();
						}else{
							$(".duration_alert").show();
						}
						//0 - If you leave duration doesn't fall into sandwich rule
						if(data.rule == 0){
							$(".rule_alert").hide();
						}else{
							$(".rule_alert").show();
						}
					}
				});
	        }else{
	        	$('#count').val('');
				$('#duration').val('');
				$(".rule_alert").hide();
				$(".duration_alert").hide();
				$('#submit').attr('disabled', true)
				$('#small-date').css("color", "red").text("| date should be greater then start date.");
			}	        
	    });

	    $('#full').on('click', function(e){
	    	e.preventDefault();
	    	$(this).addClass('active');
	    	$('#half, #multi').removeClass('active');
	    	$('#checkday').hide();
	    	$('#end_date').hide();
	    	$('#full_day').val(1);

	    	$('#start_date').on('change', function(){
	    		var leave_type 	= $('select').children("option:selected").val();
		        var start 		= $('.start').val();
		        var end 		= $('.end').val();
		        var emp_id 		= "{{Auth::id()}}";
		        var day 		= 'full';

		        $.ajax({
					type:'get',
					url: '/balance/',
					data:{'leave_type': leave_type, 'start_date':start,'end_date':end, 'emp_id': emp_id, 'day': day },
					success:function(data){
						var data = JSON.parse(data);

						$('.duration').val(data.days+' days');
						$('#count').val(data.days);

						if(data.rule == null){
							$(".duration_alert").hide();
						}

						if(data.msg == 0 ){
							$(".duration_alert").hide();
						}else{
							$(".duration_alert").show();
							$('button').removeAttr('disabled');
						}
					}
				});
	    	})	    	
	    });

	    $('#half').on('click', function(e){
	    	e.preventDefault();
	    	$(this).addClass('active');
	    	$('#end_date').hide();
	    	$('#full, #multi').removeClass('active');
	    	$('#checkday').show();

	    	$('#start_date').on('change', function(){
	    		var leave_type 	= $('select').children("option:selected").val();
		        var start 		= $('.start').val();
		        var end 		= $('.end').val();
		        var emp_id 		= "{{Auth::id()}}";
		        var day 		= 'half';

		        $.ajax({
					type:'get',
					url: '/balance/',
					data:{'leave_type': leave_type, 'start_date':start,'end_date':end, 'emp_id': emp_id, 'day': day },
					success:function(data){
						 var data = JSON.parse(data);
						 //alert(data)

						$('.duration').val(data.days+' days');
						$('#count').val(data.days);
						if(data.msg == 0 ){
							$(".duration_alert").hide();
						}else{
							$(".duration_alert").show();
							$('button').removeAttr('disabled');
						}
					}
				});
	    	})
	    });
	});
function cm_add(){
	alert(54);
}
</script>
@endsection
