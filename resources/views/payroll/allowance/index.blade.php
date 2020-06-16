@extends('layouts.master')
{{-- CSS --}}
<link rel="stylesheet" href="{{asset('themes/vali/css/allowance.css')}}"></link>
@section('content')
<main class="app-content">
  <div style=" padding: 1.5rem; border: 1px solid white;background: white">
    <h1 style="font-size: 24px">Allowance<hr></h1>
      <div class="row">
        <div class="column mb-4">
          <div class="card" style="background-color: #889dd7; color:#fff" ><i class="fa fa-credit-card fa-3x" aria-hidden="true"></i></div>
          <a href="{{route('by-cadre.index')}}" style="color: #000">
            <div class="card " >By Cadre</div>
          </a>
        </div>
        <div class="column">
          <div class="card" style="background-color: #889dd7; color:#fff" ><i class="fa fa-cube fa-3x" aria-hidden="true"></i></div>
          <a href="{{route('by-department.index')}}" style="color: #000">
            <div class="card">By Department</div>
          </a>
        </div>
        <div class="column">
          <div class="card" style="background-color: #889dd7; color:#fff" ><i class="fa fa-id-badge fa-3x" aria-hidden="true"></i></div>
          <a href="{{route('by-designation.index')}}" style="color: #000">
            <div class="card">By Designation</div>
          </a>
        </div>
        <div class="column">
          <div class="card" style="background-color: #889dd7; color:#fff" ><i class="fa fa-users fa-3x" aria-hidden="true"></i></div>
          <a href="{{route('by-employee.index')}}" style="color: #000">
            <div class="card">By Employee</div>
          </a>
        </div>
        <div class="column">
          <div class="card" style="background-color: #889dd7; color:#fff" ><i class="fa fa-compass fa-3x" aria-hidden="true"></i></div>
          <a href="{{route('by-site.index')}}" style="color: #000">
            <div class="card">By Site</div>
          </a>
        </div>
      </div> 
  </div><br>
</main>

@endsection
