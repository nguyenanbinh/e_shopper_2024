<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Http\Requests\Admin\UpdateBlogRequest;
use App\Models\Blog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
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
        $blogs = Blog::all();
        return view('admin.blog.index', compact('blogs'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        try {
            $data = $request->all();
            $file = $request->image;

            if(!empty($file)){
                $data['image'] = $file->getClientOriginalName();
            }

            $createBlog = Blog::create($data);

            if ($createBlog) {
                if(!empty($file)){
                    $file->move('upload/blog/image', $file->getClientOriginalName());
                }
                return redirect()->route('admin.blogs.index')->with('success', __('Add blog success.'));
            } else {
                return redirect()->back()->withErrors('Add blog error.');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::find($id);
        return view('admin.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, string $id)
    {
        try {
            $data = $request->all();
            $file = $request->image;

            if(!empty($file)){
                $data['image'] = $file->getClientOriginalName();
            }

            $updateBlog = Blog::findOrFail($id)->update($data);

            if ($updateBlog) {
                if(!empty($file)){
                    $file->move('upload/blog/image', $file->getClientOriginalName());
                }
                return redirect()->route('admin.blogs.index')->with('success', __('Update blog success.'));
            } else {
                return redirect()->back()->withErrors('Update blog error.');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::find($id);
        $deleteBlog = $blog->delete();

        if ($deleteBlog) {
            return redirect()->route('admin.blogs.index');
        } else {
            return redirect()->back();
        }
    }
}
