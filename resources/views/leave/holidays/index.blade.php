@extends('layouts.master')
@section('content')
<main class="app-content">
	 <div class="row mt-2">
            <div class="col-md-12 col-xl-12">
                <h1 style="font-size: 20px">Company Holidays 
                    <a href="{{route('holidays.create')}}" class="btn btn-sm btn-success" style="font-size:13px">
                        <span class="fa fa-plus"></span> Add holiday</a>

                    <a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right" style="font-size:13px"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
                        <a href="{{route('export.holidays')}}" class="btn btn-sm btn-primary " style="font-size:13px">Export
                            <span class="fa fa-cloud-download"></span></a>
                        <form method="POST" action="{{route('import.holidays')}}" enctype="multipart/form-data">
                            @csrf
                            <input type="file" id="FileUpload" style="display: none" onchange="form.submit()" name="import" />
                            <input type="button" id="btnFileUpload" value="Import" class="btn btn-primary btn-sm" />
                        </form>
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
                                <th>TITLE</th>
                                <th>DATE</th>
                                <th>DESCRIPTION</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $count = 0; @endphp
                            @foreach($holidays as $index)
                                <tr class="text-center">
                                    <td>{{++$count}}</td>
                                    <td>{{$index->title}}</td>
                                    <td>{{$index->date}}</td>
                                    <td>{{$index->desc}}</td>
                                    <td class='d-flex' style="border-bottom:none">
                                      <span class="ml-2 text-center">
                                        <a href="{{route('holidays.edit', $index->id)}}" class="btn btn-sm btn-success"><i class="fa fa-edit text-white" style="font-size: 12px;"></i></a>
                                      </span>
                                      <span class="ml-2">
                                    <form  action="{{route('holidays.destroy',$index->id)}}" method="POST" id="delform_{{ $index->id}}">
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
<script type="text/javascript">
    $(document).ready(function(){

       $('#btnFileUpload').on('click', function(){
            $('#FileUpload').trigger('click');

        });

    });
</script>
@endsection