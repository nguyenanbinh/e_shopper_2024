@extends('frontend.layouts.app')

@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Shopping Cart</li>
            </ol>
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
                    @else
                    <tr>
                        <td colspan="4">No items in cart</td>
                    </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr class="text-right">
                        <td colspan="5">
                            <h3>Total: <span id="total_price">$
                                    <?= $grandTotal ?>
                                </span></h3>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</section>
<!--/#cart_items-->

<section id="do_action">
    <div class="container">
        <div class="heading">
            <h3>What would you like to do next?</h3>
            <p>Choose if you have a discount code or reward points you want to use or would like to estimate your
                delivery cost.</p>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="chose_area">
                    <ul class="user_option">
                        <li>
                            <input type="checkbox">
                            <label>Use Coupon Code</label>
                        </li>
                        <li>
                            <input type="checkbox">
                            <label>Use Gift Voucher</label>
                        </li>
                        <li>
                            <input type="checkbox">
                            <label>Estimate Shipping & Taxes</label>
                        </li>
                    </ul>
                    <ul class="user_info">
                        <li class="single_field">
                            <label>Country:</label>
                            <select>
                                <option>United States</option>
                                <option>Bangladesh</option>
                                <option>UK</option>
                                <option>India</option>
                                <option>Pakistan</option>
                                <option>Ucrane</option>
                                <option>Canada</option>
                                <option>Dubai</option>
                            </select>

                        </li>
                        <li class="single_field">
                            <label>Region / State:</label>
                            <select>
                                <option>Select</option>
                                <option>Dhaka</option>
                                <option>London</option>
                                <option>Dillih</option>
                                <option>Lahore</option>
                                <option>Alaska</option>
                                <option>Canada</option>
                                <option>Dubai</option>
                            </select>

                        </li>
                        <li class="single_field zip-field">
                            <label>Zip Code:</label>
                            <input type="text">
                        </li>
                    </ul>
                    <a class="btn btn-default update" href="">Get Quotes</a>
                    <a class="btn btn-default check_out" href="">Continue</a>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="total_area">
                    <ul>
                        <li>Cart Sub Total <span>$59</span></li>
                        <li>Eco Tax <span>$2</span></li>
                        <li>Shipping Cost <span>Free</span></li>
                        <li>Total <span>$61</span></li>
                    </ul>
                    <a class="btn btn-default update" href="">Update</a>
                    <a class="btn btn-default check_out" href="">Check Out</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/#do_action-->



@endsection

@push('scripts')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    $(document).ready(function () {

        $('.cart_quantity_up').click(function (e) {
            e.preventDefault();
            var product = getProduct(this);
            var productId = product['productId'];
            var qtyInput = product['qty'];
            var currentPrice = product['price'];
            var totalPriceElement = product['totalPriceElement'];

            $.ajax({
                method: "POST",
                url: "{{ route('up-qty') }}",
                data: {
                    productId
                },
                success: function (res) {
                    // ket qua ben php tra ve lai
                    var qtyVal =  updateQuantity(qtyInput, 'up');
                    // // thay doi qty
                    qtyInput.val(qtyVal);
                    // // tinh lai tong cua item
                    var newTotal = parseInt(currentPrice) * qtyVal;
                    totalPriceElement.text(`$${newTotal}`);
                    // // tinh lai grand total
                    var grandTotal = parseInt(res.grandTotal)
                    $('#total_price').text(`$${grandTotal}`)
                },
                error: function (xhr, status, err) {
                    console.log(err);
                }
            });
        });

        $('.cart_quantity_down').click(function (e) {
            e.preventDefault();
            var product = getProduct(this);
            var productId = product['productId'];
            var qtyInput = product['qty'];
            var currentPrice = product['price'];
            var totalPriceElement = product['totalPriceElement'];

            $.ajax({
                method: "POST",
                url: "{{ route('down-qty') }}",
                data: {
                    productId
                },
                success: function (res) {
                    // ket qua ben php tra ve lai
                    var qtyVal =  updateQuantity(qtyInput, 'down');
                    // // thay doi qty
                    qtyInput.val(qtyVal);
                    // // tinh lai tong cua item
                    var newTotal = parseInt(currentPrice) * qtyVal;
                    var grandTotal = parseInt(res.grandTotal);

                    totalPriceElement.text(`$${newTotal}`);
                    if(grandTotal > 0) {
                        $('#total_price').text(`$${grandTotal}`)
                    }
                },
                error: function (err) {
                    console.log(err)
                }
            });
        });

        $('.cart_quantity_delete').click(function (e) {
            e.preventDefault();
            var d =  $(this).closest('tr')
            var deleteEle = $(this).closest('tr').find('.cart_quantity_input');
            var product = getProduct(deleteEle);
            var price = product.price * 1;
            var qty = product.qty.val() * 1;
            var productId = product.productId;

            if (confirm('Do you want to delete this item?')) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('delete-cart') }}",
                    data: {
                        productId
                    },
                    success: function (response) {
                        var grandTotal = response.grandTotal;
                        var itemTotal = price * qty;
                        d.remove();
                        $('#total_price').text(grandTotal);
                        var cartLength = Object.keys(response.cart).length;
                        cartCount(cartLength);
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });
            }
        });

        function getProduct (ele) {
            var cartItemContainer = $(ele).closest('.cart_quantity_button');
            var quantityInput = cartItemContainer.find('.cart_quantity_input');
            var productId = quantityInput.data('product-id');
            var qty = quantityInput;
            var parentRow = $(ele).closest('tr');
            var cartPriceElement = parentRow.find('.cart_price');
            var price = cartPriceElement.text().trim().substring(1);
            var cartTotalElement = parentRow.find('.cart_total');
            var totalPriceElement = cartTotalElement.find('.cart_total_price');

            return {
                productId,
                qty,
                price,
                totalPriceElement
            };
        }

        function updateQuantity(element, operation) {
            var qtyVal = parseInt(element.val())
            if (operation === 'up') {
                qtyVal += 1
            } else if (operation === 'down' && qtyVal > 0) {
                qtyVal -= 1
            } else {
                qtyVal = 0
            }

            return qtyVal
        }

        function cartCount (num) {
            var cartListItem = $('.nav.navbar-nav li:has(a[href="{{ route('show-cart') }}"])');

            // Update the text inside the <a> tag
            cartListItem.find('a').html(`<i class="fa fa-shopping-cart"></i> Cart(${num})`);
        }
    });

</script>
@endpush
