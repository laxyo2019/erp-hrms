@extends('layouts.master')
@section('content')
  <main class="app-content">
      <div class="row">
      <div class="col-md-12 col-xl-12">
        <div class="card shadow-xs">
          <div class="col-md-12 col-xl-12" style="margin-top: 15px"> 
              <h1 style="font-size: 24px">Item Request</h1>
          </div>
          <div class="card-body table-responsive">
            @if($message = Session::get('success'))
              <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{$message}}
              </div>
            @endif
            <table class="table table-striped table-hover" id="IndentRequestTable">
              <thead>
                <tr class="text-center">
                  <th>#</th>
                  <th>EMPLOYEE</th>
                  <th>DEPARTMENT</th>
                  <th>DESCRIPTION</th>
                  <th>HR Remark</th>
                  <th>ACTIONS</th>
                </tr>
              </thead>
              <tbody>
            @php $count = 0; @endphp
              @foreach($records as $index)
              <tr class="text-center" id="indent_{{$index->id}}">
                <td>{{++$count}}</td>
                <td >{{strtoupper($index['employee']->emp_name)}} : {{$index['employee']->emp_code}}</td>
                <td>{{strtoupper($index['employee']['department']->name)}}</td>
                <td>{{$index->description}}</td>
                <td>
                    @if($index->reason == '')
                      N/A
                    @else
                      {{ucwords($index->reason)}}
                    @endif

                </td>
                <td>
                  @if($index->status == 0)
                    <button type="button" data-id="{{$index->id}}" class="btn btn-sm btn-success deleteRequest" value="1" id="apprvBtn_{{$index->id}}">APPROVE</button>
                    <button type="button" data-id="{{$index->id}}" class="btn btn-danger btn-sm deleteRequest" value="2" id="decBtn_{{$index->id}}">DECLINE</button>

                    <strong class="apprv_msg" id="apprv_msg_{{$index->id}}" style="display: none;" >APPROVED</strong>

                    <strong class="dec_msg" id="dec_msg_{{$index->id}}" style="display: none;" >DECLINED</strong>

                  @elseif($index->status == 1)
                    <strong class="apprv_msg">APPROVED</strong>
                  @elseif($index->status == 2)
                    <strong class="dec_msg">DECLINED</strong>
                  @endif
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
<script type="text/javascript">
$(document).ready(function(){

  $('#IndentRequestTable').dataTable( {
    "ordering":   true,
    order   : [[1, 'asc']],
    "columnDefs": [ 
      { "orderable": false, "targets": 0,  }
    ]
  });

  $('.deleteRequest').on('click', function(){

      var request_id = $(this).data('id');
      var value   = $(this).val();


      if(value == 2){

        var reason = prompt('Please mention reason here.');

      }else{
        var reason = null;
      }
      
     $.ajax({
        type: 'POST',
        url: '{{route('item.approval')}}',
        data: {'request_id': request_id, 'value': value, 'reason': reason},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success:function(res){

          $('#apprvBtn_'+request_id).hide()
          $('#decBtn_'+request_id).hide()
          if(res == 1){
            
            $('#apprv_msg_'+request_id).show();
          }else{
            $('#dec_msg_'+request_id).show()
          }
        }
      })

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
  .reverse
  {
    background: #3375ca;
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