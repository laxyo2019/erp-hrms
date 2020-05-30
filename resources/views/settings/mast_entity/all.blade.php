@extends('layouts.master')
@section('content')
	<main class="app-content">
		<div class="app-title">
			<div class="div row mt-2">
				<h4><i class="fa fa-asterisk"></i> Entity :  {{ $table_name }}
				
				</h4>
{{-- 				@ability('hrms_admin', 'hrms_create') --}}
				<a href="{{ route('mast_entity.get', ['create', $db_table]) }}" class="btn btn-outline-success ml-2" style="font-size: 13px">
					<span class="fa fa-plus"></span> Add New</a>
				{{-- @endability --}}
			</div>
			<a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right" style="font-size:13px"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
		</div>
		@if($message = Session::get('success'))
			<div class="alert alert-success alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>
				{{$message}}
			</div>
		@endif 
		@if($message = Session::get('error'))
			<div class="alert alert-success alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>
				{{$message}}
			</div>
		@endif 
		<div class="row ">
			<div class="col-md-12 col-xl-12">
				<div class="card shadow-xs">
					
					<div class="card-body table-responsive">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Description</th>
									{{-- @ability('hrms_admin', 'hrms-edit|hrms-delete') --}}
										<th>Actions</th>
									{{-- @enability --}}
								</tr>
							</thead>
							<tbody>
							@foreach($data as $row)
							<tr>
								<td>{{$row->id}}</td>
								<td>{{strtoupper($row->name)}}</td>
								<td>{{$row->description}}</td>
								{{-- @ability('hrms_admin', 'hrms-edit|hrms-delete') --}}
									<td class="d-flex">
										{{-- @ability('hrms_admin', 'hrms_edit') --}}
										<span>
											<a href="{{route('mast_entity.get', ['edit', $db_table, $row->id])}}" class="btn btn-sm btn-outline-warning"><i class="fa fa-edit"></i> Edit</a>
										</span>
										{{-- @endability --}}
										{{-- @ability('hrms_admin', 'hrms-delete') --}}
										<span class="ml-2">
											<form action="{{route('mast_entity.delete', [$db_table, $row->id])}}" method="POST" id="delform_{{ $row->id}}">
												@csrf
												@method('DELETE')
												<a href="javascript:$('#delform_{{ $row->id }}').submit();" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> Delete</a>
											</form>
										</span>
										{{-- @endability --}}
									</td>
								{{-- @endability --}}
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
