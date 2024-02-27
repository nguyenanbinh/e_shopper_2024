<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $brands = Brand::all();

        return view('admin.brand.index', compact('brands'));
    }

    public function create()
    {

        return view('admin.brand.create');
    }

    public function store(StoreBrandRequest $request)
    {
        $data = $request->all();
        $newBrand = Brand::create($data);

        if ($newBrand) {
            return redirect()->route('admin.brands.index');
        } else {
            return redirect()->back();
        }
    }

    public function destroy(string $id)
    {
        $brand = Brand::find($id);
        $deleteBrand = $brand->delete();

        if ($deleteBrand) {
            return redirect()->route('admin.brands.index');
        } else {
            return redirect()->back();
        }
    }
}
