@extends('layouts.master')
@section('content')
<main class="app-content">
	<div class="row">
            <div class="col-md-12 col-xl-12">
                <h1 style="font-size: 24px">Company Holidays
                    <span class="ml-2">
                        <a href="{{route('export.holidays')}}" class="btn btn-sm btn-primary" style="font-size:13px">
                            <span class="fa fa-download"></span> Export
                        </a>
                    </span>
                    <span class="ml-2">
                        <a href="{{route('holidays.create')}}" class="btn btn-sm btn-primary" style="font-size:13px">
                            <span class="fa fa-plus"></span> Add holiday
                        </a>
                    </span>
                    <span class="ml-2">
                        <form method="POST" action="{{route('import.holidays')}}" enctype="multipart/form-data">
                            @csrf
                            <input type="file" id="FileUpload" style="display: none" onchange="form.submit()" name="import" />
                            <input type="button" id="btnFileUpload" value="Import" class="btn btn-primary btn-sm" />
                        </form>
                    </span>
                </h1>
                <hr>
            </div>
        </div>
	@if($message = Session::get('success'))
		<div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{$message}}
        </div>
	@endif
	<div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card shadow-xs">
                <div class="card-body table-responsive">
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