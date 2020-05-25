@extends('layouts.master')
@push('styles')
  <script src="{{asset('themes/vali/js/plugins/bootstrap-datepicker.min.js')}}"></script>
@endpush
@section('content')
<main class="app-content">
  
  <div style=" padding: 1.5rem; border: 1px solid white;background: white">
    {{-- <div class="col-md-12 col-xl-12"> --}}
      <h1 style="font-size: 24px">Loan Setting
        {{-- <a href="{{ route('loan-request.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a> --}}
    </h1>
    {{-- </div> --}}
    @if($message = Session::get('success'))
      <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{$message}}
      </div>
    @endif 
    
    <form action="{{route('loan-request.update')}}" method="POST" >
      @csrf
      {{-- <h5>Employee Detail</h5><hr> --}}
      
      {{-- <h5>Loan Application Detail</h5><hr> --}}
      <div class="row">
        <div class="col-6 form-group ">
          <label for="">Rate of Interest  ( % )</label>
          <input type="text" class="form-control" name="interest_rate" value="{{old('interest_rate')}}" >
          @error('interest_rate')
            <span class="text-danger" role="alert">
              <strong>* {{ $message }}</strong>
            </span>
          @enderror
        </div>  
        
      
        
      </div>
      <div class="row">
        <div class="col-6 form-group">
          <label for="reason">Reason 
            @error('reason')
                    <span style="color: red">
                | {{ $message }}
              </span>
                @enderror</label>
          <textarea  class="form-control" id="reason" name="reason" >{{old('reason')}}</textarea>
        </div>
        
        <div class="col-12 form-group text-center">
          <button class="btn btn-info btn-sm" style="width: 20%">SAVE</button>
          {{-- <a class="btn btn-danger btn-sm" href="javascript:location.reload()" style="width: 30%">Cancel</a> --}}
        </div>
      </div>    
      </div>
      <br>
      
    </form>
  </div>
</main>

<script type="text/javascript">
  $('.datepicker').datepicker({
    orientation: "bottom",
    format: "mm-dd-yyyy",
    autoclose: true,
    todayHighlight: true
    });
</script>

@endsection
