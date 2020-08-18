<!DOCTYPE html>
<html>
<head>
	<title>HRMS</title>
</head>
<body>

	This is for testing purpose.
	<div class="row col-12">
		<div class="col-2">
			Name -
		</div>
		<div class="col-6">
			{{ ucwords($user->emp_name) }}
		</div>
	</div>
	<div class="row col-12">
		<div class="col-2">
			Email -
		</div>
		<div class="col-4">
			{{ $user->comp_email }}
		</div>
	</div>
	<div class="row col-12">
		<div class="col-3">
			Department -
		</div>
		<div class="col-4">
			{{ strtoupper($user['department']->name) }}
		</div>
	</div>

</body>
</html>