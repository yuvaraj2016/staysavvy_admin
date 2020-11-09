
@extends('layouts.app')
@section('content')


{{-- <a href="{{ route('albums.index') }}">back</a> --}}
<div class="page-wrapper">

<div class="page-header m-t-50">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Edit Room</h4>
                        {{-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                           
                                <i class="">Edit Room</i>
                          
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
                        



                        <form class="dropzone" action="{{route('rooms.update',['room'=>$rooms['id']]) }}" method="post" id="addprocat"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            @if(session('success') !== null)
                            <div class="succWrap">
                            {{ session('success') }}
                            </div>
                                <!-- <div class='alert alert-success'>
                                    {{ session('success') }}
                                </div> -->
                            @endif

                         

                            <!-- @if(session('success') !== null)
                                <div class='alert alert-green'>
                                    {{ session('success') }}
                                </div>
                            @endif -->
                            @if(session('error') !== null)

                            {{-- @foreach(session('error') as $v)
                               @foreach($v as $e)
                               <div class='alert alert-red'>
                                   {{ $e }}
                                </div>
                               @endforeach

                            @endforeach --}}
                            <div class='alert alert-red'>
                                {{ session('error') }}
                             </div>
                        @endif
                        <div class="form-group row ">
                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Property</label>
                                                        <select  class="js-example-basic-single col-sm-12" name="property_id" id="" placeholder="status" required class="form-control selectric" required>
                                        <option value="">Select</option>
                                        @foreach($property as $propertys)
                                            <option value="{{ $propertys['id'] }}" {{ ($rooms['property_id'] == $propertys['id']) ? "selected":(old("property_id") == $propertys['id'] ? "selected":"") }}>{{ $propertys['name'] }}</option>
                                            @endforeach
                                    </select>
                                                        </div>

                                                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Room Type</label>
                                                        <select  class="js-example-basic-single col-sm-12" name="room_type_id" id="" placeholder="status" required class="form-control selectric" required>
                                        <option value="">Select</option>
                                        @foreach($confRoomType as $confRoomTypes)
                                            <option value="{{ $confRoomTypes['id'] }}" {{ ($rooms['room_type_id'] == $confRoomTypes['id']) ? "selected":(old("room_type_id") == $confRoomTypes['id'] ? "selected":"") }}>{{ $confRoomTypes['name'] }}</option>
                                            @endforeach
                                    </select>
                                                        </div>
                          

                                                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">No Of Rooms</label>
                                                        <input type="number" id="" name="no_of_rooms" value="{{ old('no_of_rooms',$rooms['no_of_rooms']) }}" class="form-control" required>
               
                                                        </div>
                          
                            </div>



                            <div class="form-group row ">
                           

                                                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Available Rooms</label>
                                                        <input type="number" id="" name="available_rooms" value="{{ old('available_rooms',$rooms['available_rooms']) }}" class="form-control" required>
               
                                                        </div>
                          

                                                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Max Adults</label>
                                                        <input type="number" id="" name="max_adults" value="{{ old('max_adults',$rooms['max_adults']) }}" class="form-control" required>
                                                        </div>

                                                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Max Children</label>
                                                        <input type="number" id="" name="max_children" value="{{ old('max_children',$rooms['max_children']) }}" class="form-control" required>
                                                        </div>
                          
                            </div>




                            <div class="form-group row ">
                            <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Max Occupancy</label>
                                                        <input type="number" id="" name="max_occupancy" value="{{ old('max_occupancy',$rooms['max_occupancy']) }}" class="form-control" required>

                                                        </div>

                                                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Room Location</label>
                                                        <input  id="" name="room_location" value="{{ old('room_location',$rooms['room_location']) }}" class="form-control" required>

                                                        </div>
                          
                                                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Amount</label>
                                                        <input  id="" name="amount" value="{{ old('amount',$rooms['amount']) }}" class="form-control" required>

                                                        </div>
                             
                          
                            </div>
               

                                                    

                                              
                            <div class="form-group row ">

                            <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Status</label>
                                                        <select  class="js-example-basic-single col-sm-12" name="status_id" id="" placeholder="status" required class="form-control selectric" required>
                                        <option value="">Select</option>
                                        @foreach($statuses as $status)
                                        <option value="{{ $status['id'] }}" {{ ($rooms['status_id'] == $status['id']) ? "selected":(old("status_id") == $status['id'] ? "selected":"") }}>{{ $status['status_desc'] }}</option>

                                        @endforeach
                                    </select>
                                                        </div>
                        


                                                    @php

$amenid = [];

foreach($rooms['Amenities']['data'] as $amenityid)
{

    $amenid[] = $amenityid['id'];
}
@endphp

                                                    <div class="col-sm-4">
                                                    <label class="col-form-label text-md-right ">Amenity</label>
                                                    <select  class="js-example-basic-single col-sm-12" name="amenities[]" id="" multiple placeholder="status" required class="form-control selectric" >
                                    <option value="">Select</option>
                                    @foreach($amenity as $amenitys)
                                     
                                   
                                    <option value="{{ $amenitys['id'] }}" {{ (collect($amenid)->contains($amenitys['id'])) ? 'selected':((collect(old('amenitys'))->contains($amenitys['id'])) ? 'selected':'') }}>{{ $amenitys['name'] }}</option>
e
                                    
                                    @endforeach
                                </select>
                                                    </div>

                                                    <div class="col-sm-4">
                                                            <label class="col-form-label text-md-right ">Click below to edit images</label><br>
                                                            <a href="{{ url('rooms/'.$rooms['id'].'/edit/assets') }}" class="btn btn-blue">Edit Image</a>
                                                        </div>
                        </div>

                                                   
                                                  

                            

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right "></label>
                                <div class="col-sm-12 col-md-7 offset-5">
                                    <button type="submit" class="btn btn-blue">Update </button>
                                    <a href="{{ url('rooms_list') }}"
                                    class=" d-inline text-center btn btn-blue back" ><i
                                        class="icofont icofont-arrow-left" ></i>Back&nbsp;&nbsp;</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<script type="text/javascript">
	$(document).ready(function (e) {
        $('#formsubmit').on('click', function () {

        });
		$('#upload').on('click', function () {
			var form_data = new FormData();
			var ins = document.getElementById('filer_input').files.length;
			for (var x = 0; x < ins; x++) {
				form_data.append("file[]", document.getElementById('filer_input').files[x]);
            }
            // alert(form_data);
            $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
			$.ajax({
                url: "http://ecommerce-api.hridham.com/api/ProdCat/1",
                headers:'Authorization: Bearer ' // point to server-side PHP script 
                dataType: 'json', // what to expect back from the PHP script
                // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				cache: false,
				contentType: false,
				processData: false,
				data: {file:form_data},
				type: 'patch',
				success: function (response) {
                   
					$('#msg').html(response); // display success response from the PHP script
				},
				error: function (response) {
                    // alert(response.message);
               
                    console.log(response);
					$('#msg').html(response); // display error response from the PHP script
				}
			});
		});
    });
    

    $(document).ready(function(){
    $("#formsubmit").click(function(){        
        $("#myForm").submit(); // Submit the form
    });
});


</script>

