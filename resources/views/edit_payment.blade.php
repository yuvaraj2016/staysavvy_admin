
@extends('layouts.app')
@section('content')


{{-- <a href="{{ route('albums.index') }}">back</a> --}}
<div class="page-wrapper">

<div class="page-header m-t-50">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Edit Payment</h4>
                        {{-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                           
                                <i class="">Edit Status</i>
                          
                        </li>
                      
                        <li class="breadcrumb-item"><a href="{{ route('payment.index') }}">Payment</a>
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
                        



                        <form class="dropzone" action="{{route('payment.update',['payment'=>$payment['id']]) }}" method="post" id="editstatus"
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
                                                    <div class="col-sm-4 offset-1">
                                                        <label class="col-form-label text-md-right"> Title</label>
                                                      
                                                            <input value="{{ old('title',$payment['title']) }}" name="title" class="summernote-simple form-control" required>
                                                        </div>

                                                    <div class="col-sm-4 offset-1">
                                                        <label class="col-form-label text-md-right">Payment Status Desc</label>
                                                      
                                                            <textarea name="payment_status_desc" class="summernote-simple form-control" required>{{ old('payment_status_desc',$payment['payment_status_desc']) }}</textarea>
                                                        </div>
                                                    </div>
                        

                                                    

                                                    {{-- <div class="form-group row">
                                                        <div class="col-sm-4 offset-1 card">
                                                            
                                                            <div class="card-header">
                                                                <h5>Files Already Uploaded</h5>
                                                             
                                                            </div>
                                                            <div class="card-block">


                                                              <div class="row mt-3">  

                                                               <div class="col-sm-6 my-auto">
                                                                <a href=""><img src="{{ isset($suppliercategory['Assets']['data'][0]['links']) ? $suppliercategory['Assets']['data'][0]['links']['full'].'?width=100&height=100' : asset('img/no-image.gif')  }}"/></a>
                                                               </div>

                                                               <div class="col-sm-6 my-auto">
                                                                   @php
                                                                  $uuid=  $suppliercategory['Assets']['data'][0]['id'];
                                                                   @endphp
                                                                <form id="myForm" action="{{ route('assets.destroy',['asset'=>$uuid]) }}"
                                                                method="POST">
                                                                @method('DELETE')
                                                                @csrf
                                                                <button id="formsubmit" type="button"
                                                                    class=" job-delete d-inline btn btn-danger font1" > <i
                                                                        class="icofont icofont-trash"></i>Delete</button>
                                                            </form>
                                                               
                                                               </div>

                                                             </div>     

                                                             <div class="row mt-3">  

                                                                <div class="col">
                                                                 <a href=""><img src="{{ isset($suppliercategory['Assets']['data'][0]['links']) ? $suppliercategory['Assets']['data'][0]['links']['full'].'?width=100&height=100' : asset('img/no-image.gif')  }}"/></a>
                                                                </div>
 
                                                                <div class="col">
                                                                 <a href="" class="btn btn-danger">Delete</a>
                                                                </div>
                                                                
                                                              </div>  


                                                            </div>

                                                        </div>
                                                        <div class="col-sm-4 offset-1 card">
                                                            
                                                            <div class="card-header">
                                                                <h5>File Upload</h5>
                                                                <div class="card-header-right">
                                                                    
                                                                    <ul class="list-unstyled card-option">
                                                                        <li><i class="feather icon-maximize full-card"></i></li>
                                                                        <li><i class="feather icon-minus minimize-card"></i></li>
                                                                        <li><i class="feather icon-trash-2 close-card"></i></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="card-block">
                                                                <p id="msg"></p>
                                                                <div class="sub-title">Category Image Picture</div>
                                                                <input type="file" name="file[]" id="filer_input" multiple="multiple" class="form-control">
                                                                <button id="upload" type="button">Upload</button>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                        {{-- <input type="file" name="files" data-fileuploader-files='[{"name":"stocksnap_4521.jpg","type":"image\/jpg","size":71135,"file":"{{ asset('files/assets/images/product/1.jpg') }}","local":"{{ asset('files/assets/images/product/1.jpg') }}","data":{"url":"{{ asset('files/assets/images/product/1.jpg') }}","thumbnail":"{{ asset('files/assets/images/product/1.jpg') }}","readerForce":true}}]'> --}}
                                                {{-- <div class="form-group row">
                                                       


                                                     

                                                      

                                         
                                                </div> --}}

                                                   
                                                  

                            

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right "></label>
                                <div class="col-sm-12 col-md-7 offset-5">
                                    <button type="submit" class="btn btn-blue">Update </button>
                                    <a href="{{ url('payment_list') }}"
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
{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

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
 --}}
