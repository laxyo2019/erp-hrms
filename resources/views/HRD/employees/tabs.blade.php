<ul class="nav nav-pills nav-justified">
	
	
	<li class="nav-item">
		<a class="nav-link personal" href="{{route('employee.show_page',['user_id'=>$employee->user_id,'tab'=>'personal'])}}">Personal</a>
	</li>
	<li class="nav-item">
		<a class="nav-link official" href="{{route('employee.show_page',['user_id'=>$employee->user_id,'tab'=>'official'])}}">Official</a>
	</li>
	<li class="nav-item">
		<a class="nav-link academics" href="{{route('employee.show_page',['user_id'=>$employee->user_id,'tab'=>'academics'])}}">Academics</a>
	</li>
	<li class="nav-item">
		<a class="nav-link experience" href="{{route('employee.show_page',['user_id'=>$employee->user_id,'tab'=>'experience'])}}">Experience</a>
	</li>
	<li class="nav-item">
		<a class="nav-link nominee" href="{{route('employee.show_page',['user_id'=>$employee->user_id,'tab'=>'nominee'])}}">Nominee</a>
	</li>
	<li class="nav-item">
		<a class="nav-link bankdetails" href="{{route('employee.show_page',['user_id'=>$employee->user_id,'tab'=>'bankdetails'])}}">Bank Details</a>
	</li>
	<li class="nav-item">
		<a class="nav-link documents" href="{{route('employee.show_page',['user_id'=>$employee->user_id,'tab'=>'documents'])}}">Documents</a>
	</li>
	{{-- <li><a href="{{ URL('hrd/employees') }}" class="btn btn-sm btn-primary pull-right" style="font-size:13px"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a><br></li> --}}
</ul>