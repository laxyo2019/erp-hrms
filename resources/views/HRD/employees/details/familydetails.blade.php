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
		<form action="{{ route('employees.familydetails', ['user_id' => $employee->user_id]) }}" method="POST"  enctype="multipart/form-data">
			@csrf
			<div class="row">
				
				<div class="col-6 form-group">
				<label for="">Name</label>
				<input type="text" class="form-control" name="name" value="{{ old('name') }}">
				@error('name')
	         	<span class="text-danger" role="alert">
	            <strong>* {{ $message }}</strong>
	          	</span>
		      	@enderror
					</div>

				<div class="col-6 form-group">
					<label for="">Relation</label>
					<input type="text" class="form-control" name="relation" value="{{old('relation')}}">
					@error('relation')
	          <span class="text-danger" role="alert">
	            <strong>* {{ $message }}</strong>
	          </span>
	      	@enderror
				</div>
				
				<div class="col-6 form-group">
					<label for="">Aadhar ID</label>
					<input type="text" class="form-control" name="aadhar_id" value="{{ old('aadhar_id')}}" id="aadhar_id">
					@error('aadhar_id')
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
				
				<div class="col-12 form-group text-center"><br><br>
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
		      <th>Name</th>
		      <th>Relation</th>
		      <th>Aadhar ID</th>
		      <th>Document ( Aadhar Card )</th>
		      <th class="text-center">Actions</th>
		    </tr>
		  </thead>
		  <tbody id="familyTbody">
		  	{{-- {{dd($employee['family'])}} --}}
		  	@php $count = 1; @endphp
		  	@foreach($employee['family'] as $row)

		  		<tr>
		  			<td>{{$count++}}</td>
		  			<td>{{$row->name}}</td>
		  			<td>{{$row->relation}}</td>
		  			<td>{{$row->aadhar_id}}</td>	
		  			{{-- @can('download documents')	 --}}
		  			<td>
		  				@if($row->file_path != null)
						<a href="{{route('employees.download', ['db_table' => 'hrms_family_details', $row->id])}}"><i class="fa fa-arrow-down" >
						</i> Download</a>
						@endif
					</td>
		  			{{-- @endcan --}}
		  			 <td >
                  <div class="row">
                  <div class="col" align="right">
					<button class="btn btn-sm btn-success modalFamily" data-id="{{$row->id}}" >EDIT
					</button>
				</div>
				<div >
					{{-- Modal --}}
					<div class="modal fade" id="familyModal" role="dialog">
					     <div class="modal-dialog modal-lg" >
					    	<div class="modal-content" >
					        	<div class="modal-header">
					        		<h4 class="modal-title">Family Member</h4>
					        	</div>
					        	<div class="modal-body table-responsive" id="modalTable" style="background: #f4f2f2">
					        	</div>
					        	 <div class="modal-footer">
					          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
					        </div>
					        </div>
					    </div>
					</div>
				</div>
                  <div  class="col" align="left">
                    <form  action="#" method="POST" id="delform_{{ $row->id}}">
                      @csrf
                      @method('DELETE')
                      <a href="javascript:$('#delform_{{ $row->id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">DELETE</a>
                      </form>
                    </div>
                    </div>
                </div>
                  </td>

		  		</tr>
		  	@endforeach
		  </tbody>
		</table>
	</div>
</main>
<script>
$(document).ready(function(){
	$('.familydetails').addClass('active');

	$('.modalFamily').on('click', function(e){
		e.preventDefault();

		var member_id = $(this).data('id');
		$.ajax({
			type: 'GET',
			url: "/familydetails/"+member_id+"/edit",
			success:function(res){
				
				$('#modalTable').empty().html(res);
				$('#familyModal').modal('show');
			}

		});
	})

	$('#aadhar_id').prop('maxlength', 12);


});
</script>
@endsection
