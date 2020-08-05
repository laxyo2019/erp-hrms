<table class="table table-stripped table-bordered" id="ActiveEmployees">
	<thead>
		<tr>
			<th><input type="checkbox" id="checkedall"> # </th>
			<th>Employee Name </th>
			<th>Employee Code</th>
			<th>Grade Code</th>
			<th>Designation</th>
			{{-- @ability('hrms_admin|hrms_hr', 'can-allot-leaves') --}}
				<th>Leaves</th>
			{{-- @endability --}}
			{{-- @ability('hrms_admin|hrms_hr', 'can-activate-employees') --}}
			<th>Status</th>
			{{-- @endability --}}
			{{-- @ability('hrms_admin|hrms_hr', 'hrms-view|hrms-edit|hrms-delete') --}}
			<th>Action</th>
			{{-- @endability --}}
		</tr>
	</thead>
	<tbody>
	@php $count = 0; @endphp
	@foreach($employees as $employee)
		<tr>
			<td ><input type="checkbox" value="{{$employee->user_id}}" class="emp" name="checked"> {{$employee->user_id}} </td>
			<td>{{ucwords($employee->emp_name)}}</td>
			<td>{{$employee->emp_code}}</td>
			<td>@if($employee->grade!=null) {{ucwords($employee->grade->name)}} @endif</td>
			<td>{{ucwords($employee['designation']['name'])}}</td>
			{{-- @ability('hrms_admin', 'can-allot-leaves') --}}
			<td>

			{{-- hide allotment button if leave is not created --}}

			@if(count($leaves) == null)
				No leaves to assign
			@else
				@if($employee->leave_allotted == 0)
				<button class="btn btn-sm btn-info ml-2 modalAllot1 "  data-id="{{$employee->user_id}}">
					<span style="font-size: 12px">Allot</span>
				</button>
				@else
				<b style="color: green">Allotted</b>
				{{-- <button class="btn btn-sm btn-info ml-2"  data-id="{{$employee->user_id}}" ></button> --}}
				@endif
			@endif
			</td>
			{{-- @endability --}}

			{{-- @ability('hrms_admin', 'can-activate-employees') --}}
			<td>
	<div class="row">
	@if($employee->status == 0)
      	<div  class="col" align="center">
        <form  action="{{route('active', $employee->user_id)}}" method="POST" id="active_{{ $employee->user_id}}">
          @csrf
          <input type="hidden" name="flag" value="">
          <a href="javascript:$('#active_{{ $employee->user_id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Activate employee ?')">{{$employee->leave_dt !=null ? 'Rejoin' : 'Active'}}</a>
          </form>
        </div>
    @else
    	<div class="col" align="center">
        <form  action="{{route('active', $employee->user_id)}}" method="POST" id="active_{{ $employee->user_id}}">
          @csrf
          <input type="hidden" name="flag" value="{{date("Y-m-d H:i:s", time())}}">
          <a href="javascript:$('#active_{{ $employee->user_id}}').submit();" class="btn btn-sm btn-primary" onclick="return confirm('Deactivate employee ?')">Deactive</a>
          </form>
        </div>
    @endif
	</div>
		</td>
		{{-- @endability --}}
		{{-- @ability('hrms_admin|hrms_hr', 'hrms-view|hrms-edit|hrms-delete') --}}
	<td class='d-flex' style="border-bottom:none">
		{{-- @ability('hrms_admin|hrms_hr', 'hrms-view') --}}
		<span>
			<a href="{{route('employee.view-details',['id'=>$employee->user_id,'view'=>'personal'])}}" class="btn btn-sm btn-info"><i class="fa fa-eye text-white" style="font-size: 12px;"></i></a>
		</span>
		{{-- @endability --}}

		{{-- @ability('hrms_admin|hrms_hr', 'hrms-edit') --}}
		<span class="ml-2">
		<a href="
		{{route('employee.show_page',['id'=>$employee->user_id,'tab'=>'personal'])}}" class="btn btn-sm btn-success"><i class="fa fa-edit text-white" style="font-size: 12px;"></i></a>
		</span>
		{{-- @endability --}}
		{{-- @ability('hrms_admin|hrms_hr', 'hrms-delete') --}}
		<span class="ml-2">
		<form action="
		{{route('employees.destroy', ['id' => $employee->user_id])}}" method="POST" id="delform_{{ $employee->user_id}}">
			@csrf
			@method('DELETE')
			<a href="javascript:$('#delform_{{$employee->user_id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash text-white"  style="font-size: 12px;"></i></a>			
		</form>
		</span>
		{{-- @endability --}}
	</td>
	{{-- @endability --}}
		</tr>
	@endforeach
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		$('#ActiveEmployees').dataTable( {
		
			order: [[1, 'asc']],

		    "columnDefs": [
		    	{ "orderable": false, "targets": 0 }
		  	]
		});
	})
</script>