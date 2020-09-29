@extends('layouts.app')
@section('content')

{{-- <a href="{{ route('albums.index') }}">back</a> --}}
<div class="page-wrapper">

<div class="page-header m-t-50">
        <div class="row align-Users-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Change Password</h4>
                        {{-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-User">
                           
                                <i class="">change Password</i>
                          
                        </li>
                      
                      
                        <li class="breadcrumb-item"><a href="{{ route('profile.index') }}">show profile</a>
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

                    <form class="dropzone" action="{{route('update_password')}}" method="post" id="editprosubcat"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf



                       
                            @if(session('success') !== null)
                                <div class='alert alert-success'>
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if(session('error') !== null)
                            <div class='alert alert-red'>
                                {{ session('error') }}
                             </div>
                            @endif
                            <div class="form-group row">
                                                      


                                                        <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Current Password</label>
                                                        <input type="password" name="current_password" value="{{ old('current_password') }}" class="summernote-simple form-control" required>
                                                        
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <label class="col-form-label text-md-right ">Password</label>
                                                            <input type="password" name="password" id="password" minlength=8 value="{{ old('password') }}" class="summernote-simple form-control" required>
                                              
                                                       </div>

                                                       <div class="col-sm-4">
                                                        <label class="col-form-label text-md-right ">Confirm Password</label>
                                                        <input type="password" name="password_confirmation" id="confirm_password" minlength=8 value="{{ old('password_confirmation') }}" class="summernote-simple form-control" required>
                                          
                                                        </div>

                                           



           
                   
                                                </div>

                                                    
                              
                                                      

                                                       
                                                  









                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right "></label>
                                <div class="col-sm-12 col-md-7 offset-5">
                                    <button type="submit" class="btn btn-primary">Update</button>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script type="text/javascript">

$(function() {


    var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");

function validatePassword(){

  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Password And Confirm Password Must Be Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;

validatePassword;

});
</script>



