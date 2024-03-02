<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreProductRequest;
use App\Http\Requests\Frontend\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\File;
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
        $data['company'] = $request->company ?? 'T1';

        $parentPath = 'upload/product';
        $user_id = auth()->id();
        $images = $this->uploadImages($request, $parentPath, $user_id);

        $data['image'] = json_encode($images);
        $storeProduct = Product::create($data);

        if ($storeProduct) {
            return redirect()->route('account.my-product')->with('success', 'Create product successfully!');
        } else {
            return redirect()->back()->withErrors('Create product failed!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        $brand = Brand::find($product->brand_id);
        $imgList = json_decode($product->image);

        return view('frontend.product.detail', compact('product', 'brand', 'imgList'));
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
        $imgCkbLength = count($request->imgCkb ?? []);
        $imgReqLength = count($request->image ?? []);
        $imgListLength = count($imageList);
        $maxImg = 3;
        $parentPath = 'upload/product';
        $user_id = auth()->id();
        $data = $request->all();
        // Check and unset img
        if ($imgCkbLength) {
            foreach ($request->imgCkb as  $value) {
                unset($imageList[$value]);
            }
            // Reset key
            $imageList = array_values($imageList);
        }

        $conditionImg = $imgReqLength - $imgCkbLength + $imgListLength;
        if ($conditionImg <= $maxImg) {
            $imageList = $this->uploadImages($request, $parentPath, $user_id, $imageList);

            $data['image'] = json_encode($imageList);
            $updateProduct = $product->update($data);


            if ($updateProduct) {
                return redirect()->route('account.my-product')->with('success', 'Update product successfully!');
            } else {
                return redirect()->back()->withErrors('Create product failed!');
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

    protected function uploadImages($request, $parentPath, $userId, $imageList = []) {
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $manager = new ImageManager(new Driver());

                $name = $image->getClientOriginalName();
                $name_2 = "image_84x85_" . $image->getClientOriginalName();
                $name_3 = "image_329x390_" . $image->getClientOriginalName();

                $childPath = "$parentPath/$userId";

                if (!File::exists($childPath)) {
                    File::makeDirectory($childPath);
                }

                $path = public_path($childPath . '/' . $name);
                $path2 = public_path($childPath . '/' . $name_2);
                $path3 = public_path($childPath . '/' . $name_3);

                $manager->read($image)->save($path);
                $manager->read($image)->resize(84, 85)->save($path2);
                $manager->read($image)->resize(329, 390)->save($path3);

                $imageList[] = $name;
            }
        }

        return $imageList;
    }
}
