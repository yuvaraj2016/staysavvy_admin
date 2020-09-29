@extends('layouts.app')
@section('content')





<style>
    #pagination li {

        display: inline-flex;
        float: left;
        margin-left: 10px;
        /* float:right; */
    }
</style>

<div class="page-wrapper">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>Bookings List</h4>
                        {{-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index-1.htm">
                                <i class="icofont icofont-home"></i>
                            </a>
                        </li>

                        <li class="breadcrumb-item"><a href="{{ route('booking.index') }}">Bookings List</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Page-header end -->
    <!-- Page body start -->
    <div class="page-body">
        <div class="row">
           @if(session('success') !== null)
            <div class='alert alert-success'>
                {{ session('success') }}
            </div>
            @endif
         

            @if(Session::has('error'))
                <div class="alert errorWrap">
                    {{session('error')}}
                </div>
            @endif

            <div class="col-sm-12">
                <!-- HTML5 Export Buttons table start -->
                <div class="card">

                    <div class="card-block mb-0 pb-0">
                        <div class="row justify-content-center">
                            <div class="col-sm-12 col-xl-2 m-b-30">
                                <p class="">Date of</p>
                                <select name="select" class="form-control">
                                    <option value="opt1">Check in</option>
                                    <option value="opt2">Type 2</option>
                                    <option value="opt3">Type 3</option>
                                    <option value="opt4">Type 4</option>
                                    <option value="opt5">Type 5</option>
                                    <option value="opt6">Type 6</option>
                                    <option value="opt7">Type 7</option>
                                    <option value="opt8">Type 8</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-xl-2 m-b-30">
                                <p class="">From</p>
                                <select name="select" class="form-control">
                                    <option value="opt1">Dates</option>
                                    <option value="opt2">Type 2</option>
                                    <option value="opt3">Type 3</option>
                                    <option value="opt4">Type 4</option>
                                    <option value="opt5">Type 5</option>
                                    <option value="opt6">Type 6</option>
                                    <option value="opt7">Type 7</option>
                                    <option value="opt8">Type 8</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-xl-2 m-b-30">
                                <p class="">Until</p>
                                <select name="select" class="form-control">
                                    <option value="opt1">Dates</option>
                                    <option value="opt2">Type 2</option>
                                    <option value="opt3">Type 3</option>
                                    <option value="opt4">Type 4</option>
                                    <option value="opt5">Type 5</option>
                                    <option value="opt6">Type 6</option>
                                    <option value="opt7">Type 7</option>
                                    <option value="opt8">Type 8</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-xl-2 m-b-30">
                                <p class="">Property</p>
                                <select name="select" class="form-control">
                                    <option value="opt1">All Properties</option>
                                    <option value="opt2">Type 2</option>
                                    <option value="opt3">Type 3</option>
                                    <option value="opt4">Type 4</option>
                                    <option value="opt5">Type 5</option>
                                    <option value="opt6">Type 6</option>
                                    <option value="opt7">Type 7</option>
                                    <option value="opt8">Type 8</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-xl-2 m-b-30">
                    
                               <button type="submit" class="btn btn-primary" style="margin-top:45px;">Submit</button>
                          
                            </div>
                        </div>
                    </div>

                    <div class="card-header table-card-header">
                        <div class="row">
                            <div class="section-header-button col-md-4">
                                <a href="{{ route('bookings.create') }}" class="btn btn-primary" style="padding-top:7px; padding-bottom:7px;border-radius:30px">Add New</a>
                            </div>
                            <div class="section-header-button col-md-5">

                            </div>
                            <div class="section-header-button col-md-3 ">
                                <div class="col">
                                <ul id="pagination" class="float-right m-0 p-0">
                                        <li><a href="{{ route('booking.index',$page=1) }}" class="btn btn-primary @if($pagination['current_page']==1) {{ "disabled" }} @endif">First</a></li>
                                        @php
                                        if(isset($pagination['links']['previous']))
                                        {
                                        # code...
                                        $endurl = explode("?page=",$pagination['links']['previous']);
                                        $page = $endurl[1];

                                        @endphp
                                        <li><a href="{{ route('booking.index',$page) }}" class="btn btn-primary">Previous</a></li>
                                        @php
                                        }
                                        @endphp


                                        {{-- @for($i = 1; $i <= $pagination['total_pages']; $i++)
                            <?php
                            // $isCurrentPage =  $pagination['current_page'] == $i;
                            ?>
                            <li class="{{ $isCurrentPage ? 'active' : '' }}" >
                                        
                                            {{ $i }}
                                        </a>
                                        </li>
                                        @endfor --}}



                                        @php
                                        if(isset($pagination['links']['next']))
                                        {
                                        $endurl = explode("?page=",$pagination['links']['next']);
                                        $page = $endurl[1];
                                        // echo
                                        @endphp
                                        <li> <a href="{{ route('booking.index',$page) }}" class="btn btn-primary">Next</a></li>
                                        @php
                                        }

                                        @endphp

                                        @php
                                        if($pagination['total_pages']>1)
                                        {
                                        @endphp
                                        <li> <a href="{{ route('booking.index',$pagination['total_pages']) }}" class="btn btn-primary float-right">Last</a> </li>

                                        @php
                                        }

                                        @endphp

                                    </ul>

                                    

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table id="basic-btn" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>Guest Name</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                        <th>Rooms</th>
                                        <th>Booked On</th>
                                        <th>Status</th>
                                        <th>Price</th>
                                        <th>Commission</th>
                                        <th>Property</th>
                                        <th>Booking Reference</th>
                                    </tr>
                                </thead>
                                <tbody>

{{-- @dd($prodcategories) --}}
@foreach($prodcategories as $prodcategory )
@php
$id=$prodcategory['id'];
@endphp

<tr>
<td><span class="text-center justify-content-center" style="padding-top:10px;">{{ $prodcategory['title'] }}</span>

    </td>
    <td><span class="text-center justify-content-center" style="padding-top:10px;">{{ $prodcategory['category_short_code'] }}</span>

    </td>
    <td>
        {{ $prodcategory['category_desc'] }}
    </td>
    {{-- <td>{{ dd($prodcategory['Assets']) }}</td> --}}
    <td align="center">

        <img src="{{ isset($prodcategory['Assets']['data'][0]['links']) ? $prodcategory['Assets']['data'][0]['links']['full'].'?width=52&height=52' : asset('img/no-image.gif')  }}" /></td>
    <td>{{ $prodcategory['status_desc'] }}</td>
    {{-- <td>
            <a href="#">
                <img alt="image"
                    src="{{ config('global.storage') }}/cover_pictures/{{ $album['cover_picture'] }}"
    class="rounded-circle" width="35" data-toggle="title" title="">
    </a>
    </td> --}}

    <td>{{ date("Y-m-d H:i:s",$prodcategory['created_at']) }}</td>
    <td>
        <div class="d-flex">
        <ul class="list-group list-inline ml-1">
  <li class="list-group-item border1"><a href="{{ url('bookings/'.$id) }}"
                        class=" d-inline font1 view-confirmation" data-toggle="tooltip" data-placement="top" title="View"><i
                            class="fa fa-eye"></i></a></li>
  <li class="list-group-item border1"><a href="{{ url('bookings/'.$id.'/edit') }}"
                        class=" d-inline text-center font1 edit-confirmation" data-toggle="tooltip" data-placement="top" title="Edit"><i
                            class="fa fa-edit" ></i></a></li>
  <!-- <li class="list-group-item border1"> <form
                    action="{{ route('bookings.destroy',$id) }}"
                    method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" style="background-color:#fff!important;position: relative;top:-1px!important; padding-top:3px!important;padding-bottom:8px!important;"
                        class=" job-delete d-inline font1" data-toggle="tooltip" data-placement="top" title="Delete" > <i
                            class="fa fa-trash" style="position: relative;top:-5;"></i></button>
                </form></li> -->


                <li class="list-group-item border1">
                                                    <form id="delete_from_{{$prodcategory['id']}}" method="POST" action="{{route('bookings.destroy', $prodcategory['id']) }}">
                    {{ csrf_field() }}
    {{ method_field('DELETE') }}

    <div class="form-group">
        <a href="javascript:void(0);" data-id="{{$prodcategory['id']}}" class="_delete_data"  data-toggle="tooltip" data-placement="top" title="Delete" style="background-color:#fff!important;position: relative;top:-1px!important; padding-top:3px!important;padding-bottom:8px!important;">
        <i class="fa fa-trash" style="position: relative;top:-5;color:#01a9ac"></i>
        </a>                    
    </div>
</form></li>
             

</ul>


     
        </div>
    </td>
</tr>
@endforeach
</tbody>
                            </table>


                        </div>


                    </div>
                </div>
                <!-- HTML5 Export Buttons end -->



            </div>
        </div>


     


    </div>
    <!-- Page body end -->
</div>






{{-- <script>
    $(function () {
        $('.job-delete').click(function (event) {
            var token = $("meta[name='csrf-token']").attr("content");
            event.preventDefault();
            event.stopPropagation();


            $.ajax({
                type: 'DELETE',
                url: $(this).attr('href'),
                data: {
                    "_token": token
                },
                success: function (response) {
                    alert('Deleted');
                    location.reload();
                }

            });
        });
    });

</script> --}}

</section>
@endsection