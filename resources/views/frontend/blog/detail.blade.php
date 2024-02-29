@extends('frontend.layouts.app')
@section('content')
@push('css')
<link type="text/css" rel="stylesheet" href="{{ asset('frontend/css/rate.css') }}">
@endpush
<div class="blog-post-area">
    <h2 class="title text-center">Latest From our Blog</h2>
    <div class="single-blog-post">
        <h3>{{ $blog->title }}</h3>
        <div class="post-meta">
            <ul>
                <li><i class="fa fa-user"></i> Admin</li>
                <li><i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($blog->created_at)->format('h:i a') }}</li>
                <li><i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($blog->created_at)->format('M d, Y') }}</li>
            </ul>
            <span>
                @for ($i=1;$i<=5;$i++) @if($avgRate) @if($i <=$avgRate) <i class="fa fa-star"></i>
                    @else
                    <i class="fa fa-star-o"></i>
                    @endif
                    @else
                    <i class="fa fa-star-o"></i>
                    @endif
                    @endfor
            </span>
        </div>
        <a href="">
            <img src="{{ $blog->image_src }}" alt="">
        </a>
        <div class="content">
            {!! $blog->content !!}
        </div>
        <div class="pager-area">
            <ul class="pager pull-right">
                <li><a href="{{ route('blogs.show', ['id' => $pre ?? $blog->id]) }}" @empty($pre) class="btn disabled"
                        @endempty>Pre</a></li>
                <li><a href="{{ route('blogs.show', ['id' => $next ?? $blog->id]) }}" @empty($next) class="btn disabled"
                        @endempty>Next</a></li>
            </ul>
        </div>
    </div>
</div>
<!--/blog-post-area-->

<div class="rating-area">
    <div class="ratings">
        <div class="rate-this">Rate this item:</div>
        <div class="rate">
            <div class="vote">
                <div class="star_1 ratings_stars @if($avgRate >= 1) ratings_over @endif"><input value="1" type="hidden">
                </div>
                <div class="star_2 ratings_stars @if($avgRate >= 2) ratings_over @endif"><input value="2" type="hidden">
                </div>
                <div class="star_3 ratings_stars @if($avgRate >= 3) ratings_over @endif"><input value="3" type="hidden">
                </div>
                <div class="star_4 ratings_stars @if($avgRate >= 4) ratings_over @endif"><input value="4" type="hidden">
                </div>
                <div class="star_5 ratings_stars @if($avgRate >= 5) ratings_over @endif"><input value="5" type="hidden">
                </div>
                <span class="rate-np">{{ $avgRate }}</span>
            </div>
        </div>
        <div class="color">({{ $totalRate }} votes)</div>
    </div>
    {{-- <ul class="tag">
        <li>TAG:</li>
        <li><a class="color" href="">Pink <span>/</span></a></li>
        <li><a class="color" href="">T-Shirt <span>/</span></a></li>
        <li><a class="color" href="">Girls</a></li>
    </ul> --}}
</div>
<!--/rating-area-->

<div class="socials-share">
    <a href=""><img src="{{ asset('frontend/images/blog/socials.png') }}" alt=""></a>
</div>
<!--/socials-share-->

<!--Comments-->
<div class="response-area">
    <h2>{{ count($comments) ?? 3 }} RESPONSES</h2>
    <ul class="media-list">
        @if(isset($comments) && count($comments))
            @foreach ($comments as $comment)
                @php
                $childrenComments = $comment->children()->get();
                $hour = \Carbon\Carbon::parse($comment->created_at)->format('h:i a');
                $date = \Carbon\Carbon::parse($comment->created_at)->format('M d, Y');
                @endphp
                <li class="media" data-comment-id="{{ $comment->id }}">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="{{ $comment->avatar_src }}" width="200" height="100" alt="">
                    </a>
                    <div class="media-body">
                        <ul class="sinlge-post-meta">
                            <li><i class="fa fa-user"></i>{{ $comment->user_name }}</li>
                            <li><i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($comment->created_at)->format('h:i a') }}
                            </li>
                            <li><i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($comment->created_at)->format('M d, Y')
                                }}</li>
                        </ul>
                        <p>{{ $comment->content }}</p>
                        <button class="btn btn-primary reply-blog"><i
                                class="fa fa-reply"></i>Replay</button>
                        <div class="replay-box1 hidden">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h2>Leave a replay</h2>

                                    <form id="postComment" data-level="{{ $comment->id }}">
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
                    <ul class="children-comments">
                        @foreach ($childrenComments as $child)
                        <li class="media second-media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="{{ $child->avatar_src }}" width="200" height="100" alt="">
                            </a>
                            <div class="media-body">
                                <ul class="sinlge-post-meta">
                                    <li><i class="fa fa-user"></i>{{ $child->user_name }}</li>
                                    <li><i class="fa fa-clock-o"></i>{{ $hour }}</li>
                                    <li><i class="fa fa-calendar"></i>{{ $date }}</li>
                                </ul>
                                <p>{{ $child->content }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        @endif
    </ul>
</div>
<!--/Response-area-->
<div class="replay-box">
    <div class="row">
        <div class="col-sm-12">
            <h2>Leave a replay</h2>
            <form id="postComment" data-level="0">
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
<!--/Repaly Box-->
@endsection

@push('scripts')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    $(document).ready(function(){
        //vote
        $('.ratings_stars').hover(
            // Handles the mouseover
            function() {
                $(this).prevAll().andSelf().addClass('ratings_hover');
                // $(this).nextAll().removeClass('ratings_vote');
            },
            function() {
                $(this).prevAll().andSelf().removeClass('ratings_hover');
                // set_votes($(this).parent());
            }
        );

        $('.ratings_stars').click(function(){
            var isLogin = '{{ auth()->check() }}';
            var Values =  $(this).find("input").val();
            if(isLogin) {
            $('.rate-np').text(Values);
            if ($(this).hasClass('ratings_over')) {
                $('.ratings_stars').removeClass('ratings_over');
                $(this).prevAll().andSelf().addClass('ratings_over');
            } else {
                $(this).prevAll().andSelf().addClass('ratings_over');
            }

                $.ajax({
                    type:'POST',
                    url: '{{ route('blogs.ajaxRate') }}',
                    data: {
                        // _token: '{{ csrf_token() }}',
                        rate: Values,
                        blog_id: '{{ $blog->id }}',
                        user_id: '{{ auth()->user()->id ?? 0 }}',
                    },
                    success:function(data){
                        alert('Rate success');
                        console.log(data);
                    },
                    error: function(errors) {
                        if(errors.status == 401) {
                            alert('Please login to rate this blog')
                        }
                    }
                });
            } else {
                alert('Please login to rate this blog');
            }

        });

        // Reply comment
        $('form#postComment').submit(function(e){
            e.preventDefault();
            var isLogin = '{{ auth()->check() }}';
            if(isLogin) {
                var contentEle =  $(this).find('textarea');
                var content = contentEle.val();
                var commentList = $('.media-list');
                var level = $(this).data('level');

                $.ajax({
                    type:'POST',
                    url: '{{ route('blogs.ajaxComment') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        content: content,
                        blog_id: '{{ $blog->id }}',
                        user_id: '{{ auth()->user()->id ?? 0 }}',
                        level
                    },
                    success:function(data){
                        if(level == 0) {
                            commentList.append(data.html);
                        } else {
                            var parentComment = $('li.media[data-comment-id="' + level + '"]');
                            console.log(parentComment);
                            parentComment.find('ul.children-comments').append(data.html);
                            contentEle.val('');
                        }

                        alert(data.message);

                    },
                    error: function(errors) {
                        var errMsg = errors.responseJSON.message;
                        if(errMsg) {
                            contentEle.val('');
                            alert(errMsg);
                        }
                       console.log(errors);
                    }
                });
            } else {
                alert('Please login to comment');
            }

        });

        // Reply child
        $('.reply-blog').click(function (e) {
            e.preventDefault();
            $(this).parent().find('.replay-box1').toggleClass('hidden');
        });

        // $('form#postCommentChild').submit(function(e){
        //     e.preventDefault();
        //     var contentEle = $(this).find('textarea');
        //     var content = contentEle.val();
        //     // Get the closest parent 'li' element of the form
        //     var parentLi = $(this).closest('li.media');
        //     var mediaList = $(this).closest('ul.media-list');
        //     var commentId = parentLi.find('.reply-blog').data('comment-id');

        //     $.ajax({
        //         type:'POST',
        //         url: '{{ route('blogs.ajaxCommentChild') }}',
        //         data: {
        //             _token: '{{ csrf_token() }}',
        //             content: content,
        //             comment_id: commentId,
        //             blog_id: '{{ $blog->id }}',
        //             user_id: '{{ auth()->user()->id ?? '' }}',
        //         },
        //         success:function(data){
        //             mediaList.append(data.html);
        //             contentEle.val('');
        //             console.log(data);
        //         },
        //         error: function(errors) {
        //             if(errors.status == 401) {
        //                 alert('Please login to comment');
        //             }
        //         }
        //     });
        // });

    });
</script>
@endpush
