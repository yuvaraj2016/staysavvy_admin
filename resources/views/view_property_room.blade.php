@extends('layouts.app')
@section('content')

{{-- <a href="{{ route('albums.index') }}">back</a> --}}
<div class="page-wrapper">

<div class="page-header m-t-50">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>View Room List</h4>
                        {{-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                           
                                <i class="">View Room List</i>
                          
                        </li>
                      
                        <li class="breadcrumb-item"><a href="{{ route('rooms.index') }}">Room</a>
                        </li>
                       
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">




<section class="section" >
 

    <div class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('rooms.store') }}" method="post" id="addstatus"
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
                                                        <input type="text"  value="   {{ $proproom['property_name'] }}" class="form-control" readonly>
                                                        </div>
                                                        <div class="col-sm-4 ">
                                                        <label class="col-form-label text-md-right ">Room Type Name</label>
                                                        <input type="text"  value="   {{ $proproom['room_type_name'] }}" class="form-control" readonly>
                                                        </div>
                                                        <div class="col-sm-4 ">
                                                        <label class="col-form-label text-md-right ">No Of Rooms</label>
                                                        <input type="text"  value="   {{ $proproom['no_of_rooms'] }}" class="form-control" readonly>
                                                        </div>
                                         
                                                    </div>

                                                    <div class="form-group row">

<div class="col-sm-4 ">
                            <label class="col-form-label text-md-right ">Available Rooms</label>
                            <input type="text"  value="   {{ $proproom['available_rooms'] }}" class="form-control" readonly>
                            </div>
                            <div class="col-sm-4 ">
                            <label class="col-form-label text-md-right ">Max Adults</label>
                            <input type="text"  value="   {{ $proproom['max_adults'] }}" class="form-control" readonly>
                            </div>
                            <div class="col-sm-4 ">
                            <label class="col-form-label text-md-right ">Max Children</label>
                            <input type="text"  value="   {{ $proproom['max_children'] }}" class="form-control" readonly>
                            </div>
             
                        </div>



                        <div class="form-group row">

<div class="col-sm-4 ">
                            <label class="col-form-label text-md-right ">Max Occupancy</label>
                            <input type="text"  value="   {{ $proproom['max_occupancy'] }}" class="form-control" readonly>
                            </div>
                           
             
                      

                        <div class="col-sm-4 ">
                            <label class="col-form-label text-md-right ">Room Location</label>
                            <input type="text"  value="   {{ $proproom['room_location'] }}" class="form-control" readonly>
                            </div>
                            <div class="col-sm-4 ">
                            <label class="col-form-label text-md-right ">Amount</label>
                            <input type="text"  value="   {{ $proproom['amount'] }}" class="form-control" readonly>
                            </div>
             
                        </div>


                        <div class="form-group row">
                        <!-- status_desc -->
                        <div class="col-sm-4 ">
                            <label class="col-form-label text-md-right ">Status</label>
                            <input type="text"  value="   {{ $proproom['status_desc'] }}" class="form-control" readonly>
                            </div>
<!-- <div class="col-sm-4 ">
                            <img src="{{ isset($proproom['Assets']['data'][0]['links']['thumb']) ? $proproom['Assets']['data'][0]['links']['thumb'].'?width=200&height=200' : asset('img/no-image.gif')  }}"/>
                            </div> -->
                            <div class="col-sm-4 ">
                            <label class="col-form-label text-md-right ">Created At </label>
                            <input type="text"  value="    {{ date("Y-m-d H:i:s",$proproom['created_at']) }}" class="form-control" readonly>
              
                            </div>
             
                        </div>








                           

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                     

                            <div class="form-group row">

                            <div class="col ">
                            @foreach($proproom['Assets']['data'] as $propr)
                            <!-- <label class="col-form-label text-md-right ">Property Image</label> -->
                            <img src="{{ isset($propr['links']['thumb']) ? $propr['links']['thumb'].'?width=200&height=200' : asset('img/no-image.gif')  }}"/>
                        @endforeach  
                                                        </div>
                                                   
                                         
                                                    </div>
                                                          
                                            

                    </div>
                </div>
            </div>
        </div>



    </div>
</div>
@endsection



