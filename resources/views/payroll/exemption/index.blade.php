@extends('layouts.master')
@section('content')
  <main class="app-content">
    <div class="row">
      <div class="col-md-12 col-xl-12">
        <div class="card shadow-xs">
          <div class="col-md-12 col-xl-12" style="margin-top: 15px">
              <h1 style="font-size: 24px">Chapter 6 Exemptions
                <a href="" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Back</a>
                <span class="ml-2">
                  <a href="{{route('chapter6-exemption.create')}}" class="btn btn-sm btn-success" style="font-size: 13px">
                  <span class="fa fa-plus "></span> Add Exemption</a>
                </span>
              </h1>
            </div>
          <div class="card-body table-responsive">
            
            @if($message = Session::get('success'))
              <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{$message}}
              </div>
            @endif
            <table class="table table-striped table-hover" id="ExemptionTable">
              <thead>
                <tr class="text-center">
                  <th>#</th>
                  <th>Employee</th>
                  <th>Section</th>
                  <th>Head</th>
                  <th>Financial Yr</th>
                  <th>Exemption Amt</th>
                  <th>Income - Other Source (In INR)</th>
                  <th>Note</th>
                  {{-- @ability('hrms_admin', 'hrms-edit|hrms-delete') --}}
                    <th>Actions</th>
                  {{-- @endpermission --}}
                </tr>
              </thead>
              <tbody>
               @php $count = 0; @endphp
                @foreach($exemptions as $index)
                    <tr class="text-center" >
                      <td>{{++$count}}</td>
                      <td>{{strtoupper($index['employee']->emp_name)}} : {{$index['employee']->emp_code}}</td>
                      <td>{{ucwords($index['section']->name)}}</td>
                      <td>{{ucwords($index['head']->head)}}</td>
                      <td>{{$index->year_from}}-{{$index->year_to}}</td>
                      <td>{{ucwords($index->exemption_amt)}}</td>
                      <td>{{ucwords($index->incom_other_src)}}</td>
                      <td>{{ucwords($index->notes)}}</td>
                      <td>
                        <div class="row">
                          <div class="col" align="center">
                            <a href="{{route('chapter6-exemption.edit', $index->id)}}" class="btn btn-sm btn-info">EDIT</a>
                          </div>
                          <div class="col" align="left">
                            <form  action="{{route('chapter6-exemption.destroy',$index->id)}}" method="POST" id="delform_{{ $index->id}}">
                              @csrf
                              @method('DELETE')
                              <a href="javascript:$('#delform_{{ $index->id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">DELETE</a>
                            </form>
                          </div>
                        </div>
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
<script>
$(document).ready(function(){

   $('#ExemptionTable').dataTable( {
            "ordering":   true,
            order   : [[1, 'asc']],
            "columnDefs": [ 
                { "orderable": false, "targets": 0,  }
            ]
      });
});
</script>
@endsection