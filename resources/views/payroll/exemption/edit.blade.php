@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div style=" padding: 1.5rem; border: 1px solid white;background: white">
		<h1 style="font-size: 24px">Create Exemption
			<a href="{{ route('chapter6-exemption.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Back</a><hr>
		</h1>
		@if($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				{{$message}}
			</div>
		@endif 
		<form action="{{route('chapter6-exemption.update', $exemption->id)}}" method="POST" >
			@csrf
			@method('PATCH')
			<div class="row">
			<div class="col-6 form-group ">
				<label for="section">Chapter 6 Section</label>
				<select name="section" class="custom-select form-control select2" id="chapt6_sect">
					<option value="">Select Type</option>
						@foreach($sections as $type)
							<option value="{{$type->id}}" {{old('section', $exemption->chapt6_section_id) == $type->id ? 'selected' : ''}}>{{strtoupper($type->name)}}</option>
						@endforeach
				</select>
				@error('section')
	                  <span class="text-danger" role="alert">
	                      <strong>{{ $message }}</strong>
	                  </span>
	              @enderror
			</div>
			<div class="col-6 form-group ">
				<label for="section_head">Section Heads</label>
				<select name="section_head" class="custom-select form-control select2" id="section_head">
					<option value="">Select Type</option>
					@foreach($heads as $head)
						<option value="{{$head->id}}" 
{{old('section_head', $exemption->chapt6_head_id) == $head->id ? 'selected' : ''}}>{{$head->head}}</option>
					@endforeach
				</select>
				@error('section_head')
	                  <span class="text-danger" role="alert">
	                      <strong>{{ $message }}</strong>
	                  </span>
	              @enderror
			</div>
			<div class="col-6 form-group ">
				<label for="emp_name">Employee Name</label>
				<input type="text" class="form-control" name="emp_name" value="{{$exemption->emp_name}}" id="emp_name">
				@error('emp_name')
					<span class="text-danger" role="alert">
						<strong>* {{ $message }}</strong>
					</span>
				@enderror
			</div>
			<div class="col-6 form-group ">
				<label for="emp_code">Employee code</label>
				<input type="text" class="form-control" name="emp_code" value="{{$exemption->emp_code}}" id="emp_code">
				@error('emp_code')
					<span class="text-danger" role="alert">
						<strong>* {{ $message }}</strong>
					</span>
				@enderror
			</div>
			<div class="col-6 form-group ">
				<label for="">Financial Year</label>
				<select name="financial_yr" class="custom-select form-control select2">
					<option value="">Select Type</option>
						@foreach($sections as $type)
							<option value="{{$type->id}}">{{ucwords($type->name)}}</option>
						@endforeach
				</select>
				@error('financial_yr')
	                  <span class="text-danger" role="alert">
	                      <strong>{{ $message }}</strong>
	                  </span>
	              @enderror
			</div>		
			<div class="col-6 form-group ">
				<label for="exempt_amt">Exemption Amount (In INR)</label>
				<input type="text" class="form-control " name="exempt_amt" value="{{old('exempt_amt', $exemption->exemption_amt)}}" id="exempt_amt" >
				@error('exempt_amt')
					<span class="text-danger" role="alert">
						<strong>* {{ $message }}</strong>
					</span>
				@enderror
			</div>
			<div class="col-6 form-group ">
				<label for="incom_other_src">Incom From Other Source (In INR)</label>
				<input type="text" class="form-control " name="incom_other_src" value="{{old('incom_other_src', $exemption->incom_other_src)}}" id="incom_other_src" >
				@error('incom_other_src')
					<span class="text-danger" role="alert">
						<strong>* {{ $message }}</strong>
					</span>
				@enderror
			</div>
			</div>
			<div class="row">
				<div class="col-12 form-group">
					<label for="notes">Notes 
						@error('notes')
				          	<span style="color: red">
								| {{ $message }}
							</span>
				      	@enderror</label>
					<textarea  class="form-control" id="notes" name="notes" >{{old('notes', $exemption->notes)}}</textarea>
				</div>
				
				<div class="col-12 form-group text-center">
					<button class="btn btn-info btn-sm" style="width: 20%">SAVE</button>
					<a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 20%">Cancel</a>
				</div>
			</div>
				
			</div>
			<br>
			
		</form>
	</div>
</main>

<script type="text/javascript">
	$('.datepicker').datepicker({
		orientation: "bottom",
		format: "mm-dd-yyyy",
		autoclose: true,
		todayHighlight: true
	});

	/**Select Heads for respective Section**/

	$('#chapt6_sect').change(function(){

		var section_id = $(this).children("option:selected").val();

		$.ajax({
			type: 'POST',
			url: '{{route('section.heads')}}',
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {'section_id':section_id},
			success:function(res){
				if(res){
					$('#section_head').empty();
					$("#section_head").append('<option>Select Type</option>');
					$.each(res,function(key,value){
						$('#section_head').append('<option value="'+value+'">'+key+'</option>');
					});
				}else{
					$('#section_head').empty();
				}
			}
		});
	});
</script>

@endsection
