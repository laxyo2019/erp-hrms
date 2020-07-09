@extends('layouts.master')
@section('content')
	<main class="app-content">
		<div class="row">
			<div class="col-md-12 col-xl-12">
				<h1 style="font-size: 24px">
					<a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right" style="background-color: #e7e7e7; color: black;font-size:13px;" >Go Back</a>
					<!-- <a href="{{Route('create_message')}}" class="btn btn-sm btn-primary pull-right" style="font-size:13px; margin-right: 10px;"  style="{background-color: #e7e7e7; color: black;}" >Add New</a> -->
					<span class="ml-2">

						<!-- 	<button class="btn btn-sm btn-info"  data-toggle="modal" data-target="#import-modal" style="font-size:13px" >
							<form action="{{route('Birthday_user')}}" method="POST" enctype="multipart/form-data">
							@csrf
							<input type="file" onchange="this.form.submit()" name="import" id="import" class="hidden" style="display:none" id="FileUpload"><i class="fa fa-cloud-upload" id="btnFileUpload"> Import</i> </label>
							</form>
							</button>	 -->
							<!-- <a href="{{ route('Birthday_export_user') }}" class="btn btn-sm btn-success"  style="font-size:13px" >Export</a> -->
						
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
									<th>Message</th>
									<th>Action</th>									
								</tr>
							</thead>
							<tbody>
								<?php $count = 0; ?>
								@foreach( $data as $Data )
								<tr>
									<td>{{++$count}}</td>
									<td>{{$Data->message}}</td>
									<td><a href="{{route('edit_message',$Data->id)}}" class="btn btn-sm btn-success"><i class="fa fa-edit text-white" style="font-size: 12px;"></i></a></td>
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
		$('#btnFileUpload').click(function(){
		 $('#import').trigger('click'); 
		});


		// $("#import").change(function () {
		//     $("form").submit();
		// });
		
	</script>
@endsection