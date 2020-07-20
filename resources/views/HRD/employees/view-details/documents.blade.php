@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
  	<div class="tile" style="padding: 1.5rem;">
      @include ('HRD/employees/view-tabs')<br>
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
                <td>{{strtoupper($emp_documents->doc_type)}}</td>

                <td><a href="{{ route('employees.download', ['db_table'=>'hrms_emp_docs', 'id'=>$emp_documents->id]) }}" ><i class="fa fa-arrow-down"></i> Download</a></td>
                <td>{{ ucwords($emp_documents->doc_status) }}</td>
                <td>{{ $emp_documents->remarks }}</td>
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


