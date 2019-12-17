{{-- Created by kishan developer............ --}}

@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
@include ('HRD/employees/view-tabs')
  	<div class="row" style="margin-top: 1rem; padding: 1.5rem;">
      <div class="col-md-12 col-xl-12">
        <div class="card body">
          
          <div class="card-body table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr class="text-center">
                  <th>#</th>
                  <th>Document Title</th>
                  @can('download documents')
                    <th>Document</th>
                  @endcan
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
                @can('download documents')
                <td><a href="{{ route('employees.download', ['db_table'=>'emp_docs', 'id'=>$emp_documents->id]) }}" ><i class="fa fa-arrow-down"></i> Download</a></td>
                @endcan
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


