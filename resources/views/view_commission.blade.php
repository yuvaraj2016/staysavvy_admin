@extends('layouts.app')
@section('content')

{{-- <a href="{{ route('albums.index') }}">back</a> --}}
<div class="page-wrapper">

<div class="page-header m-t-50">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>View Booking Commission</h4>
                        {{-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                           
                                <i class="">View Booking Commission</i>
                          
                        </li>
                      
                        <li class="breadcrumb-item"><a href="{{ route('commission.index') }}">Booking Commission</a>
                        </li>
                       
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">




<section class="section" >
    <!-- <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('status.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i>&nbsp;<b>Back</b></a>
        </div>
        <h1>View Status</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('status.index') }}">Statuses</a></div>
            <div class="breadcrumb-item">View Status</div>
        </div>
    </div> -->

    <div class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('commission.store') }}" method="post" id="addstatus"
                            enctype="multipart/form-data">
                            @csrf
                            @if(session('success') !== null)
                                <div class='alert alert-success'>
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if(session('error') !== null)

                                @foreach(session('error') as $v)
                                   @foreach($v as $e)
                                   <div class='alert alert-danger'>
                                       {{ $e }}
                                    </div>
                                   @endforeach

                                @endforeach
                            @endif

                            <div class="form-group row">

                            <div class="col-sm-4 ">
                                                        <label class="col-form-label text-md-right ">Property Name</label>
                                                        <input type="text"  value="   {{ $confCommission['property_name'] }}" class="form-control" readonly>
                                                        </div>
                                                        <div class="col-sm-4 ">
                                                        <label class="col-form-label text-md-right ">From</label>
                                                        <input type="text"  value="   {{ $confCommission['from'] }}" class="form-control" readonly>
                                                        </div>
                                                  
<div class="col-sm-4 ">
                            <label class="col-form-label text-md-right ">To</label>
                            <input type="text"  value="   {{ $confCommission['to'] }}" class="form-control" readonly>
                            </div>
                                         
                                                    </div>



                                                    <div class="form-group row">

<div class="col-sm-4 ">
                            <label class="col-form-label text-md-right ">Percentage</label>
                            <input type="text"  value="   {{ $confCommission['percentage'] }}" class="form-control" readonly>
                            </div>
                            <div class="col-sm-4 ">
                            <label class="col-form-label text-md-right ">status Desc</label>
                            <input type="text"  value="   {{ $confCommission['status_desc'] }}" class="form-control" readonly>
                            </div>
                            <div class="col-sm-4 ">
                            <label class="col-form-label text-md-right ">Created At </label>
                            <input type="text"  value="    {{ date("Y-m-d H:i:s",$confCommission['created_at']) }}" class="form-control" readonly>
              
                            </div>
             
                        </div>




                       

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    </div>
</div>
@endsection



