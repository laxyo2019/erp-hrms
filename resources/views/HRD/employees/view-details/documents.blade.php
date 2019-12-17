{{-- Created by kishan developer............ --}}

@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	@include ('HRD/employees/view-tabs')
	<div style="margin-top: 1.5rem; padding: 1.5rem; border: 1px solid grey;">
		<div class="row mt-2">
  			<div class="col-md-12">
    			<div class="tile">
     				<section class="invoice">
	        			<div class="container-fluid">
							<div id="form-area">
	              			<div class="row col-12">
	                			<div class="col-4">
	                				<div class="form-group">
											@foreach($employee->documents as $emp_documents)
											<label for=""><b>Document Title : </b></label>
											<td>{{$emp_documents['doctypemast']->namer}}</td>
										</div>
										<div class=" form-group">
											<label for=""><b>File : </b></label>
											@can('download documents')
											<td><a href="{{ route('employees.download', ['db_table'=>'emp_docs', 'id'=>$emp_documents->id]) }}" ><i class="fa fa-arrow-down"></i> Download</a></td>
											@endcan
										</div>
	                			</div>
			                  <div class="col-4">
				                	<div class=" form-group">
											<label for=""><b>Status : </b></label>
											<td>{{ $emp_documents->doc_status }}</td>
										</div>
										<div class=" form-group">
											<label for=""><b>Remark : </b></label>
											<td>{{ $emp_documents->remark }}</td>
										</div> 
			                  </div>
			               </div>      
			        		 </div>
			        		 @endforeach
              		</div>
            	</section>
          	</div>
        	</div>
      </div>
   </main>
<script>
$(document).ready(function(){
	$('.documents').addClass('active');
});
</script>
@endsection


