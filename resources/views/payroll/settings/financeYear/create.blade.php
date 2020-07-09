<style type="text/css">
	.datepicker{z-index: 1151 !important}	
</style>
  
<form action="{{route('by-cadre.store')}}" method="POST" >
	@csrf
	<form >
		<div class="col-12">
			<div class="form-row">
				<div class="col-6 form-group">
					<label for="year_from">Year (from)</label>
					<input type="text" id="from" class="form-control datepicker" name="start" value="" autocomplete="off">
				</div>
			    <div class="col-6 form-group">
					<label for="year_to">Year (to)</label>
					<input type="text" data-date-format="YYYY" id="to" class="form-control datepicker" name="start" value="" autocomplete="off" style="z-index: 1151 !important">
				</div>
				<div class="col-12 form-group ">
			    	<label for="description">Description</label>
			    	<textarea name="description" id="description" class="form-control" cols="10" rows="5">{{old('description')}}</textarea>
			    	@error('description')
						<span class="text-danger" role="alert">
							<strong>* {{ $message }}</strong>
						</span>
					@enderror
			    </div>
			    {{-- <div class="col-md-4 mb-3">
			    	<label for="validationDefaultUsername">Username</label>
			      	<div class="input-group">
			        	<div class="input-group-prepend">
			          		<span class="input-group-text" id="inputGroupPrepend2">@</span>
			        	</div>
			        	<input type="text" class="form-control" id="validationDefaultUsername" placeholder="Username" aria-describedby="inputGroupPrepend2" required>
			      	</div>
			    </div> --}}
			</div>
		</div>
		<div class="col-12 form-group text-center">
			<button class="btn btn-info btn-sm" style="width: 20%">SAVE</button>
			{{-- <a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 30%">Cancel</a> --}}
		</div><br>
	</form>
</main>

<script type="text/javascript">
	$('.datepicker').datepicker({
		orientation: "bottom",
		format: "mm-dd-yyyy",
		autoclose: true,
		todayHighlight: true,
	});


	#ui-datepicker-div {z-index:1003 !important;}*/
</script>

