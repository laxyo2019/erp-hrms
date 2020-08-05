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
				<a href="{{ url('employee/leaves') }}" class="btn btn-sm btn-primary pull-right" style="font-size:13px"  style="{background-color: #e7e7e7; color: black;}" >Back</a>
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
						<label for="leave_type required">Leave 
							@error('leave_type_id')
								<span style="color: red">
									| {{ $message }}
								</span>
							@enderror
						</label>
						<select name="leave_type_id" id="leave_type" class="custom-select">
							<option value="">Select</option>
							@foreach($allotment as $leave_types)
							<option value="{{$leave_types['leaves']->id}}" {{old('leave_type_id') == $leave_types['leaves']->id ? 'selected' : ''}}
								{{-- Disable all leaves if initial balance is 0.0 and that leave type's total is 0.0 --}}
								{{$leave_types->initial_bal == 0.0 && $leave_types['leaves']->total != 0.0 ? 'disabled' : ''}} 
								>{{ucwords($leave_types['leaves']->name)}}</option>
							@endforeach
						</select>
					</div>
					<div class="col-6 form-group">
					<label for="reports_to">Team Lead
						@error('reports_to')
				          	<span style="color: red">
								| {{ $message }}
							</span>
				      	@enderror
					</label>
<input type="text" id="reports_to" class="form-control" name="reports_to"	value="{{!empty($reports_to['UserName']) ? $reports_to['UserName']->name : null}}" disabled>
					<input type="hidden" name="reports_to" value="{{!empty($reports_to['UserName']) ?$reports_to['UserName']->id : null}}">
				</div>
	    	</div>
	    	<div class="row" style="padding-top: 1%">
				<div class="col-1 form-group  ml-2">
					<button type="button" id="multiBtn" class="btn btn-primary active d-none" >Multiple</button>
				</div>
				<div class="col-1 form-group ml-2">
					<button type="button" id="fullBtn" class="btn btn-primary d-none" >Full Day</button>
				</div>
				<div class="col-1 form-group ml-2">
					<button type="button" id="halfBtn" class="btn btn-primary d-none">Half Day</button>
				</div>
	    	</div>
	    	<input type="hidden" name="btnId" id="btnId" value="">
	    	<div class="row">
				<div class="col-3">
					<label for="start_date">Start Date @error('start_date') <span style="color: red">| {{ $message }}</span> @enderror
					</label>
					<input type="text" class="form-control 	datepicker start" name="start_date" autocomplete="off" id="start_date" value="{{old('start_date')}}">
					{{-- @error('start_date')
						<span>{{$message}}</span>
					@enderror --}}
			    </div>
				<div class="col-3">
					<label class=""></label>
					<span id="endDate">
						<label for="end_date">End Date <span id="small-date" style="color: 'red"></span></label>
						<input type="text" class="form-control datepicker end" name="end_date" autocomplete="off" id="end_date" value="{{old('end_date')}}">
						<span class="text-danger rule_alert" role="alert" style="display:none">
		    				<strong> &nbsp;&nbsp;&nbsp; Your leaves falling into sandwich rule.</strong>
		    			</span>
						@error('end_date')
							<span>{{$message}}</span>
						@enderror
			      	</span>
			      	<br><br>
			      	<span id="checkday" class="d-none">
				      	<label class="">
						    <input type="radio" name="day_status" value="0"  {{old('day_status') == '0' ? 'checked' : 'checked'}}> First Half
						</label>
						<label class="">
						    <input type="radio"  name="day_status" value="1"  {{old('day_status') == '1' ? 'checked' : ''}}> Second Half
						</label>
					</span>
				</div>
				<div class="col-6 form-group">
					<label for="duration">Duration ( In days )
						@error('duration')
				          	<span style="color: red">
								| {{ $message }}
							</span>
				      	@enderror
					</label>
					<input type="text" class="form-control" id="duration" name="duration" value="{{old('duration')}}" readonly="">

					<span class="text-danger duration_alert" role="alert" style="display:none">
		    			<strong> &nbsp;&nbsp;&nbsp; You don't have adequate leaves left.</strong>
		    		</span>
		    		<div>
		    		
		    		</div>
				</div>
	    	</div>
	    	<div class="row">
				<div class="col-6 form-group">
					<label for="reason">Reason 
						@error('reason')
				          	<span style="color: red">
								| {{ $message }}
							</span>
				      	@enderror</label>
					<textarea  class="form-control" id="reason" name="reason" >{{old('reason')}}</textarea>
				</div>
				<div class="col-6 form-group">
					<label for="contact_no">Contact no</label>
					<input type="text" id="contact_no" class="form-control" name="contact_no"
					value="{{old('contact_no')}}">
					@error('contact_no')
			          <span class="text-danger" role="alert">
			            <strong>* {{ $message }}</strong>
			          </span>
			      	@enderror
				</div>
				<div class="col-7 form-group d-none" id="doc_element">
					<div class="col-5">
					<label for="file_path">Upload Documents 
						<span id="docs_error" style="color: red"></span>
						@error('file_path')
				          <span class="text-danger" role="alert">
				            <strong>| {{ $message }}</strong>
				          </span>
				      	@enderror
					</label>
					<input type="file"  class="form-control-file" name="file_path">
					</div>
				</div>

				<div class="col-6 form-group">
					<label for="applicant_remark">Applicant's Remark</label>
					<textarea class="form-control" id="applicant_remark" name="applicant_remark" value="">{{old('applicant_remark')}}</textarea>
					@error('applicant_remark')
			          <span class="text-danger" role="alert">
			            <strong>* {{ $message }}</strong>
			          </span>
			      	@enderror
				</div>
				<div class="col-6 form-group">
					<label for="address_leave">Address During Leave</label>
					<textarea class="form-control" id="address_leave" name="address_leave">{{old('address_leave')}}</textarea>
					 @error('address_leave')
			          <span class="text-danger" role="alert">
			            <strong>* {{ $message }}</strong>
			          </span>
			      	@enderror 
				</div>
				<div class="col-12 form-group text-center">
					<button class="btn btn-info btn-sm m-2" id="submit" style="width: 20%">Save</button>
					<a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 20%">Clear</a>
				</div>
			</div>
		</form>
		<div id="information">
		</div>
	</div>
</main>
<script>

$('.start').datepicker({
	orientation: "bottom",
	format: "yyyy-mm-dd",
	autoclose: true,
	todayHighlight: true,
	/*startDate: '-0m',*/
});
$(".end").datepicker({
	orientation: "bottom",
	format: "yyyy-mm-dd",
	autoclose: true,
	todayHighlight: true,
})
/*$(document).ready(function(){*/
	
	$('.start').on("change", function(event) {

		var btnId =	$('#btnId').val();
		var leave_id = $('#leave_type').val();
		

		if(btnId == 'fullBtn'){
			$('#duration').val(1);

		}else if(btnId == 'halfBtn'){
			
			$('#duration').val('Half Day');
		}

		if(btnId == 'fullBtn' || btnId == 'halfBtn'){

			//Check leave request should not be less than 2 days
			var startDate = new Date($('#start_date').val());
			var currDate = new Date();
			var subtractDays = currDate.setDate(currDate.getDate()-3);
			var leaveGap = subtractDays <= startDate;


			//if(leaveGap == true){


				$.ajax({
					type:'get',
					url: '/balance/',
					data:{'leave_id': leave_id},
					success: function(res){
						
						var duration = $('#duration').val();
						if(btnId == 'fullBtn'){

								if(parseFloat(duration) > parseFloat(res.user_bal.initial_bal)  ){
							if(res.without_pay != 1){
								alert('You don\'t have enough leaves.');
								$('#start_date').val('');
								$('#end_date').val('');
								$('#duration').val('');
							}
							}	
						}else{

							if(0.50 > parseFloat(res.user_bal.initial_bal)  ){

								if(res.without_pay != 1){
									alert('You don\'t have enough leaves.');
									$('#start_date').val('');
									$('#end_date').val('');
									$('#duration').val('');
								}
							}
						}
					
						


					}
				});

			/*}else{
				alert('You are not eligible for this leave.');
				$('#start_date').val('');
				$('#end_date').val('');
				$('#duration').val('');

			}*/
		}
	});


	$(".end").on("change", function(event) {

		//alert(54)
		var start = $('#start_date').val();
		var end   = $('#end_date').val();
		var btnId =	$('#btnId').val();
		var leave_id = $('#leave_type').val();

		var endDate 	= new Date($('#end_date').val());
		var currDate	= new Date();
		var subtractDays= currDate.setDate(currDate.getDate()-3);
		var leaveGap 	= subtractDays <= endDate;

		if(leaveGap == true){
			if(btnId == 'multiBtn'){
				if( Date.parse(start) >= Date.parse(end) ){ 

					alert('End date should be greater.');
					$('.end').val('');
					$('#duration').val('');
					$('#count').val('');
					$('.rule_alert').hide();
				
				}else{

					var OneDay	= 1000 * 60 * 60 * 24;
					var first	= new Date(start);
		          	var last	= new Date(end);
		          	
		 			var difference_ms = Math.abs(first - last);
					var count = Math.round(difference_ms/OneDay)+1;
					//console.log(count)
					$.ajax({
						type:'POST',
						url: "{{route('holiday.check')}}",
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						data: {'start': start, 'end': end},
						success:function(res){
							//alert(res)
							if(res != 0 ){
								$('.rule_alert').show();
							}else{
								$('.rule_alert').hide();
							}
							
						}
					})

					if(count == 'NaN'){
						$('#duration').val('');

					}else{
						$('#duration').val(count);

					}
					$.ajax({
						type:'get',
						url: '/balance/',
						data:{'leave_id': leave_id},
						success: function(res){
						
							var duration = $('#duration').val();

							if(parseFloat(duration) > parseFloat(res.user_bal.initial_bal) ){

								if(res.without_pay != 1){

									alert('You don\'t have enough leaves.');
									$('#start_date').val('');
									$('#end_date').val('');
									$('#duration').val('');
									$('.rule_alert').hide();
									
								}
							}
						
						}
					});
					
				}


			}

		}else{
			alert('You are not eligible for this leave.');
			$('#start_date').val('');
			$('#end_date').val('');
			$('#duration').val('');
		}

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

/*******New Code*******/


var leave_id = "{{old('leave_type_id')}}";

if(leave_id != ''){

	leaveIDChange(leave_id);

}



var btnId = "{{old('btnId')}}";

if(btnId !=''){

	btnChange(btnId);
}

$('#multiBtn, #fullBtn, #halfBtn').on('click',function(e){
	e.preventDefault();
	var btnId = $(this).attr('id');
	btnChange(btnId);
})


$('#leave_type').on('change', function(){
	var leave_id = $(this).children("option:selected").val();
	// var name  = $(this).children("option:selected").text();
	// var leaveType = name.trim().toLowerCase();
	leaveIDChange(leave_id);	
	});


function leaveIDChange(leave_id){

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
				}else if(res.min_apply_once > 1.0){

					$('#halfBtn').addClass('d-none');
					$('#fullBtn').addClass('d-none');
					$('#multiBtn').removeClass('d-none');
					$('#btnId').val('multiBtn');
					var btnId = 'multiBtn';
					btnChange(btnId);

				}else{
					checkHalf(res);
				}

			// Employee cant apply leave if he dont have balance

				// if(btnId == 'multiBtn'){
				
				// 	$('#end_date').on('change', function(){

				// 		var duration = $('#duration').val();

				// 		if(duration > res.user_bal.initial_bal ){
				// 			alert('You don\'t have enough leaves.');
				// 			$('#start_date').val('');
				// 			$('#end_date').val('');
				// 			$('#duration').val('');
				// 		}
				// 	});
				// }

				// $('#multiBtn').on('click', function(){

				// 	$('#end_date').on('change', function(){
						
				// 		var duration = $('#duration').val();
				// 		if(duration > res.user_bal.initial_bal  ){
							
				// 			if(res.without_pay == 0){
				// 				alert('You don\'t have enough leaves.');
				// 				$('#start_date').val('');
				// 				$('#end_date').val('');
				// 				$('#duration').val('');
				// 			}
				// 		}
				// 	});

				// });
				// $('#fullBtn').on('click', function(){
				// 	$('#start_date').on('change', function(){

				// 		var duration = $('#duration').val();

				// 		if(duration > res.user_bal.initial_bal  ){
				// 			if(res.without_pay == 0){
				// 				alert('You don\'t have enough leaves.');
				// 				$('#start_date').val('');
				// 				$('#end_date').val('');
				// 				$('#duration').val('');
				// 			}
				// 		}
				// 	});
				// });
				// $('#halfBtn').on('click', function(){
				// 	$('#start_date').on('change', function(){
				// 		var duration = $('#duration').val();
				// 		if(res.user_bal.initial_bal < 0.50 ){

				// 			if(res.without_pay == 0){
				// 				alert('You don\'t have enough leaves.');
				// 				$('#start_date').val('');
				// 				$('#end_date').val('');
				// 				$('#duration').val('');
				// 			}
				// 		}
				// 	});
					
			// });

				if(res.docs_required != null){
					$('#doc_element').removeClass('d-none');
					
				}else{
					$('#doc_element').addClass('d-none');
				}
            }
 		});
	}
}

function btnChange(btnId){
	
	var leave_id = $('#leave_type').val();
	var old_leave_id = "{{old('leave_type_id')}}"

	if(old_leave_id == leave_id){
		$('#start_date').val('{{old('start_date')}}');
		$('#end_date').val('{{old('end_date')}}');
		$('#duration').val('{{old('duration')}}');
	}
	else{
		$('#start_date').val('');
		$('#end_date').val('');
		$('#duration').val('');
	}


	if(btnId == 'multiBtn'){
		$('#multiBtn').addClass('active');
		$('#btnId').val(btnId);
		$('#halfBtn, #fullBtn').removeClass('active');
		$('#btnId').val(btnId);
		$('#endDate').removeClass('d-none');
		$('#checkday').addClass('d-none');

	}

	else if(btnId == 'fullBtn'){
		$('#btnId').val(btnId);
		$('#fullBtn').addClass('active');
		$('#halfBtn, #multiBtn').removeClass('active');
		$('#endDate').addClass('d-none');
		$('#checkday').addClass('d-none');
		

	}else if(btnId == 'halfBtn'){
		$('#btnId').val(btnId);
		$('#halfBtn').addClass('active');
		$('#fullBtn, #multiBtn').removeClass('active');
		$('#endDate').addClass('d-none');
		$('#checkday').removeClass('d-none');

	}
}

function checkHalf(res){  //min apply half
	
	if(res.max_apply_once == 0.5){
		$('#halfBtn').addClass('active');
		$('#fullBtn, #multiBtn').removeClass('active');
		$('#halfBtn').removeClass('d-none');

		//Default values for tab fields as in
		// multiple, full_Day, half_day
		$('#btnId').val('halfBtn');
		var btnId = 'halfBtn';
		btnChange(btnId);
		//hide date box
		$('#endDate').addClass('d-none');
		$('#checkday').removeClass('d-none');

		$('#fullBtn').addClass('d-none');
		$('#multiBtn').addClass('d-none');
	}else if(res.max_apply_once == 1.0){


		/***For buttons***/
		$('#fullBtn').addClass('active');
		$('#halfBtn, #multiBtn').removeClass('active');

		//Default values for tab fields as in
		// multiple, full_Day, half_day
		 $('#btnId').val('fullBtn');
		 var btnId = 'fullBtn';
		btnChange(btnId);
		$('#halfBtn').removeClass('d-none');
		$('#fullBtn').removeClass('d-none');
		$('#multiBtn').addClass('d-none');

		
		//Default fields
		$('#checkday').addClass('d-none');
		$('#endDate').addClass('d-none');

		/***For fields***/
	


	}else if(res.max_apply_once > 1.0){

		/***For buttons***/
		$('#multiBtn').addClass('active');
		$('#halfBtn, #fullBtn').removeClass('active');

		//Default values for tab fields as in
		// multiple, full_Day, half_day
		 $('#btnId').val('multiBtn');
		 var btnId = 'multiBtn';
		btnChange(btnId);


		$('#halfBtn').removeClass('d-none');
		$('#fullBtn').removeClass('d-none');
		$('#multiBtn').removeClass('d-none');
	}else {

		//Default values for tab fields as in
		// multiple, full_Day, half_day
		$('#btnId').val('multiBtn');
		var btnId = 'multiBtn';
		
		btnChange(btnId);
		$('#halfBtn').removeClass('d-none');
		$('#fullBtn').removeClass('d-none');
		$('#multiBtn').removeClass('d-none');
	}	
}
 
function checkOnce(res){ //min apply one
	if(res.max_apply_once == 1.0){

		//Default values for tab fields as in
		// multiple, full_Day, half_day
		
		var btnId = $('#btnId').val('multiBtn');
		btnChange(btnId);
		$('#halfBtn').addClass('d-none');
		$('#fullBtn').removeClass('d-none');
		$('#multiBtn').addClass('d-none');
	}else {

		//Default values for tab fields as in
		// multiple, full_Day, half_day
		var btnId = $('#btnId').val('multiBtn');
		btnChange(btnId);
		$('#halfBtn').addClass('d-none');
		$('#fullBtn').removeClass('d-none');
		$('#multiBtn').removeClass('d-none');
	}	
}

/*});*/
</script>
@endsection
