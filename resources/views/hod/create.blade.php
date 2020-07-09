<form action="{{route('users.store')}}" method="POST" id="assignHod">
	@csrf
	<div class="row">
		<div class="col-6 form-group">
			<label for="name" style="font-size: 20px">Department</label>
		<select name="department" class="custom-select form-control" id="department" required="required">
			<option value="0" >Select Department</option>
			@foreach($depart as $index)
				<option value="{{$index->id}}">{{ucwords($index->name)}}</option>
			@endforeach
		</select>
		</div>
		<div class="col-6 form-group ">
			<div class="col form-group">
				<label for="" style="font-size: 20px">Head of Department</label>
				<select class="select2 form-control" name="emp[]" multiple="multiple" style="width: 100%" id="emp">
					<option value="" >Select Employees</option>
				 	@foreach($employees as $emp)
				 		<option value="{{$emp->user_id}}">{{strtoupper($emp->emp_name)}}</option>
				 	@endforeach
				</select>
			</div>
		</div>					
		<div class="col-12 form-group text-center">
			<input type="submit" value="Submit">
		</div>
	</div>
</form>

<script type="text/javascript" src="https://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.js"></script>	
<script type="text/javascript">

$(document).ready(function(){

	
});
</script>