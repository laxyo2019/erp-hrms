{{-- Created by kishan developer............ --}}

@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
@include ('HRD/employees/view-tabs')
	{{-- <div style="margin-top: 1.5rem; padding: 1.5rem; ">
		<div class="">
  			<div class="col-md-12">
    			<div class="tile">
	        		<div class="container-fluid">
						<div id="form-area">
							@foreach($employee->documents as $emp_documents)
	              				<div class="row col-12">
	                				<div class="col">
	                					<div class="form-group">
											<label for=""><b>Document Title : </b></label>
												<td>{{$emp_documents['doctypemast']->name}}</td>
										</div>
									</div>
									@can('download documents')
										<div class="col">
										<div class=" form-group">
											<label for=""><b>File : </b></label>
											<td><a href="{{ route('employees.download', ['db_table'=>'emp_docs', 'id'=>$emp_documents->id]) }}" ><i class="fa fa-arrow-down"></i> Download</a></td>
										</div>
									</div>
									@endcan
			           				<div class="col">
				              			<div class=" form-group">
											<label for=""><b>Status : </b></label>
											<td>{{ $emp_documents->doc_status }}</td>
										</div>
									</div>
									<div class="col">
										<div class=" form-group">
											<label for=""><b>Remark : </b></label>
											<td>{{ $emp_documents->remark }}</td>
										</div> 
			            			</div>
			          			</div> 
			          			<hr><br>   
			          		@endforeach  
			        	</div>
            		</div>
          		</div>
        	</div>
      	</div>
  	</div> --}}
  	<div class="row" style="margin-top: 1rem; padding: 1.5rem;">
      <div class="col-md-12 col-xl-12">
        <div class="card body">
          
          <div class="card-body table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr class="text-center">
                  <th>#</th>
                  <th>Document Title</th>
                  <th>Document</th>
                  <th>Status</th>
                  <th>Remark</th>
                </tr>
              </thead>
              <tbody>
                @php $count = 0; @endphp
              @foreach($employee->documents as $emp_documents)
              <tr class="text-center">
                <td>{{++$count}}</td>
                <td>{{$emp_documents['doctypemast']->name}}</td>
                <td><a href="{{ route('employees.download', ['db_table'=>'emp_docs', 'id'=>$emp_documents->id]) }}" ><i class="fa fa-arrow-down"></i> Download</a></td>
                <td>{{ $emp_documents->doc_status }}</td>
                <td>{{ $emp_documents->remark }}</td>
              </tr>
              @endforeach
              </tbody>
            </table>
          </div>
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


