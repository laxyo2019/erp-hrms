@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
  <style type="text/css">
  	.d-none{
  		display: none;
  	}
  </style>
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
						@error('reports_to')
				          	<span style="color: red">
								| {{ $message }}
							</span>
				      	@enderror
					</label>
					<input type="text" id="reports_to" class="form-control" name="reports_to"	value="{{!empty($reports_to) ? $reports_to->emp_name : null}}" disabled>
					<input type="hidden" name="reports_to" value="{{!empty($reports_to) ?$reports_to->id : null}}">
				</div>
	    	</div>
	    	<div class="row" style="padding-top: 1%">
				<div class="col-1 form-group">
					<button type="button" id="multiBtn" class="btn btn-primary active d-none" >Multiple</button>
				</div>
				<div class="col-1 form-group">
					<button type="button" id="fullBtn" class="btn btn-primary d-none" >Full Day</button>
					<input type="hidden" name="full_day" id="full_day">
				</div>
				<div class="col-1 form-group">
					<button type="button" id="halfBtn" class="btn btn-primary d-none">Half Day</button>
				</div>
	    	</div>
	    	<div class="row">
				<div class="col-4">
					<label for="start_date">Start Date @error('start_date') <span style="color: red">| {{ $message }}</span> @enderror
					</label>
					<input type="text" class="form-control datepicker start" name="start_date" autocomplete="off" id="start_date">
			    </div>
				<div class="col-4">
					<label class=""></label>
					<span id="end_date"><label for="end_date">End Date <span id="small-date" style="color: 'red"></span></label>
					<input type="text" class="form-control datepicker end" name="end_date" autocomplete="off" id="end_date">
			      	</span>
			      	<span id="checkday" class="d-none">
				      	<label class="">
						    <input type="radio" name="half_day" value="first_half" autocomplete="off" > First Half
						</label>
						<label class="">
						    <input type="radio"  name="half_day" value="second_half" autocomplete="off" > Second Half
						</label>
					</span>
				</div>
				<input type="hidden" name="day" id="day">
				<div class="col-4 form-group">
					<label for="duration">Duration ( In days )
						@error('count')
				          	<span style="color: red">
								| {{ $message }}
							</span>
				      	@enderror

					</label>
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
				<div class="col-7 form-group d-none">
					<label for="file_path">Upload Documents 
						<span id="docs_error" style="color: red"></span>
						@error('file_path')
				          <span class="text-danger" role="alert">
				            <strong>| {{ $message }}</strong>
				          </span>
				      	@enderror
					</label>
					<input type="file" name="" class="form-control-file" id="file_path" value="">
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
				dateLimit: { days: 3 }
			});

/************Old Code********/
		//Hide full & half day for Privilege leave
		/*$('#leave_type').on('change', function(){

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
				$('#full, #half').attr('hidden', false);
				$('#checkday').attr('hidden', false);

			}else{
				$('#full, #half').removeAttr('hidden');
				$('#checkday').attr('hidden', false);
				$('#submit').removeAttr('disabled', false);
				$('#docs_error').text('')
				//casualCount();
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
				data:{'leave_type': leave_type, 'start_date':start,'end_date':end, 'emp_id': id, 'day': day},

					success:function(data){
						console.log(data.days)
						 var data = JSON.parse(data);
						$('.duration').val(data.days+' days');
						$('#count').val(data.days);

						if(data.days <= 3){
							//0 - If you have enough leave balance
							if(data.msg == 0 ){
								$(".duration_alert").hide();
							}else{
								$(".duration_alert").show();
							}
						}else{
							alert('you cant apply for more than 3 days.');
							$('#duration').val('');
							$('#count').val('');
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
						$('#day').val(day);

						if(data.rule == null){
							$(".duration_alert").hide();
						}
						alert(data);
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

	    	$('input[type=radio]').on('click', function(){
	    		var leave_type 	= $('select').children("option:selected").val();
		        var start 		= $('.start').val();
		        var end 		= $('.end').val();
		        var emp_id 		= "{{Auth::id()}}";
		        //var day 		= 'half';
		        var day 		= $("input[name='half_day']:checked").val();
		        $.ajax({
					type:'get',
					url: '/balance/',
					data:{'leave_type': leave_type, 'start_date':start,'end_date':end, 'emp_id': emp_id, 'day': day },
					success:function(data){
						var data = JSON.parse(data);
						 
						$('.duration').val('Half day');
						$('#count').val(data.days);
						$('#day').val(day);

						if(data.msg == 0 ){
							$(".duration_alert").hide();
						}else{
							$(".duration_alert").show();
							$('button').removeAttr('disabled');
						}
					}
				});
	    	})
	    });*/

/****************************/

	    /***New Code***/


	    $('#leave_type').on('change', function(){
	    	var leave_id = $(this).children("option:selected").val();
			var name  = $(this).children("option:selected").text();
			var leaveType = name.trim().toLowerCase();
				

			if (leave_id) {

				$.ajax({
					type:'get',
					url: '/balance/',
					data:{'leave_id': leave_id},
					success: function(res){


						

						//Check for Half day
						if(res.min_apply_once == 0.5){
							checkHalf(res);
							
						//Check for 1 day
						}else if(res.min_apply_once == 1.0){ 

							checkOnce(res);

						//Check for more than 1 day
						}else{

							$('#halfBtn').addClass('d-none');
							$('#fullBtn').addClass('d-none');
							$('#multiBtn').removeClass('d-none');


						}

						//Carry forward
						/*if(res.carry_forward == null){
							alert(3)
							$('#file_path').val('name', '');
						}else{
							alert(6)
							$('#file_path').val('name', 'file_path');
						}*/
						
						
						console.log(res);  
		            }
		 		});
			}		

		});
	});

function checkHalf(res){
	if(res.max_apply_once == 0.5){
		$('#halfBtn').addClass('active');
		$('#fullBtn, #multiBtn').removeClass('active');
		$('#halfBtn').removeClass('d-none');

		//hide date box
		$('#end_date').addClass('d-none');
		$('#checkday').removeClass('d-none');
		halfDate();

		$('#fullBtn').addClass('d-none');
		$('#multiBtn').addClass('d-none');
	}else if(res.max_apply_once == 1.0){


		/***For buttons***/
		$('#fullBtn').addClass('active');
		$('#halfBtn, #multiBtn').removeClass('active');

		$('#halfBtn').removeClass('d-none');
		$('#fullBtn').removeClass('d-none');
		$('#multiBtn').addClass('d-none');

		
		//Default fields
		$('#checkday').addClass('d-none');
		$('#end_date').addClass('d-none');

		/***For fields***/
		halfDate();
		fullDate();


	}else if(res.max_apply_once > 1.0){

		/***For buttons***/
		$('#multiBtn').addClass('active');
		$('#halfBtn, #fullBtn').removeClass('active');

		$('#halfBtn').removeClass('d-none');
		$('#fullBtn').removeClass('d-none');
		$('#multiBtn').removeClass('d-none');

		multiDate();
		fullDate();
		halfDate();
	}else {
		$('#halfBtn').removeClass('d-none');
		$('#fullBtn').removeClass('d-none');
		$('#multiBtn').removeClass('d-none');

		multiDate();
		fullDate();
		halfDate();
	}	
}

function checkOnce(res){
	if(res.max_apply_once == 1.0){
		$('#halfBtn').addClass('d-none');
		$('#fullBtn').removeClass('d-none');
		$('#multiBtn').addClass('d-none');
	}else if(res.max_apply_once > 1.0){
		$('#halfBtn').addClass('d-none');
		$('#fullBtn').removeClass('d-none');
		$('#multiBtn').removeClass('d-none');
	}else {
		$('#halfBtn').addClass('d-none');
		$('#fullBtn').removeClass('d-none');
		$('#multiBtn').removeClass('d-none');
	}	
}


function multiDate(){

	$('#multiBtn').on('click', function(){

		//Add & remove active class
		$('#multiBtn').addClass('active');
		$('#halfBtn, #fullBtn').removeClass('active');

		$('#checkday').addClass('d-none');
		$('#end_date').removeClass('d-none');

	});
}

function fullDate(){

	$('#fullBtn').on('click', function(){

		//Add & remove active class
		$('#fullBtn').addClass('active');
		$('#halfBtn, #multiBtn').removeClass('active');

		//Hide date & radio btns
		$('#checkday').addClass('d-none');
		$('#end_date').addClass('d-none');

	});
}

function halfDate(){

	$('#halfBtn').on('click', function(){

		//Add & remove active class
		$('#halfBtn').addClass('active');
		$('#fullBtn, #multiBtn').removeClass('active');

		//Hide date & radio btns
		$('#checkday').removeClass('d-none');
		$('#end_date').addClass('d-none');

	});
}

// function leaveValidation(leave_id){
// 	alert('helo');
// 	var re_data = '';
// 	 re_data = $.ajax({
// 			type:'get',
// 			url: '/balance/',
// 			data:{'leave_id': leave_id},
// 			success: function(data){
                  
               
//                  // console.log(re_data);
//             }
 	
// 			// success:function(data){
// 			// 	re_data = data	

// 			// 	//alert(data.leave_bal)
// 			// 	 if(data.min_apply_once >= 2){
// 			// 	 	$('#checkday').attr('hidden', true);
// 			// 		$('#full, #half').attr('hidden', true);
// 			// 		$('#docs_error').text('')
// 			// 		$('#end_date').show();
// 			// 		$('#submit').removeAttr('disabled', false);
// 			// 	 }

				
// 			// 	/*$('.duration').val('Half day');
// 			// 	$('#count').val(data.days);
// 			// 	$('#day').val(day);

// 			// 	if(data.msg == 0 ){
// 			// 		$(".duration_alert").hide();
// 			// 	}else{
// 			// 		$(".duration_alert").show();
// 			// 		$('button').removeAttr('disabled');
// 			// 	}*/
// 			// }
// 		});
// 	// data = re_data;
// 	 // console.log(re_data);
// 	 return re_data;
// }
</script>
@endsection
