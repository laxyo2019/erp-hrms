@extends('layouts.master')
@section('content')
@php
	$blood_groups	= array('O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-');
	$castes			= array('General', 'OBC', 'SC', 'ST');
	$religions		= array('Hindu', 'Muslim', 'Christian', 'Sikh', 'Jain');
	$nationalities	= array('Indian', 'Other');
@endphp
<main class="app-content ">
	<div style="padding: 1.5rem;" class="tile">
		@include ('HRD/employees/tabs')<hr>
		@if($message = Session::get('success'))
		<div class="alert alert-success alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>
			{{$message}}
		</div>
		@endif
		<div id="form-area">
			<form action="{{route('employees.personal', ['id'=>$employee->user_id])}}" method="POST" enctype="multipart/form-data">
					@csrf
				<div class="container-fluid">
					<div class="row">
						
						<div class="row col-8" >
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
								<label for="emp_father">Father's Name</label>
									<input type="text" class="form-control" name="emp_father" value="{{old('emp_father', $employee->emp_father)}}" />
								@error('emp_father')
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
						<div class="col-6">
							<label for="">Marital Status</label>
							<select name="marital_status" class="custom-select form-control">
									@foreach($meta['maritalsts'] as $row)
										<option value="{{$row->name}}" {{old('maritalsts',$employee->marital_status) == $row->name ? 'selected' : ''}} >
											{{ ucwords($row->name) }}
										</option>
									@endforeach
							</select>
							@error('maritalsts')
				                  <span class="text-danger" role="alert">
				                      <strong>{{ $message }}</strong>
				                  </span>
				              @enderror
				            </div>
				           
						<div class="col-6 form-group">
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
						</div>
						<div class="row col-4">
							@if(empty($employee->emp_img))
								<label for="file_path">Profile Image</label>
	    						<input type="file" name="file_path" class="form-group-file" id="file_path" value="{{ old('file_path')}}">
	    						@error('file_path')
								<span class="text-danger" role="alert">
									<strong>* {{ $message }}</strong>
								</span>
								@enderror
							@else
							<div align="right">
								<img src="{{asset('storage/'.trim($employee->emp_img, 'public'))}}" height="180" width="180" class="">
								<div class="col-8">
								<input type="file" name="file_path" class="form-group-file" id="file_path" value="{{ old('file_path')}}">
								</div>
							</div>
							@endif
						</div>
					</div>
					<br>
					<h5>CONTACT INFORMATION</h5><hr>
					<div class="row">
						<div class="col-6 form-group">
							<label for="comp_contact">Contact No. ( Provided by Company )</label>
							<input type="text" name="comp_contact" class="form-control" value="{{old('comp_contact',$employee->comp_contact)}}">
							@error('comp_contact')
				                <span class="text-danger" role="alert">
				                	<strong>{{ $message }}</strong>
				            	</span>
				            @enderror
						</div>
						<div class="col-6 form-group">
							<label for="personal_contact">Contact No. ( Personal )</label>
							<input type="text" name="personal_contact" class="form-control" value="{{old('personal_contact',$employee->personal_contact)}}">
							@error('personal_contact')
				                <span class="text-danger" role="alert">
				                  <strong>{{ $message }}</strong>
				                </span>
				              @enderror
						</div>
						<div class="col form-group">
							<label for="comp_email">Email ( Provided by Company )</label>
							<input type="comp_email" name="comp_email" class="form-control" value="{{old('email',$employee->comp_email)}}" id="comp_email">
							@error('comp_email')
				            	<span class="text-danger" role="alert">
				                	<strong>{{ $message }}</strong>
				                </span>
				            @enderror
						</div>
						<div class="col-6 form-group">
							<label for="alt-personal_email">Email ( Personal )</label>
							<input type="personal_email" name="personal_email" class="form-control" value="{{old('personal_email',$employee->personal_email)}}" checked="" id="personal_email">
							@error('personal_email')
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
</main>

<script type="text/javascript">
	$('body').on('focus', '.datepicker', function(){
	   $(this).datepicker({
	   		orientation: "auto",
			format: "mm-dd-yyyy",
			autoclose: true,
			todayHighlight: true
	   });
	});

	$(document).ready(function(){
		$('.personal').addClass('active');
		

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

