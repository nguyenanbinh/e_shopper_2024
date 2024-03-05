<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    public function ajaxCart(Request $request)
    {
        $cart = session('cart', []);
        $productId = $request->product_id;

        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] += 1;
        } else {
            $product = Product::findOrFail($productId);
            $cart[$productId] = [
                'productId' => $productId,
                'qty' => 1,
                'price' => $product->price,
                'name' => $product->name,
                'image' => $product->image_src
            ];
        }

        session()->put('cart', $cart);
        return response()->json(['cart' => $cart]);
    }

    public function showCart()
    {
        $cart = session()->get('cart', []);
        $grandTotal = $this->calcGrandTotal($cart);

        return view('frontend.cart.index', compact('cart', 'grandTotal'));
    }

    public function upQty(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->productId;

        if (Arr::has($cart, $productId)) {
            $cart[$productId]['qty']  += 1;
        }

        session()->put('cart', $cart);
        $grandTotal = $this->calcGrandTotal($cart);

        return response()->json(['grandTotal' => $grandTotal]);
    }

    public function downQty(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->productId;

        if (Arr::has($cart, $productId)) {
            if ($cart[$productId]['qty'] > 0) {
                $cart[$productId]['qty']  -= 1;
            }
        }

        session()->put('cart', $cart);
        $grandTotal = $this->calcGrandTotal($cart);

        return response()->json(['grandTotal' => $grandTotal]);
    }

    public function changeQty(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->productId;
        $product = Product::find($productId);
        $qty = $request->qty;

        if (Arr::has($cart, $productId)) {
            if ($cart[$productId]['qty'] > 0) {
                $cart[$productId]['qty']  += $qty;
            }
        } else {
            $cart[$productId] = [
                "productId" => $productId,
                "qty" => $qty,
                "price" => $product->price,
                'name' => $product->name,
                'image' => $product->image_src
            ];


        }
        session()->put('cart', $cart);

        $grandTotal = $this->calcGrandTotal($cart);

        return response()->json(['grandTotal' => $grandTotal, 'cart' => $cart]);

    }

    public function deleteCart (Request $request) {
        $cart = session()->get('cart', []);
        $productId = $request->productId;

        if (Arr::has($cart, $productId)) {
           unset($cart[$productId]);
        }
        session()->put('cart', $cart);
        $grandTotal = $this->calcGrandTotal($cart);

        return response()->json(['grandTotal' => $grandTotal, 'cart' => $cart]);
    }

    public function checkout() {
        $cart = session()->get('cart', []);
        $grandTotal = $this->calcGrandTotal($cart);
        if(empty($cart)) {
            return redirect()->route('show-cart');
        }
        return view('frontend.cart.checkout', compact('cart', 'grandTotal'));
    }

    public function postCheckout(Request $request) {
        $cart = session()->get('cart', []);
        $grandTotal = $this->calcGrandTotal($cart);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'cart' => $cart,
            'grandTotal' => $grandTotal
        ];

        try {

            Mail::to('binhna98@gmail.com')->send(new OrderMail($data));

            return redirect()->back()->with('success', "Email sent successfully!");
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return redirect()->back()->withErrors("Email sent failed!");
        }
    }

    protected function calcGrandTotal($cart)
    {
        $grandTotal = 0;
        foreach ($cart as $key => $value) {
            $grandTotal += $value['price'] * $value['qty'];
        }

        return $grandTotal;
    }
}
