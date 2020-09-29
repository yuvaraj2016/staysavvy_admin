@extends('layouts.app')
@section('content')

@if(session('success') !== null)
    <div class='alert alert-success'>
        {{ session('success') }}
    </div>
@endif
@if(session('error') !== null)
    @foreach(session('error') as $k =>$v)
        <div class='alert alert-danger'>
            {{ $v[0] }}
        </div>
    @endforeach
@endif
<div class="section-header-button">
    <a href="{{ route('testimonials.create') }}" class="btn btn-primary">Add New</a>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Albums List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>

                                <th>Name</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Testimonials Picture</th>

                                <th>Created BY</th>
                                <th>Created At</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>


                            @foreach($testimonials as $testimonial )
                                @php
                                    $id=$testimonial['id'];
                                @endphp

                                <tr>

                                    <td><span class="text-center justify-content-center"
                                            style="padding-top:10px;">{{ $testimonial['testimonial_name'] }}</span>

                                    </td>
                                    <td>
                                        {{ $testimonial['testimonial_desc'] }}
                                    </td>
                                    <td>{{ $testimonial['testimonial_date'] }}</td>
                                    <td>
                                        <a href="#">
                                            <img alt="image"
                                                src="{{ config('global.storage') }}/testimonials_picture/{{ $testimonial['testimonial_image'] }}"
                                                class="rounded-circle" width="35" data-toggle="title" title="">
                                        </a>
                                    </td>

                                    <td>{{ $testimonial['created_by'] }}</td>
                                    <td>{{ $testimonial['created_at'] }}</td>
                                    <td>
                                        <div class="d-flex">

                                            {{-- <a href="{{ url('testimonials/'.$id) }}"
                                                class="badge badge-primary d-inline"><i
                                                    class="fas fa-eye"></i>View&nbsp;&nbsp;</a>&nbsp;&nbsp; --}}

                                            <a href="{{ url('testimonials/'.$id.'/edit') }}"
                                                class="badge badge-info d-inline"><i
                                                    class="fas fa-edit"></i>Edit&nbsp;&nbsp;</a>&nbsp;&nbsp;
                                            {{-- <meta name="csrf-token" content="{{ csrf_token() }}">
                                            <a href="{{ action('AlbumController@destroy', $id) }}"
                                                class="job-delete badge badge-danger d-inline"><i
                                                    class="fas fa-trash"></i>Deletes</a> --}}

                                            <form
                                                action="{{ route('testimonials.destroy',['testimonial'=>$id]) }}"
                                                method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit"class="job-delete badge badge-danger d-inline"><i
                                                    class="fas fa-trash"></i>Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
