@extends('layouts.app')
@section('content')

{{-- <a href="{{ route('albums.index') }}">back</a> --}}
<div class="page-wrapper">

<div class="page-header m-t-50">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Create Room</h4>
                        {{-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                           
                                <i class="">Create Room</i>
                          
                        </li>
                      
                        <li class="breadcrumb-item"><a href="{{ route('rooms.index') }}">Rooms</a>
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
        <h1>Create Status</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('status.index') }}">Statuses</a></div>
            <div class="breadcrumb-item">Create Status</div>
        </div>
    </div> -->

    <div class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('rooms.store') }}" class="swa-confirm"  method="post" id="addstatus"
                            enctype="multipart/form-data">
                            @csrf

               
                            @if(session('success') !== null)
                            <div class="succWrap">
                            {{ session('success') }}
                            </div>
                                <!-- <div class='alert alert-success'>
                                    {{ session('success') }}
                                </div> -->
                            @endif

                            @if(session('error') !== null)

                                @foreach(session('error') as $v)
                                   @foreach($v as $e)

                                   <div class="errorWrap"><strong>ERROR</strong>:  {{ $e }} </div>

                                   <!-- <div class='alert alert-danger'>
                                       {{ $e }}
                                    </div> -->
                                   @endforeach

                                @endforeach
                            @endif

                            <!-- @if(session('success') !== null)
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
                            @endif -->
                            <!-- <div class="form-group row">
                                                        <div class="col-sm-4 offset-5">
                                                        <label class="col-form-label text-md-right ">Status Desc</label>
                                                        <textarea name="status_desc" class="summernote-simple form-control" required>{{ old('status_desc') }}</textarea>
                                                        </div>
                            </div> -->




                            <div class="form-group row ">
                            <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Property</label>
                                                        <select  class="js-example-basic-single col-sm-12" name="property_id" id="" placeholder="status" required class="form-control selectric" required>
                                        <option value="">Select</option>
                                        @foreach($property as $propertys)
                                            <option value="{{ $propertys['id'] }}" {{ (old("property_id") == $propertys['id'] ? "selected":"") }}>{{ $propertys['name'] }}</option>
                                        @endforeach
                                    </select>
                                                        </div>

                                                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Room Type</label>
                                                        <select  class="js-example-basic-single col-sm-12" name="room_type_id" id="" placeholder="status" required class="form-control selectric" required>
                                        <option value="">Select</option>
                                        @foreach($confRoomType as $confRoomTypes)
                                            <option value="{{ $confRoomTypes['id'] }}" {{ (old("room_type_id") == $confRoomTypes['id'] ? "selected":"") }}>{{ $confRoomTypes['name'] }}</option>
                                        @endforeach
                                    </select>
                                                        </div>
                          

                                                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">No Of Rooms</label>
                                                        <input type="number"  name="no_of_rooms" value="{{ old('no_of_rooms') }}" class="summernote-simple form-control" required>
               
                                                        </div>
                          
                            </div>

                            <div class="form-group row ">
                         

                                                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Available Rooms</label>
                                                        <input type="number" name="available_rooms" value="{{ old('available_rooms') }}" class="summernote-simple form-control" required>
               
                                                        </div>
                          

                                                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Max Adults</label>
                                                        <input type="number" name="max_adults" value="{{ old('max_adults') }}" class="summernote-simple form-control" required>
               
                                                        </div>


                                                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Max Children</label>
                                                        <input type="number" name="max_children" value="{{ old('max_children') }}" class="summernote-simple form-control" required>
               
                                                        </div>
                          
                            </div>





                            <div class="form-group row ">
                            

                                                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Max Occupancy</label>
                                                        <input type="number" name="max_occupancy" value="{{ old('max_occupancy') }}" class="summernote-simple form-control" required>
               
                                                        </div>

                                                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Room Location</label>
                                                        <input  name="room_location" value="{{ old('room_location') }}" class="summernote-simple form-control" required>
               
                                                        </div>
                                                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Amount</label>
                                                        <input type="number"  step="any" name="amount" value="{{ old('amount') }}" class="summernote-simple form-control" required>
               
                                                        </div>

                                                
                          
                            </div>







                            <div class="form-group row ">


                            <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Status</label>
                                                        <select  class="js-example-basic-single col-sm-12" name="status_id" id="" placeholder="status" required class="form-control selectric" required>
                                        <option value="">Select</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status['id'] }}" {{ (old("status_id") == $status['id'] ? "selected":"") }}>{{ $status['status_desc'] }}</option>
                                        @endforeach
                                    </select>
                                                        </div>
                        
 
                                                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Amenity</label>
                                                        <select  class="js-example-basic-single col-sm-12" name="amenities[]" id="" multiple placeholder="status" required class="form-control selectric" >
                                        <option value="">Select</option>
                                        @foreach($amenity as $amenitys)
                                            <option value="{{ $amenitys['id'] }}" {{ (old("id") == $amenitys['id'] ? "selected":"") }}>{{ $amenitys['name'] }}</option>
                                        @endforeach
                                    </select>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <label class="col-form-label text-md-right ">Room Image Picture</label>
                                                            <input type="file" name="file[]" id="filer_input" multiple="multiple" class="form-control">
                                                        </div>
                            </div>



                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right "></label>
                                <div class="col-sm-12 col-md-7 offset-5">
                                    <button type="submit" id="submit" class="btn btn-primary">Create Room</button>
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



