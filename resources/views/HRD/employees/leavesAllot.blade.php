@push('styles')
	
	{{--<script src='{{asset('js/select2.min.js')}}' type='text/javascript'></script>--}}
@endpush
<div><h4>{{ucwords($employee->emp_name)}}</h4></div>
<form action="{{route('allotments.store')}}" method="POST" >
	@csrf
	<div class="row">
		<div class="col-6 form-group">
			<label for="start">Leave Session Started</label>
			<input type="text" id="start" class="form-control datepicker" name="start" value="{{$sessionStarts}}" autocomplete="off">
			@error('start')
	          <span class="text-danger" role="alert">
	            <strong>* {{ $message }}</strong>
	          </span>
	      	@enderror
		</div>
		<div class="col-6 form-group">
			<label for="ends">Leave Session Ends</label>
			<input type="text" class="form-control datepicker" name="ends" value="{{$sessionEnds}}" autocomplete="off" id="ends">
			@error('ends')
	          <span class="text-danger" role="alert">
	            <strong>* {{ $message }}</strong>
	          </span>
	      	@enderror
		</div>

		@foreach($leaves as $index)
			<div class="col form-group">
				<label for="leave_{{$index->id}}">{{ucwords($index->name)}}</label>
				<div class="toggle lg row col-12">
    				<div class="form-check form-check-inline mr-0">
						<label>
							<input type="checkbox" name="leave[]" value="{{$index->id}}" ><span class="button-indecator"></span>
						</label>
					</div>
    			</div>
				
				@error('leave_{{$user->leave_mast_id}}')
		          <span class="text-danger" role="alert">
		            <strong>* {{ $message }}</strong>
		          </span>
		      	@enderror
			</div>
		@endforeach
	</div>
	<input type="hidden" name="user_id" value="{{$employee->user_id}}">
	<div class="col-12 form-group text-center">
		<button class="btn btn-info btn-sm m-2" style="width: 40%">Save</button>
	</div>
</form>
<script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript">

$('.datepicker').datepicker({
	format: "yyyy-mm-dd",
	autoclose: true,
	todayHighlight: true,
	pickerPosition: "top-left"
});
</script>