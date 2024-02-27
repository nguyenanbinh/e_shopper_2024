@extends('admin.layouts.app')


@section('content')

<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Brand List</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Brand</li>
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
                        <a href="{{ route('admin.brands.create') }}" class="btn btn-success">Add Brand</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($brands) && count($brands))
                                @foreach ($brands as $brand)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td>{{ $brand->name }}</td>
                                    <td>
                                        <a href="{{ route('admin.brands.destroy', ['brand' => $brand->id]) }}"
                                            class="btn btn-danger" onclick="event.preventDefault();
                                            document.getElementById('delete-brand-{{ $brand->id }}').submit();">
                                            Delete
                                        </a>
                                    </td>
                                    <form id="delete-brand-{{ $brand->id }}" action="{{ route('admin.brands.destroy', ['brand' => $brand->id]) }}"
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
