@extends('layouts.master')
@section('content')
	<main class="app-content">
		<div class="row">
			<div class="col-md-12 col-xl-12">
				<h1 style="font-size: 20px">Master Entities
                    <a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right" style="font-size:13px"  style="{background-color: #e7e7e7; color: black;}" >Go Back</a>
					
				</h1>
				<hr>
			</div>
		</div>
		{{Request::segment(1)}}
		@if($message = Session::get('success'))
			<div class="alert alert-success alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>
				{{$message}}
			</div>
		@endif 
	<div class="row">
    @foreach($tables as $key => $val)
    	<div class="col-md-6 col-lg-3">
          		<a href="{{route('mast_entity.all',['db_table'=>$val['table_name']])}}" class="widget-small bg-white" style="color:#000">
          	<i class="icon {{$val['icon']}} fa-3x" style="background:{{$val['bg_color']}};color:#fff; margin: 6px"></i>
            <div class="info" style="padding-left: 0;">
              <h4>{{$val['display_name']}}</h4>
              <p><b>{{$val['count']}}</b></p>
            </div>
          </a>
      </div>
    @endforeach
  </div>
	</main>
	<style>
		a:hover{
			text-decoration:none;
			box-shadow: 5px 5px #888888;
			transition: all 0.5s;
		}
	</style>
@endsection