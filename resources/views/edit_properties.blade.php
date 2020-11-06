
@extends('layouts.app')
@section('content')


{{-- <a href="{{ route('albums.index') }}">back</a> --}}
<div class="page-wrapper">

<div class="page-header m-t-50">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Edit Properties</h4>
                        {{-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                           
                                <i class="">Edit Properties</i>
                          
                        </li>
                      
                        <li class="breadcrumb-item"><a href="{{ route('properties.index') }}">Properties</a>
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
                        



                        <form class="dropzone" action="{{route('properties.update',['property'=>$properties['id']]) }}" method="post" id="addprocat"
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
                                                        <label class="col-form-label text-md-right ">Properties Name</label>
                                                        <input type="text" id="category_short_code" name="name" value="{{ old('name',$properties['name']) }}" class="form-control" required>
                                                        </div>

                                                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Properties Address</label>
                                                     
                                                        <input type="text" id="address" name="address" value="{{ old('address',$properties['address']) }}" class="form-control" required>
               
                                                        </div>
                          

                                                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Properties Location</label>
                                                        <input type="text" id="location" name="location" value="{{ old('location',$properties['location']) }}" class="form-control" required>
               
                                                        </div>
                          
                            </div>



                            <div class="form-group row ">
                            <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Host Type</label>
                                                        <select  class="js-example-basic-single col-sm-12" name="host_type_id" id="" placeholder="status" required class="form-control selectric" required>
                                        <option value="">Select</option>
                                        @foreach($host as $hosts)
                                            <option value="{{ $hosts['id'] }}" {{ ($properties['host_type_id'] == $hosts['id']) ? "selected":(old("host_type_id") == $hosts['id'] ? "selected":"") }}>{{ $hosts['name'] }}</option>
                                            @endforeach
                                    </select>
                                                        </div>

                                                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Properties System</label>
                                                        <input  id="property_mgmt_system" name="property_mgmt_system" value="{{ old('property_mgmt_system',$properties['property_mgmt_system']) }}" class="form-control" required>
               
                                                        </div>
                          

                                                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Central System</label>
                                                        <input  id="central_res_system" name="central_res_system" value="{{ old('central_res_system',$properties['central_res_system']) }}" class="form-control" required>
                                                        </div>
                          
                            </div>




                            <div class="form-group row ">
                            <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Property Type</label>
                                                        <select  class="js-example-basic-single col-sm-12" name="property_type_id" id="" placeholder="status" required class="form-control selectric" required>
                                        <option value="">Select</option>
                                        @foreach($property_type as $property_types)
                                            <option value="{{ $property_types['id'] }}" {{ ($properties['property_type_id'] == $property_types['id']) ? "selected":(old("property_type_id") == $property_types['id'] ? "selected":"") }}>{{ $property_types['name'] }}</option>
                                            @endforeach
                                    </select>
                                                        </div>

                                                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">General Desc</label>
                                                        <input  id="general_description" name="general_description" value="{{ old('general_description',$properties['general_description']) }}" class="form-control" required>

                                                        </div>
                          

                                                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Status</label>
                                                        <select  class="js-example-basic-single col-sm-12" name="status_id" id="" placeholder="status" required class="form-control selectric" required>
                                        <option value="">Select</option>
                                        @foreach($statuses as $status)
                                        <option value="{{ $status['id'] }}" {{ ($properties['status_id'] == $status['id']) ? "selected":(old("status_id") == $status['id'] ? "selected":"") }}>{{ $status['status_desc'] }}</option>

                                        @endforeach
                                    </select>
                                                        </div>
                          
                            </div>
               

                                                    

                                              
                            <div class="form-group row ">
                        
                         
@php

$taxids = [];

foreach($properties['Taxes']['data'] as $taxid)
{

    $taxids[] = $taxid['id'];
}
@endphp

                        <div class="col-sm-4">
                                                    <label class="col-form-label text-md-right ">Taxes</label>
                                                    <select  class="js-example-basic-single col-sm-12" name="taxes[]" id="" multiple required class="form-control selectric" required>
                                    <option value="">Select</option>
                                 

                                       
                                    @foreach($tax as $taxs)
                                                                    <option value="{{ $taxs['id'] }}" {{ (collect($taxids)->contains($taxs['id'])) ? 'selected':((collect(old('taxes'))->contains($taxs['id'])) ? 'selected':'') }}>{{ $taxs['name'] }}</option>
                                                                
                                                             
                                            
                                            
                                          
                                 
                                        @endforeach
                                </select>
                                <?php


                                ?>
                                                    </div>

                                                    @php

$amenid = [];

foreach($properties['Amenities']['data'] as $amenityid)
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
                                                            <a href="{{ url('properties/'.$properties['id'].'/edit/assets') }}" class="btn btn-blue">Edit Image</a>
                                                        </div>
                        </div>

                                                   
                                                  

                            

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right "></label>
                                <div class="col-sm-12 col-md-7 offset-5">
                                    <button type="submit" class="btn btn-blue">Update </button>
                                    <a href="{{ url('properties_list') }}"
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

