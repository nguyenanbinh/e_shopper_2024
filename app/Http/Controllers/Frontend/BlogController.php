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
        // dd(auth()->check());
        $blog = Blog::find($id);
        $pre =  Blog::where('id', '<', $blog->id)->max('id');
        $next =  Blog::where('id', '>', $blog->id)->min('id');

        $rate = Rate::where('blog_id', $blog->id)->orderBy('created_at', 'desc')->get();
        $avgRate = round($rate->avg('rate'));
        $totalRate = count($rate);

        $comments = Comment::where('blog_id', $blog->id)->where('level', 0)->orderBy('created_at', 'desc')->get();

        return view(
            'frontend.blog.detail',
            compact('blog', 'pre', 'next', 'avgRate', 'totalRate', 'comments')
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

    public function ajaxComment(Request $request)
    {
        $content = $request->content;
        $user = auth()->user();
        $request['user_avatar'] = $user->avatar;
        $request['user_name'] = $user->name;
        $request['level'] = $request->level;
        $html = '';
        $flag = false;

        if ($request->level == 0) {
            $flag = true;
        } else {
            $currentComment = Comment::find($request->level);
            $flag = $currentComment && $currentComment->user_id != auth()->id();
        }

        if ($flag == true) {
            $comment = Comment::create($request->all());
            if ($comment) {
                $hour = \Carbon\Carbon::parse($comment->created_at)->format('h:i a');
                $date = \Carbon\Carbon::parse($comment->created_at)->format('M d, Y');

                $html = $this->generateCommentHtml($user, $comment, $content, $hour, $date);
            }
        }

        return response()->json([
            'html' => $html,
            'message' => $flag ? 'Comment success' : 'Comment failed'
        ], $flag ? 201 : 422);
    }

    private function generateCommentHtml($user, $comment, $content, $hour, $date)
    {
        $avatarSrc = $user->avatar_src;
        $htmlTemplate = '';

        if ($comment->level == 0) {
            $htmlTemplate = <<<HTML
                <li class="media" data-comment-id="$comment->id">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="$avatarSrc" width="200" height="100" alt="">
                    </a>
                    <div class="media-body">
                        <ul class="sinlge-post-meta">
                            <li><i class="fa fa-user"></i>$user->name</li>
                            <li><i class="fa fa-clock-o"></i>$hour</li>
                            <li><i class="fa fa-calendar"></i>$date</li>
                        </ul>
                        <p>$content</p>
                    </div>
                    <button class="btn btn-primary reply-blog"><i class="fa fa-reply"></i>Replay</button>
                    <div class="replay-box1 hidden">
                        <div class="row">
                            <div class="col-sm-12">
                                <h2>Leave a replay</h2>
                                <form id="postComment" data-level="$comment->id">
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
                    <ul class="children-comments">
                    </ul>
                </li>
            HTML;
        } else {
            $htmlTemplate = <<<HTML
                <li class="media second-media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="$comment->avatar_src" width="200" height="100" alt="">
                    </a>
                    <div class="media-body">
                        <ul class="sinlge-post-meta">
                            <li><i class="fa fa-user"></i>$comment->user_name</li>
                            <li><i class="fa fa-clock-o"></i>$hour</li>
                            <li><i class="fa fa-calendar"></i>$date</li>
                        </ul>
                        <p>$comment->content</p>
                    </div>
                </li>
            HTML;
        }

        return $htmlTemplate;
    }
}
