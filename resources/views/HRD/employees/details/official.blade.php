@extends('layouts.master')
@push('styles')
	{{-- <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
	<script src='{{asset('js/select2.min.js')}}' type='text/javascript'></script>--}}
@endpush
@section('content')
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
			<form action="{{route('employees.official', ['id'=>$employee->user_id])}}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="container-fluid">
					<div class="row">
						<div class="col-6 form-group">
							<label for="">Company</label>
							<select name="comp_id" class="form-control" id="company">
								<option value="">Select Company</option>
									@foreach($meta['comp_mast'] as $company)
										<option value="{{$company->id}}" {{old('comp_id', $employee->comp_id) == $company->id ? 'selected' : ''}} >{{ucwords($company->name)}}</option>
									@endforeach
							</select>
							@error('comp_id')
				                <span class="text-danger" role="alert">
				                    <strong>{{ $message }}</strong>
				                </span>
				            @enderror
						</div>
						<div class="col-6 form-group">
							<label for="">Branch</label>
							<select name="branch_id" id="branch" class="form-control">
								@if(!empty($employee->comp_id))
									@foreach($meta['comp_branches'] as $branches)
										<option value="{{$branches->id}}" {{$employee->branch_id == $branches->id ? 'selected' : ''}} >{{ucwords($branches->city)}}</option>
									@endforeach
								@endif
							</select>
							@error('branch_id')
				                <span class="text-danger" role="alert">
				                    <strong>{{ $message }}</strong>
				                </span>
				            	@enderror
						</div>
						<div class="col-6 form-group">
							<label for="">Employee Code</label>
							<input type="text" name="emp_code" 
					value="{{old('emp_code', $employee->emp_code)}}" class="form-control">
						</div>
						<div class="col-6 form-group">
							<label for="emp_grade">Employee Grade</label>
							<select name="emp_grade" class="form-control" id="">
								<option value="">Select Grade</option>	
									@foreach($meta['grade_mast'] as $grades)
										<option value="{{$grades->id}}" {{old('emp_grade',$employee->grade_id) == $grades->id ? 'selected' : ''}}>{{strtoupper($grades->name)}}</option>
									@endforeach
							</select>
						</div>
						<div class="col-6 form-group">
							<label for="designation"><b>Designation</b> </label>
							<select name="designation" class="form-control" id="">
								<option value="">Select designation</option>	
									@foreach($meta['designation'] as $designation)
									<option value="{{$designation->id}}" {{old('designation',$employee->desg_id) == $designation->id ? 'selected' : ''}} >{{ucwords($designation->name)}}</option>
									@endforeach
							</select>
						</div>
						<div class="col-6 form-group">
							<label for="">Department</label>
							<select name="dept_id" class="form-control">
								<option value="">Select Department</option>
									@foreach($meta['dept_mast'] as $department)
										<option value="{{$department->id}}" {{old('comp_id', $employee->dept_id) == $department->id ? 'selected' : ''}} >{{ucwords($department->name)}}</option>
									@endforeach
							</select>
							@error('comp_id')
				                <span class="text-danger" role="alert">
				                    <strong>{{ $message }}</strong>
				                </span>
				            	@enderror
						</div>
						<div class="col-6 form-group">
							<label for="">Employee Type</label>
							<select name="emp_type" id="emp_type" class="form-control">
								<option value=""> Select Type </option>
								@foreach($meta['emp_types'] as $emp_type)
								<option value="{{$emp_type->id}}" {{old('emp_type', $employee->emp_type) == $emp_type->id ? 'selected' : ''}}>{{ucwords($emp_type->name)}}</option>
								@endforeach
							</select>
							@error('emp_type')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
							@enderror
						</div>
						<div class="col-6 form-group">
							<label for="name"><b>TO REPORT</b> </label>
							<select name="reports_to" class="form-control" id="">
								<option value="">Select User</option>
									@foreach($meta['emp_mast'] as $index)
										<option value="{{$index->user_id}}" {{old('reports_to',$employee->reports_to) == $index->user_id ? 'selected' : ''}} {{$index->user_id == $employee->user_id ? 'disabled' : ''}}>{{ucwords($index->emp_name)}}</option>
									@endforeach
							</select>			
						</div>
						<div class="col-6 form-group" id="empStatus" style="display: none">
							<label for="">Employee Status</label>
							<select name="emp_status" id="" class="form-control">
								<option value="">Select Status </option>
								@foreach($meta['emp_statuses'] as $emp_status)
								<option value="{{$emp_status->id}}" {{old('emp_status',$employee->emp_status) == $emp_status->id ? 'selected' : ''}}>{{ucwords($emp_status->name)}}</option>
								@endforeach
							</select>
							@error('emp_status')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
							@enderror
						</div>
						<div class="col-6 form-group" >
							<label for="">Head of Department (Hod)</label>
							<select name="emp_hod" class="form-control">
								<option value="">Select Employee </option>
								@foreach($meta['emp_mast'] as $index)
								<option value="{{$index->user_id}}" {{old('emp_hod', $employee->emp_hod) == $index->user_id ? 'selected' : ''}}>{{ucwords($index->emp_name)}}</option>
								@endforeach
							</select>
							@error('emp_hod')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>
					<br>
					<div><h5>EMPLOYEE WORKING PERIOD</h5></div><hr>
					<div class="row">
						<div class="col-6 form-group">
							<label for="">Joinning Date</label>
							<input type="text" class="form-control datepicker" name="join_dt" value="{{old('join_dt', $employee->join_dt)}}" autocomplete="off"/>
							@error('join_dt')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
							@enderror
						</div>
						<div class="col-6 form-group">
							<label for="">Leave Date</label>
							<input type="text" class="form-control datepicker" name="leave_date" value="{{old('leave_date', $employee->leave_dt)}}" autocomplete="off"/>
							@error('leave_date')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
							@enderror
						</div>
						<div class="col-6 form-group">
							<label for="">Re-joinning Date</label>
							<input type="text" class="form-control datepicker" name="rejoin_date" value="{{old('rejoin_date', date('Y-m-d', strtotime($employee->rejoin_date)))}}" autocomplete="off"/>
							@error('rejoin_date')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
							@enderror
						</div>
						<div class="col-6 form-group">
							<label for="">Re-Leave Date</label>
							<input type="text" class="form-control datepicker" name="releave_date" value="{{old('releave_date', date('Y-m-d', strtotime($employee->releave_date)))}}" autocomplete="off"/>
							@error('releave_date')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>
					<br>
					<div><h5>NECESSARY DOCUMENTS</h5></div><hr>
					<div class="row">
						<div class="col-6 form-group">
							<label for="">Aadhaar Card</label>
							<input type="text" name="aadhar_no" value="{{old('aadhar_no', $employee->aadhar_no)}}" class="form-control" id="aadhar_no">
						</div>
						<div class="col-6 form-group">
							<label for="">PAN Card</label>
							<input type="text" name="pan_no" value="{{old('pan_no', $employee->pan_no)}}" class="form-control" id="pan_no">
						</div>
						<div class="col-6 form-group">
							<label for="">Voter ID</label>
							<input type="text" name="voter_id" value="{{old('voter_id', $employee->voter_id)}}" class="form-control" id="voter_id">
						</div>
						
						<div class="col-6 form-group">
							<label for="">Driving License</label>
							<input type="text" name="driv_lic" value="{{old('drive_lic', $employee->driv_lic)}}" class="form-control">
						</div>
							<div class="col-6 form-group">
							<label for="passport_id">Passport ID</label>
							<input type="text" name="passport_id" value="{{old('passport_id', $employee->passport_id)}}" class="form-control">
						</div> 
						{{-- 
						@if(empty($employee->file_path))
						<div class="col-6 form-group">
					    	<label for="file_path">Upload Passport</label>
					    	<input type="file" class="form-control-file " name="file_path" id="file_path" value="{{ old('file_path') }}">
					    	@error('file_path')
								<span class="text-danger" role="alert">
									<strong> {{ $message }}</strong>
								</span>
							@enderror
					    </div>
					    @else

					    	<div class="col-6 form-group">
							<label for="">Passport </label>
							<input type="text" value="Passport Uploaded" class="form-control" disabled="">
						</div>

					    @endif --}}
					</div>
					<br>
					<div><h5>EMPLOYEE PROVIDENT FUND INFORMATION</h5></div><hr>
					<div class="row">
						<div class="col-6 form-group">
							<label for="old_pf">Old PF Number</label>
							<input type="text" name="old_pf" value="{{old('old_pf', $employee->old_pf)}}" class="form-control" id="old_pf">
							@error('old_pf')
			                	<span class="text-danger" role="alert">
			                    	<strong>{{ $message }}</strong>
			                	</span>
			            	@enderror
						</div>
						<div class="col-6 form-group">
							<label for="new_pf">New PF Number</label>
							<input type="text" name="new_pf" value="{{old('new_pf', $employee->curr_pf)}}" class="form-control" id="new_pf">
							@error('new_pf')
			                	<span class="text-danger" role="alert">
			                    	<strong>{{ $message }}</strong>
			                	</span>
			            	@enderror
						</div>
						
						<div class="col-6 form-group">
							<label for="old_uan">Old UAN Number</label>
							<input type="text" name="old_uan" value="{{old('old_uan', $employee->old_uan)}}" class="form-control" id="old_uan">
							@error('old_uan')
			                <span class="text-danger" role="alert">
			                    <strong>{{ $message }}</strong>
			                </span>
			            	@enderror
						</div> 
						<div class="col-6 form-group">
							<label for="curr_uan">New UAN Number</label>
							<input type="text" class="form-control" value="{{old('curr_uan', $employee->curr_uan)}}" name="curr_uan" id="curr_uan">
							@error('curr_uan')
			                	<span class="text-danger" role="alert">
			                    	<strong>{{ $message }}</strong>
			                	</span>
			            	@enderror
						</div>
						<div class="col-6 form-group">
							<label for="old_esi">Old ESI Number</label>
							<input type="text" name="old_esi" value="{{old('old_esi', $employee->old_esi)}}" class="form-control" id="old_esi">
							@error('old_esi')
			                	<span class="text-danger" role="alert">
			                    	<strong>{{ $message }}</strong>
			                	</span>
			            	@enderror
						</div> 
						<div class="col-6 form-group">
							<label for="curr_esi">New ESI Number</label>
							<input type="text" class="form-control" value="{{old('curr_esi', $employee->curr_esi)}}" name="curr_esi" id="curr_esi">
							@error('curr_esi')
			                	<span class="text-danger" role="alert">
			                    	<strong>{{ $message }}</strong>
			                	</span>
			            	@enderror
						</div>
					</div>
					<div class="col-12 form-group text-center">
						<button class="btn btn-info btn-sm" style="width: 20%">Update</button>
						<a class="btn btn-danger btn-sm" style="width: 20%" href="javascript:location.reload()">Cancel</a>
					</div>
				</div>
				<input type="hidden" name="form_type" id="form_type" value="official">
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
	$('.official').addClass('active');
	

	$('#emp_type').change(function(){
		//$('#emp_type option:selected').text();	
		
		var drop = $(this).children("option:selected").text().toLowerCase();
		
		if(drop == 'on roll'){

			$('#empStatus').show();	
		}
	})
	
	// Initialize select2
	//$("#reportsTo").select2();

	/**Select Branch for companies**/

	$('#company').change(function(){

		var comp_id = $(this).children("option:selected").val();
		$.ajax({
			type: 'POST',
			url: '{{route('company.branches')}}',
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {'comp_id':comp_id},
			success:function(res){
				if(res){
					$('#branch').empty();
					$("#branch").append('<option>Select</option>');
					$.each(res,function(key,value){
						$('#branch').append('<option value="'+value+'">'+key+'</option>');
					});
				}else{
					$('#branch').empty();
				}
			}
		});
	});

	//Character limit for various fields

	$('#aadhar_no, #old_uan, #curr_uan').prop('maxlength', 12);
	$('#old_esi, #curr_esi, #pan_no, #voter_id').prop('maxlength', 10);


});
</script>
@endsection
