<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index () {
        $blogs = Blog::orderBy('created_at', 'desc')->paginate(3);
        return view('frontend.blog.index', compact('blogs'));
    }

    public function show (string $id) {
        $blog = Blog::find($id);
        $pre =  Blog::where('id', '<', $blog->id)->max('id');
        $next =  Blog::where('id', '>', $blog->id)->min('id');
        
        return view('frontend.blog.detail', compact('blog', 'pre', 'next'));
    }
}
