@extends('layouts.master')
@section('content')
	<main class="app-content">
		<div class="row">
			<div class="col-md-12 col-xl-12">
				<h1 style="font-size: 24px">Leaves Request
				 <a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right" style="font-size:13px"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
			</div>
		</div>
		@if($message = Session::get('success'))
			<div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				{{$message}}
			</div>
		@endif 
		<div class="row ">
			<div class="col-md-12 col-xl-12">
				<div class="card">
					<div class="card-body table-responsive">
						<table class="table table-stripped table-bordered" id="ClientsTable">
							<thead>
								<tr>
									<th>##</th>
									<th>EMPLOYEE</th>
									<th>LEAVE</th>
									<th>DETAILS</th>
									<th>LEAVE STARTS</th>
									<th>LEAVE ENDS</th>
									<th>DURATION</th>
									<th>STATUS</th>
									<th style="text-align: center;">ACTIONS</th>
								</tr>
							</thead>
							<tbody>
									{{-- {{$approverName->approve_name['emp_name']}}			 --}}

							@php $count = 0; @endphp
							@foreach($leave_request as $request) 
								<tr>
									<td>{{++$count}}</td>
									<td>{{$request->emp_name}}</td>
									<td>{{$request->name}}</td>
									<td>
									<button class="btn btn-sm btn-info modalReq" data-id="{{$request->id}}">
										<i class="fa fa-eye" style="font-size: 12px;"></i>
									</button></td>
									<div class="modal fade" id="reqModal" role="dialog">
									    <div class="modal-dialog modal-lg" >
									    	<div class="modal-content" >
									        	<div class="modal-header">
									        		<h4 class="modal-title">Request Detail</h4>
									        	</div>
									        	<div class="modal-body table-responsive" id="detailTable">
									        	</div>
									        	 <div class="modal-footer">
									          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
									        </div>
									        </div>
									    </div>
									</div>
									<td>{{$request->from}}</td>
									<td>{{$request->to}}</td>
									<td>{{$request->count}}</td>
									<td>{{empty($request->status) ? 'Pending' : $request->action_name }}
									</td>
									<td class='d-flex' style="border-bottom:none">
									{{-- @can('HR- manager') --}}
									@if($request->action_name =='Approved')
										@else
											@foreach($permissions as $action)
												<span class="ml-2">
													@if($action->name == 'decline')
													<a href="{{route('leave.details', [$request->id, $action->id])}}" class="btn btn-sm btn-danger">{{$action->name}}</a>
													@elseif($action->name == 'approve')
													<a href="{{route('leave.details', [$request->id, $action->id])}}" class="btn btn-sm btn-success">{{$action->name}}</a>
													{{-- @elseif($action->name == 'hold')
													<a href="{{route('leave.details', [$request->id, $action->id])}}" class="btn btn-sm btn-warning">{{$action->name}}</a> --}}
												</span>

												@endif
											@endforeach
									@endif
									{{-- @endcan --}}
									</td>
								</tr>
							 @endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</main>
	    
<script>
	 $(document).ready(function(){
		$('#ClientsTable').DataTable();
	  });
	$(document).ready(function(){
		
		$('.modalReq').on('click', function(e){
			e.preventDefault();
			var leave_id = $(this).data('id');
			$.ajax({
				type: 'GET',
				url: "{{route('request.detail')}}?leave_id="+leave_id,
				success:function(res){
					$('#detailTable').empty().html(res);
					$('#reqModal').modal('show');
				}
			})
		})
	});
</script>
@endsection