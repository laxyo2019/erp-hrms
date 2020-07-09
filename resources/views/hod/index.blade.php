@extends('layouts.master')
@section('content')
<main class="app-content">
  <div class="row">
    <div class="col-md-12 col-xl-12">
      <div class="card shadow-xs">
        <div class="col-md-12 col-xl-12" style="margin-top: 15px"> 
          <h1 style="font-size: 24px">Head Of Department
            <a href="{{URL::previous() }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Back</a>
               @ability('hrms_admin|hrms_hr', 'hrms-create')
              <span class="ml-2">
               {{--  <a href="{{route('hod.create')}}" class="btn btn-sm btn-success" style="font-size: 13px">
              <span class="fa fa-plus "></span>Add</a> --}}
              <button type="button" class="btn btn-success btn-sm modalCreate" id="assignHod"  data-toggle="modal" data-target="#exampleModal"><span class="fa fa-plus "></span>Add</button>
               <!-- Modal -->
                <div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Assign Department Head</h4>
                      </div>
                      <div class="modal-body table-responsive" id="DepartHead" style="background: #ececec">
                        <form action="{{route('hod.store')}}" method="post" id="form-example">
                            @csrf
                            <div class="row">
                              <div class="col-6 form-group">
                                <label for="name" style="font-size: 20px">Department</label>
                              <select name="department" class="custom-select form-control" id="department" required="">
                                <option value="" >Select Department</option>
                                @foreach($depart as $index)
                                  <option value="{{$index->id}}">{{ucwords($index->name)}}</option>
                                @endforeach
                              </select>
                              @error('department')
                                  <span style="color: red">
                              {{ $message }}
                            </span>
                              @enderror
                              </div>
                              <div class="col-6 form-group ">
                                <div class="col form-group">
                                  <label for="" style="font-size: 20px">Head of Department</label>
                                  <select class="select2 form-control" name="emp[]" multiple="multiple" style="width: 100%" id="emp" required="required">
                               
                                    @foreach($employees as $emp)
                                      <option value="{{$emp->user_id}}">{{strtoupper($emp->emp_name)}}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>          
                              <div class="col-12 form-group text-center">
                                {{-- <input type="submit" value="save"> --}}
                                <button class="btn btn-info btn-sm" style="width: 20%">SAVE</button>
                              </div>
                            </div>
                          </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>

             </span>
             @endability
          </h1>
        </div>
        <div class="card-body table-responsive">
          @if($message = Session::get('success'))
            <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button>
              {{$message}}
            </div>
          @endif
          <table class="table table-striped table-hover" id="HodTable">
            <thead>
              <tr class="text-center">
                <th>#</th>
                <th>Head of Department</th>
                <th>Employee Code</th>
                {{-- <th>Department</th> --}}
                <th>Description</th>
                {{-- @ability('hrms_admin', 'hrms-edit') --}}
                  <th>Actions</th>
                {{-- @endability --}}
              </tr>
            </thead>
          <tbody>
          @php $count = 0; @endphp
           @foreach($hod as $index)
              <tr class="text-center">
                <td> {{++$count}}</td>
                <td>{{ucwords($index['employee']->emp_name)}}</td>
                <td>{{$index['employee']->emp_code}}</td>
                <td>{{strtoupper($index['department']->name)}}</td>
                {{-- @ability('hrms_admin', 'hrms-edit') --}}
                
                <td class='d-flex' style="border-bottom:none">
                  <form  action="{{route('hod.destroy',$index->id)}}" method="POST" id="delform_{{ $index->id}}">
                    @csrf
                    @method('DELETE')
                    <a href="javascript:$('#delform_{{ $index->id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></a>
                  </form>
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
<script type="text/javascript">
$(document).ready(function(){

  $('#HodTable').dataTable( {
    "ordering":   true,
    order   : [[1, 'asc']],
    "columnDefs": [ 
      { "orderable": false, "targets": 0,  }
    ]
  });

  @if($errors->any())
    $('#exampleModal').modal('show');
  @endif


  $('.select2').select2({
     placeholder: "Select Employees",
     allowClear : true
  });

 

 
});
</script>
<style type="text/css">
  .approve
  {
    background: #0cac0c;
    color: white;
  }
  .decline
  {
    background: #ff1414;
    color: white;
  }
 
  .apprv_msg{
    color: #0cac0c;
  }
  .dec_msg{
    color: #ff1414;
  }
  .rev_msg{
    color: #3375ca;
  }

</style>
@endsection