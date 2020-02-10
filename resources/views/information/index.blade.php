@extends('layouts.master')
@section('content')
<main class="app-content">
    <div class="app-title">
        <div class="row">
          <h4>User Information - &nbsp{{ucwords($info->emp_name)}}</h4>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Dashboard </a> </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <section class="invoice">
                    <div class="container-fluid">
                        <div class="post-media">  
                            <div class="row mb-4">
                                <div class="col-md">
                                    <form method="GET" action="{{route('information.edit', $info->user_id)}}">
                                        <input type="submit" class="btn btn-info btn-sm " value="Update Info">
                                    </form>
                                </div>
                                <p class="text-muted"><small>{{!empty($info['department']) ? ucwords($info['department']->name) : ''}}</small></p>
                            </div>
                        </div>
                        <div id="form-area">
                            <div class="row col-12">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for=""><b>Full Name - </b></label>
                                        <td>{{ucwords($info->emp_name)}}</td>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class=" form-group">
                                        <label for=""><b>Date of Birth - </b></label>
                                        <td>{{empty($info->emp_dob) ? '' : $info->emp_dob}}</td>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class=" form-group">
                                        <label for=""><b>Gender - </b></label>
                                        <td>{{empty($info->emp_gender) ? '' : $info->emp_gender}}</td>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <section class="invoice">
                    <div class="container-fluid">
                        <div class="post-media">  
                            <div class="row mb-4">
                                <div class="col">
                                    <h4 class="page-header"> CONTACT INFORMATION</h4>
                                </div>
                            </div>
                        </div>
                        <div id="form-area">
                            <div class="row col-12">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for=""><b>Contact Number - </b></label>
                                        <td>{{ !empty($info->contact) ? $info->contact : ''}}</td>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class=" form-group">
                                        <label for=""><b>Email - </b></label>
                                        <td>{{ !empty($info->email) ? $info->email : ''}}</td>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class=" form-group">
                                        <label for=""><b>Current Residence - </b></label>
                                        <td>{{ !empty($info->curr_addr) ? $info->curr_addr : ''}}</td>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</main>
@endsection
