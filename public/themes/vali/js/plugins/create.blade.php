@extends('layout.main')
@section('content')
<main class="app-content">
   <div class="app-title">
      <div>
          <h1><i class="app-menu__icon fa fa-comments-o"></i> Create Tour Request</h1>
        </div>
      <div>
         {{-- Message show --}}
        <p>
          @if($message = Session::get('success'))
            <div class="alert alert-success">
              <p>{{ $message }}</p>
            </div>
          @endif
        </p>
      </div>
      {{-- <ul class="app-breadcrumb breadcrumb side">  </ul> --}}
   </div>
   <div class="container">
      <div class="row">
         <div style="background-color: white" class="modal-content">
            <div class="modal-body">
               {{-- <div class="clearix"></div> --}}
               <div class="col-md-12">
                  {{-- <div class="tile"> --}}
                     <h3 class="tile-title">Tour Approvel Form</h3>
                     <div class="tile-body">
                        <form class="row" action="{{route('TourRequest.store')}}" method="post">
                           @csrf
                           <div class="form-group col-md-4">
                              <label class="control-label"> Your Name</label>
                              <input id="name" name="emp_name" class="form-control" type="text" placeholder="Enter Name" value="{{$data->emp_name}}">
                              @error('emp_name')
                              <span class="text-danger" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                           <div class="form-group col-md-4" >
                              <label for="Grade">Grade</label>
                               <input  value="{{$data->grade ? $data->grade->name ? $data->grade->name :'' :'' }}" name="grd" class="form-control" id="grd" readonly="">
                              @error('grd')
                              <span class="text-danger" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                           <div class="form-group col-md-4" >
                              <label for="Designation">Designation</label>
                             <input  value="{{$data->designation ? $data->designation->name ? $data->designation->name : '' :''}}" name="designation" class="form-control" id="designation" readonly="">
                                 
                              @error('designation')
                              <span class="text-danger" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           
                           </div>
                           <div class="form-group col-md-4" >
                              <label for="Department">Department</label>
                             {{--  <select name="department" class="form-control" id="department" > --}}
                                 {{-- <option value=""> Select Department</option> --}}
                                 <input  value="{{ $data->department ? $data->department->name ? $data->department->name :'' :'' }}" type="text" name="department" readonly="" class="form-control"></input>
                              {{-- </select> --}}
                              @error('department')
                              <span class="text-danger" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                           <div class="form-group col-md-4">
                              <label class="control-label">Tour, From</label>
                              <input id="tour_from" name="tour_from" class="form-control" type="text" placeholder="Enter tour from">

                              @error('tour_from')
                              <span class="text-danger" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                           <div class="form-group col-md-4">
                              <label class="control-label">To</label>
                              <input id="tour_to" name="tour_to" class="form-control" type="text" placeholder="Enter tour to">
                              @error('tour_to')
                              <span class="text-danger" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                           <div class="form-group col-md-4">
                              <label class="control-label">Period of Tour, From</label>
                              <input id="time_from" name="time_from" class="form-control datepicker" type="text" placeholder="yyyy-mm-dd">
                              @error('time_from')
                              <span class="text-danger" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                           <div class="form-group col-md-4">
                              <label class="control-label">To</label>
                              <input id="time_to" name="time_to" class="form-control datepicker" type="text" placeholder="yyyy-mm-dd">
                              @error('time_to')
                              <span class="text-danger" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                           <div class="form-group col-md-4">
                              <label for="advance_amount">Advance Amount</label>
                              <input id="advance_amount" name="advance_amount" class="form-control advance_amount" type="text" placeholder="Enter advance amount">
                              @error('advance_amount')
                              <span class="text-danger" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                           <div class="form-group col-md-4">
                              <label for="purpuse_of_tour">Purpuse of Tour</label>
                              <textarea name="purpuse_of_tour" class="form-control" id="purpuse_of_tour" rows="2" placeholder="Enter purpuse of tour"></textarea>
                              @error('purpuse_of_tour')
                              <span class="text-danger" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>

                           <div class="form-group col-md-4">
                              <label for="mode_of_travel">Mode of Travel</label>
                              <textarea name="mode_of_travel" class="form-control" id="mode_of_travel" rows="2" placeholder="Enter mode of travel"></textarea>
                              @error('mode_of_travel')
                              <span class="text-danger" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                           <div class="form-group col-md-4">
                              <label for="entitlement">Entitlement Class</label>
                              <textarea name="entitlement" class="form-control" id="entitlement" rows="2" placeholder="Enter entitlement class"></textarea>
                              @error('entitlement')
                              <span class="text-danger" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                           <div class="form-group col-md-4">
                              <label for="proposed_class">Proposed Class</label>
                              <textarea name="proposed_class" class="form-control" id="proposed_class" rows="2" placeholder="Enter proposed Class"></textarea>
                              @error('proposed_class')
                              <span class="text-danger" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                           <div class="form-group col-md-4">
                              <label for="justification">Justification for higher class(If any) </label>
                              <textarea name="justification" class="form-control" id="justification" rows="2" placeholder="Enter justification for higher class(If any)"></textarea>
                              @error('justification')
                              <span class="text-danger" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                         </div>
                         <div class="row col-12">
                           <h5>Add Employees Along With You</h5><hr>
                           <div class="col-6">
                              <label for="employees_along">Add Employees Here</label>
                              {{-- <input id="employees_along" name="employees_along[]" class="form-control employees_along" type="text" placeholder="Add employees"> --}}
                              <select class="form-control select2multi" name="employees_along[]" multiple="multiple">
                                {{-- @foreach($employees as $index)
                                  <option value="{{$index->user_id}}">$index->emp_name</option>
                                @endforeach --}}
                              </select>
                           </div>
                         </div>
                         <div class="row col-12">
                           {{-- {{dd($data)}} --}}
                          <input id="emp_location" name="emp_location" class="form-control" type="hidden" value="{{$data->branch_details ? $data->branch_details->city ? $data->branch_details->city :'' :''}}"> 
                           <div class="form-group col-md-4">
                              <label for="justification"><b>Notes:-</b> </label>
                              <span>Forms without neccessary approvals will not be accepted by Accounts Department for reimbursement of TA/DA inal Bill. Any deviation from policy, in case of circumstances,must be approved by Director. Tour approvel application shoul be submitted at least 2 days before the date of journey to HR Department.	 </span>
                           </div>
                           <div class="form-group col-12 ">
                              <button id="addGrade" class="btn btn-primary" type="submit">
                              <i class="fa fa-fw fa-lg fa-check-circle"></i>Apply
                              </button>
                           </div>
                        </form>
                        {{-- END INSERT FORM --}}
                     </div>
                  </div>
               </div>
            </div>
        {{--  </div> --}}
      </div>
   </div>
  </div>
 </tbody>
</table>
</div>
</main>
<script type="text/javascript"> 
$(document).ready(function() {

  $(function() {
    $('.datepicker').datepicker({
        orientation: "bottom",
        format: "yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true
    });
  });
  $(function() {
    $('.timepicker').datetimepicker({
      format:'hh:mm',
    });
  });

  $(document).ready(function() {
    $('.select2multi').select2();
  });
}); 
</script>
@endsection
