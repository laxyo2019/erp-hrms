@extends('layouts.master')
@section('content')
<main class="app-content ">
	<div style="padding: 1.5rem;" class="tile">
		@include ('HRD/employees/tabs')<br>
		@if($message = Session::get('success'))
			<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>
				{{$message}}
			</div>
		@endif
	<form action="{{route('employees.academics', ['user_id'=>$employee->user_id])}}" method="POST" enctype="multipart/form-data">
		@csrf
		<div class="row">
	    <div class="col-6 form-group">
	    	<label for="">Domain of Study</label>
	    	<input type="text" class="form-control" name="domain_of_study" placeholder="Eg. 10th, 12th, BE, MCA..." value="{{old('domain_of_study',isset($academic->domain_of_study) ? $academic->domain_of_study : '')}}">
	    	@error('domain_of_study')
          <span class="text-danger" role="alert">
            <strong>* {{ $message }}</strong>
          </span>
      	@enderror
	    </div>
	    <div class="col-6 form-group">
	    	<label for="">Name of Board/University</label>
	    	<input type="text" class="form-control" name="board_name" placeholder="Eg. CBSE, RGPV" value="{{old('board_name',isset($academic->name_of_unversity) ? $academic->name_of_unversity : '')}}" />
	    	@error('board_name')
          <span class="text-danger" role="alert">
            <strong>* {{ $message }}</strong>
          </span>
      	@enderror
	    </div>
	    <div class="col-6 form-group">
	    	<label for="">Completed In</label>
	    	<input type="text" class="form-control datepicker" name="year_of_completion" placeholder="Eg. 2016" value="{{old('year_of_completion',isset($academic->completed_in_year) ? $academic->completed_in_year : '')}}"/>
	    	@error('year_of_completion')
          <span class="text-danger" role="alert">
            <strong>* {{ $message }}</strong>
          </span>
      	@enderror
	    </div>
	    <div class="col-6 form-group">
	    	<label for="">Grade or %</label>
	    	<input type="text" class="form-control" name="grade_or_percent" placeholder="" value="{{old('grade_or_percent',isset($academic->grade_or_pct) ? $academic->grade_or_pct : '')}}" />
	    	@error('grade_or_percent')
          <span class="text-danger" role="alert">
            <strong>* {{ $message }}</strong>
          </span>
      	@enderror
	    </div>
	    <div class="col-6 form-group">
	    	<label for="file_path">Upload Documents</label>
	    	<input type="file" class="form-control-file " name="file_path" id="file_path" value="{{ old('file_path') }}">
	    	@error('file_path')
				<span class="text-danger" role="alert">
					<strong> {{ $message }}</strong>
				</span>
			@enderror
	    </div>
	    <div class="col-12 form-group">
	    	<label for="">Special Note</label>
	    	<textarea name="special_note" class="form-control" id="" cols="30" rows="4">{{old('special_note',isset($academic->domain_of_study) ? $academic->domain_of_study : '')}}</textarea>
	    	@error('special_note')
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
		<input type="hidden" id="form_type" value="academics">
	</form>
		<hr>
		<table class="table table-striped table-hover table-bordered">
		  <thead class="thead-dark">
		    <tr>
		      <th>#</th>
		      <th>Domain of Study</th>
		      <th>Name of Board</th>
		      <th>Completed In( Year )</th>
		      <th>Grade</th>
		      {{-- @can('download documents') --}}
		      	<th>Documents</th>
		      {{-- @endcan --}}
		      <th>Special Note</th>
		      <th class="text-center">Actions</th>
		    </tr>
		  </thead>
		  <tbody id="academicsTbody">
		  	@php $count = 1; @endphp
		  	@foreach($employee->academics as $row)
		  		<tr>
		  			<td>{{$count++}}</td>
		  			<td>{{$row->domain_of_study}}</td>
		  			<td>{{$row->name_of_unversity}}</td>
		  			<td>{{$row->completed_in_year}}</td>
		  			<td>{{$row->grade_or_pct}}</td>	
		  			{{-- @can('download documents')	 --}}
		  			<td>
		  				@if($row->file_path != null)
						<a href="{{route('employees.download', ['db_table' => 'hrms_emp_academics', $row->id])}}"><i class="fa fa-arrow-down" >
						</i> Download</a>
						@endif
					</td>
		  			{{-- @endcan --}}
		  			<td>{{$row->note}}</td>
		  			<td><form action="{{route('employee.delete_row', ['db_table' => 'hrms_emp_academics', $row->id])}}" method="GET" id="delform_{{$row->id}}">
				<a href="javascript:$('#delform_{{$row->id}}').submit();" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> Delete</a>
				</form></td>

		  		</tr>
		  	@endforeach
		  </tbody>
		</table>
	</div>
</main>
<script type="text/javascript">
	$(document).ready(function(){
		$('.academics').addClass('active');
	});

	$('.datepicker').datepicker({
	orientation: "bottom",
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years",
    autoclose: true

});


</script>
@endsection

