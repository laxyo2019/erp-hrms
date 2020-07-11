@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	
	<div style=" padding: 1.5rem; border: 1px solid white;background: white">
			<h1 style="font-size: 24px">Generate No Dues Request
				<a href="{{ route('no-dues-request.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Back</a>
		</h1>
		<div>
	    </div>
		@if($request->emp_hod != 0 )
		<form action="{{route('no-dues-request.store')}}" method="POST" >
			@csrf
		@endif
			<h5>Employee Detail</h5><hr>
			<div class="row">
				<div class="col-6 form-group">
					<label for="">Employee Name</label>
					<input type="text" class="form-control" name="emp_name" value=" {{old('emp_name' , $emp->emp_name )}} " readonly="">
					
				</div>
				<div class="col-6 form-group">
					<label for="emp_code">Employee Code</label>
					<input type="text" class="form-control" name="emp_code" value=" {{old('emp_code' , $emp->emp_code )}} " readonly="">
					@error('emp_code')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
			</div>
			<div class="row">
				<div class="col-6 form-group ">
					<label for="">Date of Joinning</label>
					<input type="text" class="form-control datepicker" name="date_join" value="{{-- {{$request->interest_rate}} --}}" id="date_join">
					@error('date_join')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>	
				<div class="col-6 form-group ">
					<label for="">Date of Leaving</label>
					<input type="text" name="date_leave" class="form-control datepicker" autocomplete="">
					@error('date_leave')
		                  <span class="text-danger" role="alert">
		                      <strong>{{ $message }}</strong>
		                  </span>
		              @enderror
				</div>
				<div class="col-12 form-group">
					<label for="assets_description">Name of the Assets/Articles 
						@error('assets_description')
				          	<span style="color: red">
								| {{ $message }}
							</span>
				      	@enderror</label>
					<textarea  class="form-control" id="assets_description" name="assets_description" >{{-- {{$request->reason}} --}}</textarea>
				</div>
			</div>
							
			@if($request->emp_hod != 0 )
				<div class="col-12 form-group text-center">
					<button class="btn btn-info btn-sm" style="width: 20%">SAVE</button>
				</div>
			@endif
			@if($request != null)
			<br><h4>Head of Department Approval</h4><hr>
			<table class="table table-striped table-hover table-bordered" id="CandidatesTable">
				<thead class="thead-dark">
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Head of Department</th>
						<th class="text-center">Department</th>
						{{-- @ability('hrms_admin', 'Hrms-manage-loan-request') --}}
							<th class="text-center">Status</th>
						{{-- @endability --}}
					</tr>
				</thead>
				@php $count = 0; @endphp
				<tbody id="experiencesTbody">
					<tr class="text-center">
						<td>{{++$count}}</td>
						<td>{{strtoupper($emp_hod->emp_name)}}</td>
						<td>Employee's Department Head ({{strtoupper($emp_hod['department']->name)}})</td>
						<td>Pending</td>
					</tr>
					@foreach($hod as $hod)
						<tr class="text-center">
							<td>{{++$count}}</td>
							<td>{{strtoupper($hod['employee']->emp_name)}}</td>
							<td>{{ucwords($hod['employee']->emp_name)}} ({{strtoupper($hod['department']->name)}})</td>
							<td>Pending</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			@endif
			</div>		
			</div>
			<br>
		{{-- @if($request->hr_approval != 0 ) --}}
			</form>
		{{-- @endif --}}
	</div>
</main>

<script type="text/javascript">
	$('.datepicker').datepicker({
		orientation: "bottom",
		format: "mm-dd-yyyy",
		autoclose: true,
		todayHighlight: true
	});

</script>

@endsection
