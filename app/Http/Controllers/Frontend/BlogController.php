<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;
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

        $totalRate = count(Rate::where('blog_id', $blog->id)
        ->orderBy('created_at', 'desc')
        ->get());
        return view(
            'frontend.blog.detail',
            compact('blog', 'pre', 'next', 'avgRate', 'totalRate')
        );
    }

    public function ajaxRate(Request $request)
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

    public function ajaxComment(Request $request) {
        $content = $request->content;
        $user = auth()->user();
        $request['user_avatar'] = $user->avatar;
        $request['user_name'] = $user->name;
        $request['level'] = 0;

        $comment = Comment::create($request->all());

        if($comment) {
            $hour = \Carbon\Carbon::parse($comment->created_at)->format('h:i a');
            $date = \Carbon\Carbon::parse($comment->created_at)->format('M d, Y');
            $html = <<<HTML
                <li class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="$user->avatar_src" width="200" height="100" alt="">
                    </a>
                    <div class="media-body">
                        <ul class="sinlge-post-meta">
                            <li><i class="fa fa-user"></i>$user->name</li>
                            <li><i class="fa fa-clock-o"></i>$hour</li>
                             <li><i class="fa fa-calendar"></i>$date</li>
                        </ul>
                        <p>$content</p>
                        <button class="btn btn-primary" class="reply-blog" data-comment-id="$comment->id"><i
                                class="fa fa-reply"></i>Replay</button>
                        <div class="replay-box1 hidden">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h2>Leave a replay</h2>

                                    <form id="postCommentChild">
                                        <div class="text-area">
                                            <div class="blank-arrow1">
                                                <label>Your Name</label>
                                            </div>
                                             <span>*</span>
                                            <textarea name="message" rows="5"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">post comment</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            HTML;

            return response()->json([
                'html' => $html,
                'message' => 'Comment success'
            ], 201);
        }
    }

    public function ajaxCommentChild(Request $request) {
        $content = $request->content;
        $user = auth()->user();
        $request['user_avatar'] = $user->avatar;
        $request['user_name'] = $user->name;
        $request['level'] = $request->comment_id;

        $comment = Comment::create($request->all());

        if($comment) {
            $hour = \Carbon\Carbon::parse($comment->created_at)->format('h:i a');
            $date = \Carbon\Carbon::parse($comment->created_at)->format('M d, Y');
            $html = <<<HTML
                <li class="media second-media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="$user->avatar_src" width="200" height="100" alt="">
                    </a>
                    <div class="media-body">
                        <ul class="sinlge-post-meta">
                            <li><i class="fa fa-user"></i>$user->name</li>
                            <li><i class="fa fa-clock-o"></i>$hour</li>
                            <li><i class="fa fa-calendar"></i>$date</li>
                        </ul>
                        <p>$content</p>
                    </div>
                </li>
            HTML;

            return response()->json([
                'html' => $html,
                'message' => 'Comment success'
            ], 201);
        }
    }
}
