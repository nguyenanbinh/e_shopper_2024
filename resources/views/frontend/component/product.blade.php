<h2 class="title text-center">Features Items</h2>
@if(isset($products) && count($products))
@foreach ($products as $product)

<div class="col-sm-4">
    <div class="product-image-wrapper">
        <div class="single-products">
                <div class="productinfo text-center">
                    <img src="{{ $product->image_src }}" alt="" />
                    <h2>${{ $product->price }}</h2>
                    <p>{{ $product->name }}</p>
                    <a href="" id="add-to-cart" data-product-id="{{ $product->id}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                </div>
                <div class="product-overlay">
                    <div class="overlay-content">
                        <h2>${{ $product->price }}</h2>
                        <p><a href="{{ route('show-product', ['id' => $product->id]) }}">{{ $product->name }}</a></p>
                        <a href="#" id="add-to-cart" data-product-id="{{ $product->id }}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                    </div>
                </div>
                <img src="@if ($product->status == 0)
                            {{ asset('frontend/images/home/new.png') }}
                        @else
                            {{ asset('frontend/images/home/sale.png') }}
                        @endif"
                class="{{ $product->status ? 'sale' : 'new' }}"  alt="" />
        </div>
        <div class="choose">
            <ul class="nav nav-pills nav-justified">
                <li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                <li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
            </ul>
        </div>
    </div>
</div>
@endforeach

@else
    <h2>No products</h2>
@endif
<div class="clearfix"></div>
<div class="pagination-area">
    {!! $products->links('frontend.pagination.default') !!}
</div>

