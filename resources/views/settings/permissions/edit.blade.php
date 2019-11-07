@extends('layouts.master')
@section('content')
	<main class="app-content">
		<div class="row">
			<div class="col-md-12 col-xl-12">
				<h1 style="font-size: 24px">Approval Permissions
					{{-- <span class="ml-2">
						<a href="{{route('permissions.create')}}" class="btn btn-sm btn-success" style="font-size: 13px">
							<span class="fa fa-plus "></span> Add New</a>
					</span>
					<span class="ml-2">
						<button  class="btn btn-sm btn-info"  data-toggle="modal" data-target="#import-modal" style="font-size:13px">
							<span class="fa fa-upload"></span> Import
						</button>
					</span>
					<span class="ml-2">
						<a href="#" class="btn btn-sm btn-primary" style="font-size:13px">
							<span class="fa fa-download"></span> Export
						</a>
					</span> --}}
				</h1>
				<hr>
			</div>
		</div>
		@if($message = Session::get('success'))
			<div class="alert alert-success">
				{{$message}}
			</div>
		@endif
			<div class="row">
      <div class="col-md-12 col-xl-12">
        <div class="card shadow-xs">
          <div class="card-body table-responsive" style="text-align: center;">
          	<h4>{{$desig->name}}</h4>
          	<form action="{{route('permissions.update', [$desig->id])}}" method="POST">
          	@csrf
          	@method('PATCH')
            <table class="table table-striped table-hover">
              <thead>
                <tr class="text-center">
                  <th>PERMISSIONS</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              @foreach($actions as $action)
              <tr class="text-center">
                <td>{{$action->name}}</td>
                <td>
                	<input type="checkbox" class="form-check-input" id="actionCheck_{{$action->id}}" name="actionCheck[]" value="{{$action->id}}" >
    				<label class="form-check-label" for="actionCheck_{{$action->id}}">ENABLE / DISABLE</label></td>
              </tr>
             @endforeach
              </tbody>
            </table>
	            <div class="col-12 form-group text-center">
					<button class="btn btn-info btn-md ">Save</button>
					<a class="btn btn-danger btn-md" href="javascript:location.reload()">Cancel</a>
				</div>
            </form>
          </div>
        </div>
      </div>
    </div>
	</main>
<script>
	/*$(document).ready(function(){
		$(#checkbox)
		$('.enable').on('click',function(){
			var id = $(this).attr('data-id');
			console.log(id);
			$('#myCheckbox').prop('checked', true);
			$('.checkbox_'+id).attr('checked','true');
		})
	})*/
</script>
@endsection