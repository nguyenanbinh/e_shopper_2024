@extends('frontend.layouts.app')
@section('content')
<section id="cart_items">
    <div class="container1">
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <th>#</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Action</th>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($products) && count($products))
                    @foreach ($products as $product)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td><img src="{{ $product->image_src }}" width="100" height="100" alt=""></td>
                        <td>{{ $product->price }}</td>
                        <td>
                            <a href="{{ route('account.edit-product', ['id' => $product->id]) }}" class="btn btn-warning">Edit</a>
                            <a href="" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach

                    @else
                    <tr>
                        <td colspan="5">
                            <h2 class="text-center">No products</h2>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <a href="{{ route('account.add-product') }}" class="btn btn-primary pull-right">Add new</a>
        </div>
    </div>

</section>
<!--/#cart_items-->


@endsection
