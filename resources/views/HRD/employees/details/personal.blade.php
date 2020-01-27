@extends('layouts.master')
@push('styles')
	<script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
@php
	//$emp_titles = array('Mr.', 'Mrs.', 'Ms.');
	$blood_groups	= array('O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-');
	$castes			= array('General', 'OBC', 'SC', 'ST');
	$religions		= array('Hindu', 'Muslim', 'Christian', 'Sikh', 'Jain');
	$nationalities	= array('Indian', 'Other');
@endphp
<main class="app-content">
	@include ('HRD/employees/tabs')
	<div style="margin-top: 1.5rem; padding: 1.5rem; border: 1px solid grey;">
		@if($message = Session::get('success'))
		<div class="alert alert-success alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>
			{{$message}}
		</div>
		@endif
		<div id="form-area">
				<form action="{{route('employees.personal', ['id'=>$employee->id])}}" method="POST" enctype="multipart/form-data">
					@csrf
				<div class="container-fluid">
					<div class="row">
						 
						<div class="col-6 form-group">
							<label for="">Full Name</label>
								<input type="text" class="form-control" name="full_name" value="{{old('full_name', $employee->emp_name)}}" />
							@error('full_name')
			                <span class="text-danger" role="alert">
			                    <strong>{{ $message }}</strong>
			                </span>
			            	@enderror
						</div>
						<div class="col-6 form-group">
							<label for="">Date of Birth</label>
							<input type="text" name="emp_dob" class="form-control datepicker" value="{{old('emp_dob',$employee->emp_dob)}}" autocomplete="off">
							@error('emp_dob')
			                  <span class="text-danger" role="alert">
			                      <strong>{{ $message }}</strong>
			                  </span>
			              	@enderror
						</div>
						<div class="col-6 form-group">
							<label for="name"><b>Gender</b> </label>
							<div class="input-group">
								<div class="input-group-prepend mt-1">
									<div class="animated-radio-button">
						              <label>
						                <input type="radio" value="M" name="emp_gender" class="mt-1 mr-1" {{old('emp_gender',$employee->emp_gender) == 'M' ? 'checked' : ''}} ><span class="label-text">Male</span>
						              </label>
						              <label class="ml-3">
						                <input type="radio" value="F" name="emp_gender" class="mt-1 mr-1 ml-3" {{old('emp_gender',$employee->emp_gender) == 'F' ? 'checked' : ''}}><span class="label-text">Female</span>
						              </label>
						              <label class="ml-3">
						                <input type="radio" value="O" name="emp_gender" class="mt-1 mr-1 ml-3" {{old('emp_gender',$employee->emp_gender) == 'O' ? 'checked' : ''}} ><span class="label-text">Other</span>
						              </label>
						            </div>
								</div>
							</div>							
							@error('emp_gender')
		                    <span class="text-danger" role="alert">
		                        <strong>{{ $message }}</strong>
		                    </span>
		                	@enderror
						</div>
						<div class="col-6 form-group">
							<div class="col-4">
							<label for="">Blood Group</label>
							<select name="blood_group" class="custom-select form-control">
									@foreach($blood_groups as $row)
										<option value="{{$row}}" {{old('blood_group',$employee->blood_grp) == $row ? 'selected' : ''}} >
											{{ $row }}
										</option>
									@endforeach
							</select>
							@error('blood_group')
				                  <span class="text-danger" role="alert">
				                      <strong>{{ $message }}</strong>
				                  </span>
				              @enderror
				            </div>
						</div>
					</div>
					<br>
					<h5>CONTACT INFORMATION</h5><hr>
					<div class="row">
						<div class="col-6 form-group">
							<label for="">Contact Number</label>
							<input type="text" name="contact_number" class="form-control" value="{{old('contact_number',$employee->contact)}}">
							@error('contact_number')
				                <span class="text-danger" role="alert">
				                	<strong>{{ $message }}</strong>
				            	</span>
				            @enderror
						</div>
						<div class="col-6 form-group">
							<label for="">Alternate Contact Number</label>
							<input type="text" name="alternate_contact_number" class="form-control" value="{{old('alternate_contact_number',$employee->alt_contact)}}">
							@error('alternate_contact_number')
				                <span class="text-danger" role="alert">
				                  <strong>{{ $message }}</strong>
				                </span>
				              @enderror
						</div>
						<div class="col form-group">
							<label for="email">Email</label>
							<input type="email" name="email" class="form-control" value="{{old('email',$employee->email)}}" id="email">
							@error('email')
				            	<span class="text-danger" role="alert">
				                	<strong>{{ $message }}</strong>
				                </span>
				            @enderror
						</div>
						<div class="col-6 form-group">
							<label for="alt-email">Alternate Email</label>
							<input type="email" name="alternate_email" class="form-control" value="{{old('alternate_email',$employee->alt_email)}}" checked="" id="alt-email">
							@error('alternate_email')
				                <span class="text-danger" role="alert">
				                  <strong>{{ $message }}</strong>
				                </span>
				              @enderror
						</div>
						
						<div class="col-6 form-group">
							<label>Current Residence</label>
							<textarea onkeydown="match_addr('curr')" name="curr_addr" id="curr_addr" class="form-control" cols="30" rows="5">{{$employee->curr_addr}}</textarea>
							@error('curr_addr')
			                  <span class="text-danger" role="alert">
			                      <strong>{{ $message }}</strong>
			                  </span>
			              	@enderror
						</div>
						<div class="col-6 form-group">
							<label>Permanent Residence</label>
							<textarea onkeydown="match_addr('perm')" name="perm_addr" class="form-control" id="perm_addr" cols="30" rows="5">{{$employee->perm_addr}}</textarea>
							@error('perm_addr')
				                <span class="text-danger" role="alert">
				                      <strong>{{ $message }}</strong>
				                </span>
			              	@enderror
						</div>
					</div>
					<div class=" custom-checkbox" >
						{{-- <input type="checkbox" class="custom-control-input" id="check-address" 
						@if($employee->curr_addr==$employee->perm_addr) checked @endif >
						<label class="custom-control-label" for="check-address">Permanent Residence same as current</label> --}}
						<div class="animated-checkbox">
			            	<label>
			                	<input type="checkbox" id="check-address" @if($employee->curr_addr==$employee->perm_addr) checked @endif>
			                	<span class="label-text">Permanent Residence same as current</span>
			            	</label>
			            </div>
					</div>
					<hr/>
					<div class="row">
						<div class="col-12 form-group text-center">
							<button class="btn btn-info btn-sm" style="width: 20%">Update</button>
							<a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 20%">Cancel</a>
						</div>
					</div>
					<input type="hidden" name="form_type" id="form_type" value="basic">
				</div>
			</form>
		</div>
	</div>
	<div class="img_parent d-none">
		<img src="{{asset('images/loading1.gif')}}" alt="">
	</div>
	{{-- <div class="col-2 form-group">
							<label for="">Title</label>
							<select name="emp_title" class="form-control">
									@foreach($emp_titles as $row)
										<option value="{{$row}}" {{old('emp_title',(explode(' ', $employee->emp_name, 2))[0]) == $row ? 'selected' : ''}} >
											{{ $row }}
										</option>
									@endforeach
							</select>
							@error('emp_title')
			                <span class="text-danger" role="alert">
			                    <strong>{{ $message }}</strong>
			                </span>
			            	@enderror
						</div>  --}}
						{{-- <div class="col-4 form-group">
							<label for="">Gender</label>
							<br>
							<div class="row">
								<input type="radio" class="mr-2 mt-1" name="emp_gender" value="M" autocomplete="off" {{old('emp_gender',$employee->emp_gender) == 'M' ? 'checked' : ''}}
									> Male
									<input type="radio" 
									class="mr-2 mt-1 ml-3"
									name="emp_gender" 
									value="F" 
									autocomplete="off"
									{{old('emp_gender',$employee->emp_gender) == 'F' ? 'checked' : ''}}
									> Female
									<input type="radio" 
									class="mr-2 mt-1 ml-3"
									name="emp_gender" 
									value="O" 
									autocomplete="off"
									{{old('emp_gender',$employee->emp_gender) == 'O' ? 'checked' : ''}}
									> Other
							</div>
							@error('emp_gender')
			                <span class="text-danger" role="alert">
			                    <strong>{{ $message }}</strong>
			                </span>
			            	@enderror
						</div> --}}
					{{-- </div>
					<hr/>
					<div class="row"> --}}

</main>

<script type="text/javascript">
	$(document).ready(function(){
		$('.personal').addClass('active');
		$('.datepicker').datepicker({
			orientation: "bottom",
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true
		});

		  $('#check-address').click(function(){
		    if($('#check-address').is(':checked')){
		    	var curr_addr = $('#curr_addr').val();
		    	$('#perm_addr').val(curr_addr);
		    } else {
		      $('#perm_addr').val('');
		    };
		  });
	});
	function match_addr(type){
			var curr_addr = $('#curr_addr').val();
			var perm_addr = $('#perm_addr').val();
			if(curr_addr == perm_addr){
        $("#check-address").prop("checked", true);
			}else{
				 $("#check-address").prop("checked", false);
			}
	}

</script>
@endsection

