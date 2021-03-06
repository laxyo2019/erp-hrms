@extends('layouts.master')
@section('content')
	<main class="app-content">
		<div class="row">
      <div class="col-md-12 col-xl-12">
        <div class="card shadow-xs">
          <div class="col-md-12 col-xl-12" style="margin-top: 15px">
            <h1 style="font-size: 24px">Leave Types
              <a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
              @ability('hrms_admin', 'hrms_create')
              <span class="ml-2">
                  <a href="{{route('types.create')}}" class="btn btn-sm btn-success" style="font-size: 13px">
                  <span class="fa fa-plus "></span> Add New</a>
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
            <table class="table table-striped table-hover">
              <thead>
                  <tr class="text-center">
                    <th>#</th>
                    <th>Name</th>
                    <th>Leave Per Year</th>
                    <th>Carry</th>
                    @ability('hrms_admin', 'hrms-view|hrms-edit|hrms-delete')
                    <th>Actions</th>
                    @endability
                  </tr>
              </thead>
              <tbody>
                @php $count = 0; @endphp
                @foreach($leaves as $types)
                  <tr class="text-center">
                    <td>{{++$count}}</td>
                    <td>{{ucwords($types->name)}}</td>
                    <td>{{$types->total}}</td>
                    <td>
                      @if($types->carry_forward)
                        Yes
                      @else
                        No
                      @endif
                    </td>
                    @ability('hrms_admin', 'hrms-view|hrms-edit|hrms-delete')
                    <td class='d-flex' style="border-bottom:none">
                      @ability('hrms_admin', 'hrms-view')
                      <button class="btn btn-sm btn-info modalType" data-id="{{$types->id}}">
                        <i class="fa fa-eye" style="font-size: 12px"></i>
                      </button>
                      <div class="modal fade" id="typeModal" role="dialog">
                        <div class="modal-dialog modal-lg" >
                          <div class="modal-content" style="margin: auto;">
                            <div class="modal-header">
                              <h4 class="modal-title">Leave Type Detail</h4>
                            </div>
                            <div class="modal-body table-responsive" id="typeTable" style="padding: 1.5rem; ">
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      @endability
                      @ability('hrms_admin', 'hrms-edit')
                      <span class="ml-2">
                        <a href="{{route('types.edit', [$types->id])}}" class="btn btn-sm btn-success"><i class="fa fa-edit text-white" style="font-size: 12px;"></i></a>
                      </span>
                      @endability
                      @ability('hrms_admin', 'hrms-delete')
                      <span class="ml-2">
                        <form action="{{route('types.destroy', [$types->id])}}" method="POST" id="delform_{{ $types->id}}">
                            @csrf
                            @method('DELETE')
                          <a href="javascript:$('#delform_{{$types->id}}').submit();" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash text-white"  style="font-size: 12px;"></i></a>
                        </form>
                      </span>
                      @endability
                    </td>
                    @endability
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
</script>
@endsection