@extends('layouts.master')
@section('content')
	<main class="app-content">
		<div class="row">
			<div class="col-md-12 col-xl-12">
				<h1 style="font-size: 20px">Update Details
         <a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right" style="font-size:13px"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
				</h1>
				<hr>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-xl-12">
				<div class="card shadow-xs">
					<div class="card-body">
						<form method="post" action="{{route('birthday_wish.update',$data->id)}}">
							@csrf
							@method('PATCH')
							<div class="row form-group">
								<div class="col-md-4 col-lg-4 col-xl-4 mt-2">
									<label for="name"><b>Name <span class="text-danger">*</span></b> </label>
									<div class="input-group">										
										<input type="text" name="name" class="form-control" required="" value="{{old('name') ? old('name'): $data->name}}">
									</div>
									@error('name')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                	@enderror
								</div>
								<div class="col-md-4 col-lg-4 col-xl-4 mt-2">
									<label for="name"><b>Mobile Number <span class="text-danger">*</span></b> </label>
									<div class="input-group">										
										<input type="text" name="mobile_number" class="form-control" required="" value="{{old('mobile_number') ? old('mobile_number'): $data->mobile_number}}">
									</div>
									@error('mobile_number')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                	@enderror
								</div>
								<div class="col-md-4 col-lg-4 col-xl-4 mt-2">
									<label for="name"><b>Date Of Birth <span class="text-danger">*</span></b> </label>
									<div class="input-group">										
										<input type="text" name="date_of_birth" class="form-control datepicker" readonly="" value="{{old('date_of_birth') ? old('date_of_birth'): $data->date_of_birth}}">
									</div>
									@error('date_of_birth')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                	@enderror
								</div>

							<div class="col-md-12 mt-3">
								<input type="hidden" name="grp_code" value="1">
								<button class="btn btn-md btn-success" type="submit"><span class="fa fa-save"></span> Submit</button>
								<span class="ml-2" ><a href="{{route('birthday_wish.index')}}" class="btn btn-md btn-default" style="background-color: #f4f4f4;color: #444;    border-color: #ddd;"><span class="fa fa-times-circle"></span> Cancel</a></span>
							</div>
						</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</main>
	<script type="text/javascript">
		$('.datepicker').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true
		});
	</script>
@endsection