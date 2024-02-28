<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreProductRequest;
use App\Http\Requests\Frontend\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all()->where('user_id', auth()->id());
        return view('frontend.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();

        return view('frontend.product.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['company'] = 'T1';

        $images = [];

        if($request->hasFile('image'))
        {
            foreach($request->file('image') as $image)
            {
                $manager = new ImageManager(new Driver());

                $name = $image->getClientOriginalName();
                $name_2 = "image_84x85_".$image->getClientOriginalName();
                $name_3 = "image_329x390_".$image->getClientOriginalName();

                $path = public_path('upload/product/' . $name);
                $path2 = public_path('upload/product/' . $name_2);
                $path3 = public_path('upload/product/' . $name_3);

                $manager->read($image)->save($path);
                $manager->read($image)->resize(84, 85)->save($path2);
                $manager->read($image)->resize(329, 390)->save($path3);

                $images[] = $name;
            }
        }
        $data['image'] = json_encode($images);
        $storeProduct= Product::create($data);

        if($storeProduct) {
            return redirect()->route('account.my-product')->with('success', 'Create product successfully!');
        } else {
            return redirect()->back()->withErrors('Create product failed!');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $product = Product::find($id);

        return view('frontend.product.edit', compact('categories', 'brands', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::find($id);
        $imageList = json_decode($product->image);

        $maxImg = 3;
        $imgReqLength = count($request->image ?? []);
        $imgCkbLength = count($request->imgCkb ?? []);
        $imgListLength = count($imageList);

        $conditionImg = $imgReqLength - $imgCkbLength + $imgListLength;
        if ($conditionImg <= $maxImg) {
            if($imgReqLength == $imgCkbLength) {
                // dd(1);
            } else {
                return redirect()->back()->withErrors('New image must be equal checked image');
            }
        } else {
            return redirect()->back()->withErrors('Total image must be less or equal 3');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
