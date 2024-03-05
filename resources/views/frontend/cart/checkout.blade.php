@extends('frontend.layouts.app')

@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="#">Home</a></li>
              <li class="active">Check out</li>
            </ol>
        </div><!--/breadcrums-->


        <div class="shopper-informations ">
            <div class="row">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-6">
                    <div class="shopper-info">
                        <p>Shopper Information</p>
                        @guest
                        <form>
                            <input type="text" name="name" placeholder="Display Name">
                            <input type="email" name="email" placeholder="User Name">
                            <input type="password" name="password" placeholder="Password">
                            <input type="password" name="password_confirmation" placeholder="Confirm password">
                            <input type="submit" value="Register">
                        </form>
                        @else
                            @php
                                $user = auth()->user();
                            @endphp
                            <!--profile-form-->
                            <form method="POST" action="{{ route('checkout') }}">
                                @csrf
                                <input type="text" name="name" value="{{ $user->name }}" placeholder="Display Name" >
                                <input type="email" name="email" value="{{ $user->email }}" placeholder="Display email" >
                                <input type="text" name="address" value="{{ $user->address }}" placeholder="Display address">
                                <input type="text" name="phone" value="{{ $user->phone }}" placeholder="Display phone">
                                <div class="form-group">
                                    <label for="">Avatar preview</label>
                                    <img src="{{ $user->avatar_src }}" alt="" width="100" height="100">
                                </div>
                                <input type="submit" class="btn btn-primary" value="Continue">

                            </form>
                        @endguest
                    </div>
                </div>

            </div>
        </div>
        <div class="review-payment">
            <h2>Review & Payment</h2>
        </div>

        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Item</td>
                        <td class="description"></td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($cart) && count($cart))
                    @foreach ($cart as $item)
                    <tr>
                        <td class="cart_product">
                            <a href=""><img src="{{ $item['image'] }}" width="100" height="100" alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{ $item['name'] }}</a></h4>
                            <p>Web ID: 08652_{{ $item['productId'] }}</p>
                        </td>
                        <td class="cart_price">
                            <p>${{ $item['price'] }}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <a class="cart_quantity_up" href=""> + </a>
                                <input class="cart_quantity_input" data-product-id="{{ $item['productId'] }}"
                                    type="text" name="quantity" value="{{ $item['qty'] }}" autocomplete="off" size="2">
                                <a class="cart_quantity_down" href=""> - </a>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">${{ $item['qty'] * $item['price'] }}</p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                    <tr>
                        <td colspan="4">&nbsp;</td>
                        <td colspan="2">
                            <table class="table table-condensed total-result">
                                <tr>
                                    <td>Cart Sub Total</td>
                                    <td>${{ $grandTotal }}</td>
                                </tr>

                                <tr class="shipping-cost">
                                    <td>Shipping Cost</td>
                                    <td>Free</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td><span>${{ $grandTotal }}</span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="payment-options">
                <span>
                    <label><input type="checkbox"> Direct Bank Transfer</label>
                </span>
                <span>
                    <label><input type="checkbox"> Check Payment</label>
                </span>
                <span>
                    <label><input type="checkbox"> Paypal</label>
                </span>
            </div>
    </div>
</section> <!--/#cart_items-->






@endsection
