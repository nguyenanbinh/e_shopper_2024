@extends('admin.layouts.app')


@section('content')

<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Blog List</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Blog</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-sm-12 mb-2">
                        <a href="{{ route('admin.blogs.create') }}" class="btn btn-success">Add Blog</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($blogs) && count($blogs))
                                @foreach ($blogs as $blog)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td>{{ $blog->title }}</td>
                                    <td><img src="{{ $blog->image_src }}" alt="Image" width="50" height="50"></td>
                                    <td>{{ $blog->description }}</td>
                                    <td colspan="2">
                                        <a href="{{ route('admin.blogs.edit', ['blog' => $blog->id]) }}" class="btn btn-primary mb-2">Edit</a>
                                        <a href="{{ route('admin.blogs.destroy', ['blog' => $blog->id]) }}"
                                            class="btn btn-danger" onclick="event.preventDefault();
                                            document.getElementById('delete-blog-{{ $blog->id }}').submit();">
                                            Delete
                                        </a>
                                    </td>
                                    <form id="delete-blog-{{ $blog->id }}" action="{{ route('admin.blogs.destroy', ['blog' => $blog->id]) }}"
                                    method="post"
                                    class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="2" class="text-center"><h2>{{ __('No data') }}</h2></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right sidebar -->
        <!-- ============================================================== -->
        <!-- .right-sidebar -->
        <!-- ============================================================== -->
        <!-- End Right sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->


</div>


    @endsection
