<div class="row card-body text-center">
	<div class="col-6" >
		<h5>Name </h5>
		<div>{{ucwords($nodues['employee']->emp_name)}}</div>
	</div>
	<div class="col-6" >
		<h5>Work Period </h5>
		<div>{{$nodues->date_join}} to {{$nodues->date_leave}}</div>
	</div>
</div>
<div class="row card-body text-center">
	<div class="col-6" >
		<h5>Assets & Articles Description</h5>
		<div>{{ucwords($nodues->assets_description)}}</div>
	</div>
	<div class="col-6" >
		<h5>Reason of Resignation</h5>
		<div>{{ucwords($nodues->reason_of_leaving)}}</div>
	</div>
</div>
<h5>Hod Approval Detail</h5><hr>

<table class="table table-striped table-hover" id="RolesTable">
	<thead class="thead-dark">
		<tr class="text-center">
			<th>#</th>
	  		<th>Department Head</th>
	  		<th>Department</th>
	  		<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@php $count = 0; @endphp
		@foreach($hod as $index)
			<tr class="text-center">
				<td>{{++$count}}</td>
                <td>{{ucwords($index['employee']->emp_name)}}</td>
                <td>{{strtoupper($index['department']->name)}}</td>
                <td>
                	@if($index->action == 0)
                		@if($index->hod_user_id == Auth::id())

                			<strong class="apprv_msg" id="apprv_msg_{{$index->nodues_request_id}}" style="display: none;" >APPROVED</strong>
                    		<strong class="dec_msg" id="dec_msg_{{$index->nodues_request_id}}" style="display: none;" >DECLINED</strong>

                			<button type="button"  data-id="{{$index->nodues_request_id}}" class="btn btn-success btn-sm action" value="1" id="apprvBtn_{{$index->nodues_request_id}}"><i class="fa fa-check" aria-hidden="true"></i></button>
                			<button type="button" data-id="{{$index->nodues_request_id}}" class="btn btn-danger btn-sm ml-2 action decline" value="2" id="decBtn_{{$index->nodues_request_id}}"><i class="fa fa-times" aria-hidden="true"></i></button>
                		@else
							<strong style="color: grey;">PENDING</strong>
						@endif
					@elseif($index->action == 1)
						<strong style="color: #0cac0c;">APPROVED</strong>
					@elseif($index->action == 2)
						<strong style="color: #3375ca;">DECLINED</strong>
					@endif
              </td>
			</tr>
		@endforeach
	</tbody>
</table>
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
<script type="text/javascript">
$(document).ready(function(){

  // Approve/Decline requests.

  $('.action').on('click', function(){

    var action      = $(this).val();
    var request_id  = $(this).data('id');

    alert(action)
    $.ajax({
      type: 'POST',
      url: "{{route('no-dues-listing.store')}}",
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: {'action':action,request_id:request_id},

      success:function(res){
      	console.log(res);
        $('#apprvBtn_'+request_id).hide();
        $('#decBtn_'+request_id).hide();
        console.log(res)
        if(res == 1){
          
          $('#apprv_msg_'+request_id).show();    

        }else if(res == 2){

          $('#dec_msg_'+request_id).show();

        }
      }
    })
  });
});
</script>