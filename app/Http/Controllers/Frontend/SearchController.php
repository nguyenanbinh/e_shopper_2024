<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $priceRange = [
            '0-1000' =>  '<= 1000',
            '1000-2000' => '1000-2000',
            '2000-4000' => '2000-4000',
            '4000-10000' => '> 4000'
        ];

        $query = Product::query();
        
        if($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if($request->price) {
            $price = $request->price;
            $rangeArray = explode('-', $price);

            // Convert the substrings to integers
            $convertedArray = array_map('intval', $rangeArray);

            $query->whereBetween('price', $convertedArray);
        }

        if(!is_null($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        if(!is_null($request->brand_id)) {
            $query->where('brand_id', $request->brand_id);
        }

        if(!is_null($request->status)) {
            $query->where('status', $request->status);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(6);

        return view('frontend.advanced-search.index', compact('products', 'categories', 'brands', 'priceRange'));
    }
}
