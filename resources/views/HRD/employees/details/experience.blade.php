@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
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
			<form action="{{route('employees.experience', ['id'=>$employee->id])}}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="row">
					<div class="col-6 form-group">
						<label for="">Last Company Name</label>
						<input type="text" class="form-control" name="company_name" 
								value="{{old('company_name',isset($exp->comp_name) ? $exp->comp_name : '')}}">
						@error('company_name')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-6 form-group">
							<label for="">Job Type</label>
							<input type="text" class="form-control" name="job_type"
							value="{{old('job_type',isset($exp->job_type) ? $exp->job_type : '')}}">
							@error('job_type')
					          <span class="text-danger" role="alert">
					            <strong>* {{ $message }}</strong>
					          </span>
					      	@enderror
						</div>
					
					<div class="col-6 form-group">
						<label for="">Designation</label>
						<input type="text" class="form-control" name="designation"
						value="{{old('designation',isset($exp->desg) ? $exp->desg : '')}}">
						@error('designation')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-6 form-group">
						<label for="">Monthly CTC</label>
						<input type="text" class="form-control" name="monthly_ctc" value="{{old('monthly_ctc',isset($exp->monthly_ctc) ? $exp->monthly_ctc : '')}}">
						@error('monthly_ctc')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-6 form-group">
						<label for="">Company Location</label>
						<input type="text" class="form-control" name="comp_loc"
						value="{{old('comp_loc',isset($exp->comp_loc) ? $exp->comp_loc : '')}}">
						@error('comp_loc')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-6 form-group">
						<label for="">Company Email</label>
						<input type="email" class="form-control" name="comp_email"
						value="{{old('comp_email',isset($exp->comp_email) ? $exp->comp_email : '')}}">
						@error('comp_email')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-3 form-group">
						<label for="">Start Date</label>
						<input type="text" class="form-control datepicker" name="start_date" value="{{old('start_date',isset($exp->start_dt) ? $exp->start_dt : '')}}" autocomplete="off" id="first_date">
						@error('start_date')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-3 form-group">
						<label for="">End Date</label>
						<input type="text" class="form-control datepicker" name="end_date"
							value="{{old('end_date',isset($exp->end_dt) ? $exp->end_dt : '')}}" autocomplete="off" id="end_date">
						@error('end_date')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-6 form-group">
						<label for="">Total Experience ( In Years )</label>
						<input type="text" class="form-control datepicker" name="total_exp"
							value="{{old('total_exp',isset($exp->total_exp) ? $exp->total_exp : '')}}" autocomplete="off" id="total_exp">
						@error('total_exp')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-6 form-group">
						<label for="">Company Website</label>
						<input type="text" class="form-control" name="comp_website"
						value="{{old('comp_website',isset($exp->comp_website) ? $exp->comp_website : '')}}">
						@error('comp_website')
				          <span class="text-danger" role="alert">
				            <strong>* {{ $message }}</strong>
				          </span>
				      	@enderror
					</div>
					<div class="col-6 form-group">
						<label for="file_path">Upload Documents</label>
    					<input type="file" name="file_path" class="form-control-file" id="file_path" value="{{ old('file_path')}}">
					</div>
					<div class="col-12 form-group">
				    	<label for="">Reason of Leaving</label>
				    	<textarea name="reason_of_leaving" class="form-control" id="" cols="30" rows="4">{{old('reason_of_leaving',isset($academic->domain_of_study) ? $academic->domain_of_study : '')}}</textarea>
				    	@error('reason_of_leaving')
			          <span class="text-danger" role="alert">
			            <strong>* {{ $message }}</strong>
			          </span>
			      	@enderror
				    </div> 
					<div class="col-12 form-group text-center">
						<button class="btn btn-info btn-sm" style="width: 20%">Save</button>
						<a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 20%">Cancel</a>
					</div>
				</div>
				<input type="hidden" id="form_type" value="experiences">
			</form>
			<hr>
			<table class="table table-striped table-hover table-bordered">
				<thead class="thead-dark">
					<tr>
						<th>#</th>
						<th>Company Name</th>
						<th>Job Type</th>
						<th>Monthly CTC</th>
						<th>Start Date</th>
						<th>End Date</th>
						{{-- <th>Certificate</th> --}}
						<th>Reason of Leaving</th>
						<th class="text-center">Actions</th>
					</tr>
				</thead>
				<tbody id="experiencesTbody">
					@foreach($employee->experiences as $exp)
					<tr>
						<td>{{$exp->id}}</td>
						<td>{{$exp->comp_name}}</td>
						<td>{{$exp->job_type}}</td>
						<td>{{$exp->monthly_ctc}}</td>
						<td>{{$exp->start_dt}}</td>
						<td>{{$exp->end_dt}}</td>
						<td>{{$exp->reason_of_leaving}}</td>
						<td class='d-flex' style="border-bottom:none">
							<span>
								<button class="btn btn-sm btn-success modalExp" data-id="{{$exp->id}}"><i class="fa fa-eye text-white" style="font-size: 12px;"></i>
								</button>
								{{-- Modal --}}
								<div class="modal fade" id="expModal" role="dialog">
								     <div class="modal-dialog modal-lg" >
								    	<div class="modal-content" >
								        	<div class="modal-header">
								        		<h4 class="modal-title">Experience</h4>
								        	</div>
								        	<div class="modal-body table-responsive" id="modalTable" style="background: #f4f2f2">
								        	</div>
								        	 <div class="modal-footer">
								          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
								        </div>
								        </div>
								    </div>
								</div>
							</span>
						<span>
						<form action="{{route('employee.delete_row', ['db_table' => 'hrms_emp_exp', $exp->id])}}" method="GET" id="delform_{{$exp->id}}"><a href="javascript:$('#delform_{{$exp->id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash text-white" style="font-size: 12px;"></i></a>
						</form>
					</span>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</main>
<script>
$(document).ready(function(){
	$('.experience').addClass('active');
	$('body').on('focus', '.datepicker', function(){
	   $(this).datepicker({
	   		orientation: "auto",
			format: "mm-dd-yyyy",
			autoclose: true,
			todayHighlight: true
	   });
	});
	$('.modalExp').on('click', function(e){
		e.preventDefault();
		var exp_id = $(this).data('id');
		$.ajax({
			type: 'GET',
			url: "{{route('exp_table')}}?exp_id="+exp_id,
			success:function(res){
				
				$('#modalTable').empty().html(res);
				$('#expModal').modal('show');
			}

		})
	})

	$('.datepicker').on('change', function(){

		var date = new Date($('#first_date').val());
		var diff = new Date(new Date($('#end_date').val()) - date);


		var totalExp = (diff.toISOString().slice(0, 4) - 1970) + "." + (diff.getMonth()) + " years";

		$('#total_exp').val(totalExp);
	})

});
</script>
@endsection
