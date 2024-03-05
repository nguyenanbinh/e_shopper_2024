<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class HomeController extends Controller
{
    public function index() {

        return view('frontend.home');
    }

    public function ajaxProduct(Request $request) {
        $priceRange = $request->priceRange;

        $products = Product::whereBetween('price', $priceRange)->paginate(3);
        $view = view('frontend.component.product', compact('products'))->render();

        return response()->json(
           [
            'view' => $view,
            'priceRange' => $priceRange],
           200
        );
    }

    public function sendMail() {
        try {
            $title = 'Welcome to the example email';
            $body = 'Thank you for participating!';

            Mail::to('binhna98@gmail.com')->send(new OrderMail($title, $body));

            return "Email sent successfully!";
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return $ex->getMessage();
        }

    }
}
