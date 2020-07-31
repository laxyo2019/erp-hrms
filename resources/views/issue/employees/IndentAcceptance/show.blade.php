<br><h4>Indent Request</h4><hr>
<table class="table table-striped table-hover table-bordered" id="RequestTable">
	<thead class="thead-dark">
		<tr>
			<th class="text-center">#</th>
			<th class="text-center">Request Detail</th>
			<th class="text-center">Status</th>
			<th class="text-center">Action</th>
		</tr>
	</thead>
	@php $count = 0; @endphp
	<tbody id="experiencesTbody">
		@foreach($myrequest as $index)
			<tr class="text-center" id="row_{{$index->id}}">
				<td>{{++$count}}</td>
				<td>{{$index->description}}</td>
				<td>
					@if($index->status == 0)
						<strong style="color: grey;">PENDING</strong>
					@elseif($index->status == 1)
						<strong style="color: #0cac0c;">APPROVED</strong>
					@elseif($index->status == 2)
						<strong style="color: #3375ca;">DECLINED</strong>
					@endif
				</td>
				<td>
					@if($index->status == 0)
						<button type="button" class="btn btn-danger btn-sm ml-2 delete" value="2" data-id="{{$index->id}}"  id="decBtn_{{$index->id}}">DELETE</button>
					@endif
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
<script type="text/javascript">
$(document).ready(function(){

	$('#RequestTable').dataTable( {
    	"ordering":   true,
    	order   : [[1, 'asc']],
    	"columnDefs": [ 
      		{ "orderable": false, "targets": 0,  }
   		]
  	});

  	$('.delete').on('click', function(){

		var request_id 	= $(this).data('id');

		if(confirm('Are you sure?') == true){

			$.ajax({
			type: 'DELETE',
			url: "/issue/my-indent/"+request_id,
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				success:function(res){

					$('#row_'+request_id).hide();


				}
			})
		}

		
  	});
});
</script>