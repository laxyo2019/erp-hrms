@extends('layouts.master')
@push('styles')
	<script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
	<script src='{{asset('js/select2.min.js')}}' type='text/javascript'></script>
@endpush
@section('content')
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
			<form action="{{route('employees.official', ['id'=>$employee->id])}}" method="POST">
				@csrf
				<div class="container-fluid">
					<div class="row">

						<div class="col-6 form-group">
							<label for="">Company</label>
							<select name="comp_id" class="form-control">
								<option value="">Select Company</option>
									@foreach($meta['comp_mast'] as $company)
										<option value="{{$company->id}}" {{old('comp_id', $employee->comp_id) == $company->id ? 'selected' : ''}} >{{$company->name}}</option>
									@endforeach
							</select>
							@error('comp_id')
				                <span class="text-danger" role="alert">
				                    <strong>{{ $message }}</strong>
				                </span>
				            	@enderror
						</div>
						<div class="col-6 form-group">
							<label for="">Department</label>
							<select name="dept_id" class="form-control">
								<option value="">Select Department</option>
									@foreach($meta['dept_mast'] as $department)
										<option value="{{$department->id}}" {{old('comp_id', $employee->dept_id) == $department->id ? 'selected' : ''}} >{{$department->name}}</option>
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
							<select name="emp_type" id="" class="form-control">
								<option value="">-- Select Type --</option>
								@foreach($meta['emp_types'] as $emp_type)
								<option value="{{$emp_type->id}}" {{old('emp_type', $employee->emp_type) == $emp_type->id ? 'selected' : ''}}>{{$emp_type->name}}</option>
								@endforeach
							</select>
							@error('emp_type')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
							@enderror
						</div>
						<div class="col-6 form-group">
							<label for="">Employee Status</label>
							<select name="emp_status" id="" class="form-control">
								<option value="">-- Select Status --</option>
								@foreach($meta['emp_statuses'] as $emp_status)
								<option value="{{$emp_status->id}}" {{old('emp_status',$employee->emp_status) == $emp_status->id ? 'selected' : ''}}>{{$emp_status->name}}</option>
								@endforeach
							</select>
							@error('emp_status')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
							@enderror
						</div>
						<div class="col-6 form-group">
							<label for="">Joinning Date</label>
							<input type="text" class="form-control datepicker" name="join_dt" value="{{old('join_dt', $employee->leave_dt)}}" autocomplete="off"/>
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
							<label for="">Employee Code</label>
							<input type="text" name="emp_code" value="{{old('emp_code', $employee->emp_code)}}" class="form-control">
						</div>
						<div class="col-6 form-group">
							<label for="emp_grade">Employee Grade</label>
							<select name="emp_grade" class="form-control" id="">
								<option value="">Select Grade</option>	
									@foreach($meta['grade_mast'] as $grades)
										<option value="{{$grades->id}}" {{old('emp_grade',$employee->grade_id) == $grades->id ? 'selected' : ''}}>{{$grades->name}}</option>
									@endforeach
							</select>
						</div>
						<div class="col-6 form-group">
							<label for="designation"><b>Designation</b> </label>
							<select name="designation" class="form-control" id="">
								<option value="">Select designation</option>	
									@foreach($meta['designation'] as $designation)
										<option value="{{$designation->id}}" {{old('designation',$employee->desig_id) == $designation->id ? 'selected' : ''}} >{{$designation->name}}</option>
									@endforeach
							</select>			
						</div>
						<div class="col-6 form-group">
							<label for="name"><b>REPORTS TO</b> </label>
							<select name="reports_to" class="form-control" id="">
								<option value="">Select User</option>	
									@foreach($meta['emp_mast'] as $index)
										<option value="{{$index->id}}" {{old('reports_to',$employee->reports_to) == $index->id ? 'selected' : ''}} {{$index->id == $employee->id ? 'disabled' : ''}}>{{$index->emp_name}}</option>
									@endforeach
							</select>			
						</div>
					</div>
					<br>
					<div><h5>NECESSARY DOCUMENTS</h5></div><hr>
					<div class="row">
						{{-- <div class="col-4 form-group">
							<label for="">Joining Date</label>
							<input type="text" class="form-control datepicker" name="join_date" value="{{old('join_date', $employee->join_dt) }}" autocomplete="off"/>
							
							@error('join_date')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
							@enderror
						</div> --}}						
						{{-- <div class="col-4 form-group">
							<label for="">Employee Designation</label>
							<select name="designation" id="" class="form-control">
								<option value="">Select Designtion</option>
								@foreach($meta['designation'] as $designation)
								<option value="{{$designation->id}}" {{old('emp_type', $employee->desg_id) == $designation->id ? 'selected' : ''}}>{{$designation->name}}</option>
								@endforeach
							</select>
							@error('designation')
							<span class="text-danger" role="alert">
								<strong>* {{ $message }}</strong>
							</span>
							@enderror
						</div> --}}
						<div class="col-6 form-group">
							<label for="">Aadhaar Card</label>
							<input type="text" name="aadhar_no" value="{{old('aadhar_no', $employee->aadhar_no)}}" class="form-control">
						</div>
						<div class="col-6 form-group">
							<label for="">PAN Card</label>
							<input type="text" name="pan_no" value="{{old('pan_no', $employee->pan_no)}}" class="form-control">
						</div>
						<div class="col-6 form-group">
							<label for="">Voter ID</label>
							<input type="text" name="voter_id" value="{{old('voter_id', $employee->voter_id)}}" class="form-control">
						</div>
						
						<div class="col-6 form-group">
							<label for="">Driving License</label>
							<input type="text" name="driv_lic" value="{{old('drive_lic', $employee->driv_lic)}}" class="form-control">
						</div>
					</div>
					<br>
					<div><h5>EMPLOYEE PROVIDENT FUND INFORMATION</h5></div><hr>
					<div class="row">
						<div class="col-6 form-group">
							<label for="">Old PF Number</label>
							<input type="text" name="old_pf" value="{{old('old_pf', $employee->old_pf)}}" class="form-control">
						</div>
						<div class="col-6 form-group">
							<label for="">New PF Number</label>
							<input type="text" name="new_pf" value="{{old('new_pf', $employee->curr_pf)}}" class="form-control">
						</div>
						
						<div class="col-6 form-group">
							<label for="">Old UAN Number</label>
							<input type="text" name="old_uan" value="{{old('old_uan', $employee->old_esi)}}" class="form-control">
						</div> 
						<div class="col-6 form-group">
							<label for="">New UAN Number</label>
							<input type="text" class="form-control" value="{{old('curr_uan', $employee->curr_uan)}}" name="curr_uan">
						</div>
						<div class="col-6 form-group">
							<label for="">Old ESI Number</label>
							<input type="text" name="old_esi" value="{{old('old_esi', $employee->old_esi)}}" class="form-control">
						</div> 
						<div class="col-6 form-group">
							<label for="">New ESI Number</label>
							<input type="text" class="form-control" value="{{old('curr_esi', $employee->curr_esi)}}" name="curr_esi">
						</div>
					</div>
						{{-- <div class="col-4 form-group">
							<label for="">Employee Grade</label>
							<select name="emp_grade" class="select2 form-control">
								<option value="">Select Employee Grade</option>
									@foreach($meta['grade_mast'] as $grades)
										<option value="{{$grades->id}}" {{old('emp_grade', $employee->grade_id) == $grades->id ? 'selected' : ''}} >{{$grades->name}}</option>
									
									@endforeach
							</select>
							@error('comp_id')
				                <span class="text-danger" role="alert">
				                    <strong>{{ $message }}</strong>
				                </span>
				            	@enderror
						</div>
						<div class="col-4 form-group">
							<label for="">Team Lead</label>
							<select name="parent_id" class="select2 form-control">
								<option value="">Select </option>
								@foreach($meta['emp_mast'] as $employeeM)
									<option value="{{$employeeM->id}}" {{old('parent_id', $employee->parent_id) == $employeeM->id ? 'selected': ''}} {{ $employee->id == $employeeM->id ? 'disabled' :''}}>{{$employeeM->emp_name}}</option>
								@endforeach
							</select>
						</div>--}}
					<div class="col-12 form-group text-center">
						<button class="btn btn-info btn-sm" style="width: 20%">Update</button>
						<a class="btn btn-danger btn-sm" style="width: 20%" href="javascript:location.reload()">Cancel</a>
					</div>
				</div>
				<input type="hidden" name="form_type" id="form_type" value="official">
			</form>
		</div>
		
		{{-- <hr>
		<div class="col-4 form-group">
			<h4>Allot leaves to this employee</h4>
			@if($employee->leave_allotted == null)
				<button type="button" class="btn btn-info allot" id="allot">Allot Leave</button>
			@else
				<h5>LEAVE ALLOTTED</h5>
			@endif
		</div> --}}
		
	</div>


	<div class="img_parent d-none">
		<img src="{{asset('images/loading1.gif')}}" alt="">
	</div>
</main>
<script type="text/javascript">
	$(document).ready(function(){
		$('.official').addClass('active');
		$('.datepicker').datepicker({
			orientation: "bottom",
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true
			});

		// Initialize select2
		  $("#reportsTo").select2();

		/*$('#allot').on('click', function(e){
            e.preventDefault();
			$.ajax({
				type: 'POST',
				url: route('alloting.leave', $employee->id)}},
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				success: function(data){
					alert(data);
				}
			});
		});*/

		$(":input").each(function(){
		 var input = $(this); // This is the jquery object of the input, do what you will
		 console.log();
		});
	});
</script>
@endsection
