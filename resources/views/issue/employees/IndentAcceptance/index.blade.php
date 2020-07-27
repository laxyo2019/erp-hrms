@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
	<div style=" padding: 1.5rem; border: 1px solid white;background: white">
		<h1 style="font-size: 24px">Indent Acknowledgement</h1>
			<button type="button" class="btn btn-success btn-sm modalCreate" id="generateIndent" data-id="{{Auth::id()}}" data-toggle="modal" data-target="#exampleModal"><span class="fa fa-plus "></span>request</button>

			{{-- Model --}}
			<div class="modal fade" id="reqModal" role="dialog">
			  	<div class="modal-dialog modal-lg">
			    	<div class="modal-content">
				    	<div class="modal-header">
							<h4 class="modal-title">Request here</h4>
					    </div>
					    <div class="modal-body table-responsive" id="reqDetailTable" style="background: #ececec">
					        <div class="col-12 form-group">
								<label for="">Description (mention your requirment below)</label>
					        	<textarea  id="desc" class="form-control" ></textarea>
					        </div>
					        <div class="col-12 form-group text-center">
								<button id="submitRequest" class="btn btn-info btn-sm" style="width: 20%">SAVE</button>
							</div>
					    </div>
				      	<div class="modal-footer">
				        	<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
				      	</div>
					</div>
				</div>
			</div>
				{{--  --}}
		<hr>
		<div>
			@if($message = Session::get('success'))
				<div class="alert alert-success alert-block">
                	<button type="button" class="close" data-dismiss="alert">×</button>
                	{{$message}}
				</div>
            @endif
	    </div>
		{{-- <h5>Employee Detail </h5> --}}
			<div class="row col-12">
				<div class="col-6 form-group">
					<label for="">Employee Name : </label>
					{{ strtoupper($emp->emp_name) }}
					
				</div>
				<div class="col-6 form-group">
					<label for="emp_code">Employee Code : </label> {{strtoupper($emp->emp_code)}}
					
				</div>
				<div class="col-6 form-group">
					<label for="emp_code">Department : </label> {{strtoupper($emp['department']->name)}}
					
				</div>
				<div class="col-6 form-group">
					<label for="emp_code">Indent Request : </label>
					<button type="button" class="btn btn-success btn-sm" id="myRequests" data-id={{Auth::id()}}>Check Here</button>

					<button type="button" class="btn btn-success btn-sm" id="myIndentList" data-id={{Auth::id()}} style="display:none">My Indent</button>
				</div>
			</div>
		<div id="myIndent">
			@include('issue.employees.IndentAcceptance.myindent')
		</div>
		{{-- @endif --}}
	</div>
</main>

<script type="text/javascript">
$(document).ready(function(){

  $('#generateIndent').on('click', function(){
	$('#reqModal').modal('show');

  });

  //Submit request from model
  $('#submitRequest').on('click', function(){
  	var description = $('#desc').val();

  	if(description == ''){
  		
  		alert('You can\'t submit request.');
  	}else{

  		$.ajax({
	  		type: 'post',
	  		url: '/issue/my-indent/',
	  		data: {'description': description},
	  		headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	  		success: function(){
	  			
	  			alert('Request has been submitted.');
	  			location.reload();
	  		}
	  	});
  	}
  });

  	$(document).on('click','#myRequests, #myIndentList', function(){
		
		var user_id	= $(this).data('id');
		var btnId	= $(this).attr('id');
		
		$.ajax({
			type: 'POST',
			url: 'my-indent/tab/'+btnId,
			data: {'user_id': user_id},
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(res){

				$('#myIndent').empty().html(res);
				
				if(btnId == 'myRequests'){

					$('#myRequests').hide();
					$('#myIndentList').show();
				}else{
					$('#myIndentList').hide();
					$('#myRequests').show();
				}
			}
			
		})
		

	})

});
</script>
<style type="text/css">
  .approve
  {
    background: #0cac0c;
    color: white;
  }
  .decline
  {
    background: #ff1414;
    color: white;
  }
 
  .apprv_msg{
    color: #0cac0c;
  }
  .dec_msg{
    color: #ff1414;
  }
  .rev_msg{
    color: #3375ca;
  }

</style>

@endsection
