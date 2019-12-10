@extends('layouts.master')
@section('content')
<main class="app-content">
	<div class="row">
		<div class="col-md-12 col-xl-12">
			<h1 style="font-size: 24px">Leave Allotments
                {{-- <a href="{{ route('allotments.index') }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a> --}}
                {{-- <span class="ml-2">
                    <a href="{{route('types.create')}}" class="btn btn-sm btn-success" style="font-size: 13px">
                    <span class="fa fa-plus "></span> Add New</a>
                </span> --}}
			</h1>
			<hr>
		</div>
	</div>
	
	<div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card shadow-xs">
                <div class="card-body table-responsive">
                    @if($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{$message}}
                        </div>
                    @endif
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Name</th>
                                <th>Starts</th>
                                <th>Ends</th>
                                <th>Leaves</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $count = 0; @endphp
                            @foreach($allotments as $index)
                                <tr class="text-center">
                                    <td>{{++$count}}</td>
                                    <td>{{$index->emp_name}}</td>
                                    <td>{{$index['allotments'][0]->start}}</td>
                                    <td>{{$index['allotments'][0]->end}}</td>
                                    <td>
                                      @foreach($index->allotments as $leave)
                                        <div>{{$leave['leaves']->name}} <span style="float: right">{{$leave->current_bal}}</span></div>
                                      @endforeach
                                    </td>
                                    <td class='d-flex ' style="border-bottom:none">
                                      <span class="ml-2 text-center">
                                        <a href="{{route('allotments.edit', $index->id)}}" class="btn btn-sm btn-success">EDIT</i></a>
                                      </span>
                                      <span class="ml-2">
                                        <form  action="{{route('allotments.destroy',$index->id)}}" method="POST" id="delform_{{ $index->id}}">
                                          @csrf
                                          @method('DELETE')
                                          <a href="javascript:$('#delform_{{ $index->id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">DELETE</a>
                                          </form>
                                        </span>
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
{{-- <script type="text/javascript">
    $(document).ready(function(){

        $('.modalType').on('click', function(e){
            e.preventDefault();
            var type_id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: 'types/'+type_id,
                /*data:{id:type_id},*/
                success:function(data){
                    $('#typeModal').modal('show');
                    $('#typeTable').html(data);
                }
            })
        });

    });
</script> --}}
@endsection