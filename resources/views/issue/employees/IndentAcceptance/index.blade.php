@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div style=" padding: 1.5rem; border: 1px solid white;background: white">
			<h1 style="font-size: 24px">Indent Acknowledgement
				 <button type="button" class="btn btn-success btn-sm modalCreate" id="generateIndent" data-id="{{Auth::id()}}" data-toggle="modal" data-target="#exampleModal"><span class="fa fa-plus "></span>request</button>
				{{-- Model --}}
				<div class="modal fade" id="reqModal" role="dialog">
				  <div class="modal-dialog modal-lg">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h4 class="modal-title">Raise Indent Request</h4>
				      </div>
				      <div class="modal-body table-responsive" id="reqDetailTable" style="background: #ececec">
				        	<div class="col-12 form-group">
								<label for="">Description (mention your requirment below)</label>
				        		<textarea  id="desc" class="form-control" ></textarea>
				        	</div>
				        	<div class="col-12 form-group text-center">
								<button id="submitRequest" class="btn btn-info btn-sm" style="width: 20%">SAVE</button>
							</div>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
				      </div>
				    </div>
				  </div>
				</div>
				{{--  --}}
				<a href="{{ route('no-dues-request.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Back</a>
		</h1><hr>
		<div>
			@if($message = Session::get('success'))
				<div class="alert alert-success alert-block">
                	<button type="button" class="close" data-dismiss="alert">×</button>
                	{{$message}}
				</div>
            @endif
	    </div>
			<h5>Employee Detail </h5>
			<div class="row">
				<div class="col-6 form-group">
					<label for="">Employee Name</label>
					<input type="text" class="form-control" name="emp_name" value=" {{old('emp_name' , $emp->emp_name  )}} " readonly="">
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
				<div class="col-6 form-group">
					<label for="emp_code">Department</label>
					<input type="text" class="form-control" name="department" value="{{$emp['department']->name}}" readonly="" >
					@error('emp_code')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
				</div>
			</div>
			<br><h4>Issued Item List</h4><hr>
			<table class="table table-striped table-hover table-bordered" id="CandidatesTable">
				<thead class="thead-dark">
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Serial no.</th>
						<th class="text-center">Name</th>
						<th class="text-center">Model no.</th>
						<th class="text-center">Quantity</th>
						<th class="text-center">Color</th>
						<th class="text-center">Status</th>
					</tr>
				</thead>
				@php $count = 0; @endphp
				<tbody id="experiencesTbody">
					{{-- @foreach($hod_approval as $hod) --}}
						<tr class="text-center">
							<td>{{++$count}}</td>
							<td></td>
							<td></td>
							<td></td>
							<td>{{-- {{strtoupper($hod['employee']->emp_name)}} --}}</td>
							<td>{{-- {{ucwords($hod['employee']->emp_name)}} ({{strtoupper($hod['department']->name)}} --}}</td>
							<td>
								{{-- @if($hod->action == 0)
									<strong style="color: grey;">PENDING</strong>
								@elseif($hod->action == 1)
									<strong style="color: #0cac0c;">APPROVED</strong>
								@elseif($hod->action == 2)
									<strong style="color: #3375ca;">DECLINED</strong>
								@endif --}}
							</td>
						</tr>
					{{-- @endforeach --}}
				</tbody>
			</table>
			{{-- @endif --}}
			</div>		
		</div>
	<br>
</div>
</main>

<script type="text/javascript">
$(document).ready(function(){

  $('#generateIndent').on('click', function(){
	$('#reqModal').modal('show');

  });

  $('#submitRequest').on('click', function(){
  	var description = $('#desc').val();

  	$.ajax({
  		type: 'get',
  		url: '/my-indent.create',
  		success: function(){
  			
  		}
  	})
  });

});
</script>
<style type="text/css">
  .approve
  {
    background: #0cac0c;
    color: white;
  }
  .decline
  {
    background: #ff1414;
    color: white;
  }
 
  .apprv_msg{
    color: #0cac0c;
  }
  .dec_msg{
    color: #ff1414;
  }
  .rev_msg{
    color: #3375ca;
  }

</style>

@endsection
