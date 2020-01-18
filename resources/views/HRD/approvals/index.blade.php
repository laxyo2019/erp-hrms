@extends('layouts.master')
@section('content')
	<main class="app-content">
		<div class="row">
			<div class="col-md-12 col-xl-12">
				<h1 style="font-size: 24px">Approvals
					<a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right" style="font-size:13px"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
					<span class="ml-2">
						<a href="{{route('approval-action.create')}}" class="btn btn-sm btn-success" style="font-size: 13px">
							<span class="fa fa-plus "></span> Add New</a>
					</span>
				</h1>
				<hr>
			</div>
		</div>
		<div class="row ">
			<div class="col-md-12 col-xl-12">
				<div class="card">
					<div class="card-body table-responsive">
						@if($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                          <button type="button" class="close" data-dismiss="alert">×</button>
                          {{$message}}
                        </div>
                      @endif
						<table class="table table-stripped table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Description</th>
									<th>Reverse Action</th>
									<th>Reason Required</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
							@php $count = 1;@endphp
							@foreach($actions as $data)
								<tr>
									<td>{{$count++}}</td>
									<td>{{ucwords($data->name)}}</td>
									<td>{{$data->description}}</td>
									<td>{{$data->reverse == 1 ? 'Yes' : ''}}</td>
									<td>{{$data->reason == 1 ? 'Yes' : ''}}</td>
									<td class='d-flex'>
										<span>
											<a href="{{route('approval-action.edit',$data->id)}}" class="btn btn-sm btn-success"><i class="fa fa-edit text-white" style="font-size: 12px;"></i></a>
										</span>
										<span class="ml-2">
											<form  action="{{route('approval-action.destroy',$data->id)}}" method="POST" id="delform_{{ $data->id}}">
													@csrf
												@method('DELETE')
												<a href="javascript:$('#delform_{{ $data->id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash text-white"  style="font-size: 12px;"></i></a>
										
											</form>
										</span>
										
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
@endsection