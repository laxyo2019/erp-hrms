@extends('layouts.master')
@section('content')
<main class="app-content">
@include ('HRD/employees/view-tabs')
<div style="margin-top: 1.5rem; padding: 1.5rem; border: 1px solid grey;">
	<div class="row mt-2">
	  	<div class="col-md-12">
	    	<div class="tile">
				<div class="container-fluid">
					@php $count = 0; @endphp
					@foreach($employee->academics as $row)
						<div class="row mb-3">
			                <span style="color: grey; font-size: 20px; font-weight: bold"><i class="fa fa-globe"></i> Academics History - {{++$count}}</span>
		           		</div><hr>
						
						<div class="row ">
		                	<div class="col-6 form-group">
								<label for=""><b>Domain of Study : </b></label>
								<td>{{empty($row->domain_of_study)?'':ucwords($row->domain_of_study)}}</td>
							</div>
						 	<div class="col-6 form-group">
								<label for=""><b>Name of Board/University : </b></label>
								<td>{{empty($row->name_of_unversity)?'':ucwords($row->name_of_unversity)}}</td>
							</div>                 	
		                	<div class="col-6 form-group">
								<label for=""><b>Completed In : </b></label>
								<td>{{empty($row->completed_in_year)?'':$row->completed_in_year}}</td>
							</div>
							<div class="col-6 form-group">
								<label for=""><b>Grade or % : </b></label>
								<td>{{empty($row->grade_or_pct)?'':$row->grade_or_pct}}</td>
							</div>	
			                	<div class="col-6 form-group">
									<label for=""><b> Documents : </b></label>
									<td><a href="{{route('employees.download', ['db_table' => 'hrms_emp_academics', $row->id])}}"><i class="fa fa-arrow-down" ></i> Download</a></td>
								</div>
							<div class="col-6 form-group">
								<label for=""><b>Special Note : </b></label>
								<td>{{empty($row->note)?'':$row->note}}</td>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
</main>
<script type="text/javascript">
	$(document).ready(function(){
		$('.academics').addClass('active');
	});
</script>
@endsection

