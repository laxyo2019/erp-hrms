
<ul class="nav nav-pills nav-justified">
	
	<li class="nav-item">
		<a class="nav-link personal" href="{{route('employee.view-details',['id'=>$employee->id,'view'=>'personal'])}}">Personal</a>
	</li>
	<li class="nav-item">
		<a class="nav-link official" href="{{route('employee.view-details',['id'=>$employee->id,'view'=>'official'])}}">Official</a>
	</li>
	<li class="nav-item">
		<a class="nav-link academics" href="{{route('employee.view-details',['id'=>$employee->id,'view'=>'academics'])}}">Academics</a>
	</li>
	<li class="nav-item">
		<a class="nav-link experience" href="{{route('employee.view-details',['id'=>$employee->id,'view'=>'experience'])}}">Experience</a>
	</li>
	<li class="nav-item">
		<a class="nav-link nominee" href="{{route('employee.view-details',['id'=>$employee->id,'view'=>'nominee'])}}">Nominee</a>
	</li>
	<li class="nav-item">
		<a class="nav-link bankdetails" href="{{route('employee.view-details',['id'=>$employee->id,'view'=>'bankdetails'])}}">Bank Details</a>
	</li>
	<li class="nav-item">
		<a class="nav-link documents" href="{{route('employee.view-details',['id'=>$employee->id,'view'=>'documents'])}}">Documents</a>
	</li>
	{{-- <li class="nav-item"><a href="{{ URL('hrd/employees') }}" class="btn btn-sm btn-primary pull-right" style="font-size:13px"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a></li> --}}
</ul>