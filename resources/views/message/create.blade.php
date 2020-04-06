@extends('layouts.master')
@section('content')
	<main class="app-content">
		<div class="row">
			<div class="col-md-12 col-xl-12">
				<h1 style="font-size: 24px">
					<a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right" style="background-color: #e7e7e7; color: black;font-size:13px;" >Go Back</a>	
				</h1>
				<hr>
			</div>
		</div>
		<div class="row ">
			<div class="col-md-12 col-xl-12">
				<div class="card">
					<div class="card-body table-responsive">
						<form action="{{route('save_message')}}" method="post">
							@csrf
							<div class="row mt-5 mb-5">
								<div class="col-sm-4"></div>
								<div class="col-sm-4">
									<label>Message</label>
									<textarea name="message" class="form-control"></textarea>
								</div>
								<div class="col-sm-4"></div>
								<div class="col-md-12 text-center mt-3">
									<input type="submit" value="Submit" class="btn btn-success">
								</div>
							</div>	
						</form>
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