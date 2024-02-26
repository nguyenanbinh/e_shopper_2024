<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Rate;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->paginate(3);
        return view('frontend.blog.index', compact('blogs'));
    }

    public function show(string $id)
    {
        $blog = Blog::find($id);
        $pre =  Blog::where('id', '<', $blog->id)->max('id');
        $next =  Blog::where('id', '>', $blog->id)->min('id');
        $avgRate = round(
            Rate::where('blog_id', $blog->id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->avg('rate')
        );
        
        return view(
            'frontend.blog.detail',
            compact('blog', 'pre', 'next', 'avgRate')
        );
    }

    public function ajaxBlog(Request $request)
    {
        $data = $request->except('_token');

        if ($request->ajax()) {
            $createRate =  Rate::updateOrCreate(
                ['blog_id' => $request->blog_id, 'user_id' => $request->user_id],
                $data
            );
            if ($createRate) {
                return response()->json([
                    'message' => 'Rate Success'
                ], 201);
            }
        }
    }
}
