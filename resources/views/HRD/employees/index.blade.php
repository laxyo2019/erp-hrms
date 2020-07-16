@extends('layouts.master')
@section('content')
<main class="app-content">
	<div class="row ">
		<div class="col-md-12 col-xl-12">
			<div class="card">
			 	<div class="col-md-12 col-xl-12" style="margin-top: 15px">
					<h1 style="font-size: 24px">Employees</h1>
					<span class="ml-2">
						<button class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#import-modal" style="font-size:13px" >
							<form action="{{route('employees.import')}}" method="POST" enctype="multipart/form-data">
							@csrf
							<input type="file" onchange="this.form.submit()" name="import" class="hidden" style="display:none" id="FileUpload">
							<i class="fa fa-cloud-upload" id="btnFileUpload"> Import Employees</i> </label>
							</form>
						</button>
					</span>
					<span class="ml-2">
						<a  class="btn btn-sm btn-primary export" style="font-size:13px; color: white" id="export">
							<span class="fa fa-download"></span> Export Employees
						</a>
						<a hidden href="{{route('employees.export')}}" class="btn btn-sm btn-primary export" style="font-size:13px" id="exportone">
							<span class="fa fa-download"></span> Export Employeess
						</a>
					</span>
					<span class="ml-2 btnID">
						<button type="button" value="1" class="btn btn-primary btn-md" id="vacatedEmp"><span class="fa fa-trash"></span>vacated employees</button>
						<button type="button" value="1" class="btn btn-primary btn-md" id="empList" style="display: none;"><span class="fa fa-trash"></span>Active Employees </button>
					</span>
				</div>
				<div class="card-body table-responsive" >
					@if($message = Session::get('success'))
						<div class="alert alert-success alert-block">
							<button type="button" class="close" data-dismiss="alert">×</button>
							{{$message}}
						</div>
					@endif
					<div id="employeeTable">
						@include('HRD.employees.index.employee')
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="allotmentsModal" role="dialog">
		<div class="modal-dialog modal-lg" >
			<div class="modal-content" >
				<div class="modal-header">
					<h4 class="modal-title">Leaves Allotments</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body table-responsive" id="modalform">
				</div>
			</div>
		</div>
	</div>
</main>
<script type="text/javascript">

$(document).ready(function(){
	

	$('#btnFileUpload').on('click', function(){
        $('#FileUpload').trigger('click');

    });

	$(document).on('click','.modalAllot1', function(event){
        event.preventDefault();
        var user_id = $(this).data('id');
		$.ajax({
			type: 'GET',
			url: '{{route('allotments.create')}}'												,
			data: {'user_id': user_id},
			//headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(data){
				$('#allotmentsModal').modal('show');
				$('#modalform').html(data);
			}
		});
	});

	$('#vacatedEmp,#empList').on('click', function(){
		// var btnId = $(this).val();
		var btnId = $(this).attr('id');

		$.ajax({
			type: 'GET',
			url: '/hrd/employees/vacated/'+btnId,
			success: function(res){
				//alert()
				$('#employeeTable').empty().html(res);
				if(btnId == 'vacatedEmp'){
					$('#empList').show();
					$('#vacatedEmp').hide();
				}else{
					$('#empList').hide();
					$('#vacatedEmp').show();
				}
				//$('#activeEmployee').html().hide();
			}
		})
	});

/*	create by kishan developer for export data using checkbox or unchecheked*/

    $("#export").click(function(){
    	var emp = [];
    	$.each($("input[name='checked']:checked"), function(){
        	emp.push($(this).val());
    	});

    	$.ajax({
    		type:'POST',
    		url:'{{route('employee.save_session')}}',
    		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    		data:{user_id:emp},
    		success:function(data){
    			 window.location.href = $('#exportone').attr('href');
    		}
    	})
	});
/***/
	
	
/*select all employee using checkbox*/
	var clicked = false;
	$("#checkedall").on("click", function() {
	  	$(".emp").prop("checked", !clicked);
	  clicked = !clicked;
	});
});
</script>
@endsection