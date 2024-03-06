<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'level:1']);
    }

    public function index()
    {
        $categories = Category::all();

        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->all();
        $newCategory = Category::create($data);

        if ($newCategory) {
            return redirect()->route('admin.categories.index')->with('success', 'Create category successfully');
        } else {
            return redirect()->back()->withErrors('Create category failed');
        }
    }

    public function destroy(string $id)
    {
        $category = Category::find($id);
        $deleteCategory = $category->delete();

        if ($deleteCategory) {
            return redirect()->route('admin.categories.index');
        } else {
            return redirect()->back();
        }
    }
}
