{{-- Created by kishan Developer --}}
@extends('layouts.master')
@push('styles')
	<script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
	<script src='{{asset('js/select2.min.js')}}' type='text/javascript'></script>
@endpush
@section('content')
<main class="app-content">
	@include ('HRD/employees/view-tabs')
	  {{-- <main class="app-content"> --}}
      <div class="app-title" style="margin-top:'-38px';">
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <section class="invoice">
              <div class="row mb-4">
                <div class="col-6">
                  <h2 class="page-header"><i class="fa fa-globe"></i> Vali Inc</h2>
                </div>
                <div class="col-6">
                  <h5 class="text-right">Date: 01/01/2016</h5>
                </div>
              </div>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Qty</th>
                        <th>Product</th>
                        <th>Serial #</th>
                        <th>Description</th>
                        <th>Subtotal</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>The Hunger Games</td>
                        <td>455-981-221</td>
                        <td>El snort testosterone trophy driving gloves handsome</td>
                        <td>$41.32</td>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>City of Bones</td>
                        <td>247-925-726</td>
                        <td>Wes Anderson umami biodiesel</td>
                        <td>$75.52</td>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>The Maze Runner</td>
                        <td>545-457-47</td>
                        <td>Terry Richardson helvetica tousled street art master</td>
                        <td>$15.25</td>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>The Fault in Our Stars</td>
                        <td>757-855-857</td>
                        <td>Tousled lomo letterpress</td>
                        <td>$03.44</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row d-print-none mt-2">
                <div class="col-12 text-right"><a class="btn btn-primary" href="javascript:window.print();" target="_blank"><i class="fa fa-print"></i> Print</a></div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </main>
<script type="text/javascript">
	$(document).ready(function(){
		$('.official').addClass('active');
		$('.datepicker').datepicker({
			orientation: "bottom",
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true
			});

		// Initialize select2
		  $("#reportsTo").select2();

		/*$('#allot').on('click', function(e){
            e.preventDefault();
			$.ajax({
				type: 'POST',
				url: route('alloting.leave', $employee->id)}},
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				success: function(data){
					alert(data);
				}
			});
		});*/

		$(":input").each(function(){
		 var input = $(this); // This is the jquery object of the input, do what you will
		 console.log();
		});
	});
</script>
@endsection
{{-- End Created by kishan Developer --}}
