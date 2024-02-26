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
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-o"></i>
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
                <li><a href="{{ $pre }}"  @empty($pre) class="btn disabled" @endempty>Pre</a></li>
                <li><a href="{{ $next }}" @empty($next) class="btn disabled" @endempty>Next</a></li>
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
                <div class="star_1 ratings_stars @if($avgRate >= 1) ratings_over @endif"><input value="1" type="hidden"></div>
                <div class="star_2 ratings_stars @if($avgRate >= 2) ratings_over @endif"><input value="2" type="hidden"></div>
                <div class="star_3 ratings_stars @if($avgRate >= 3) ratings_over @endif"><input value="3" type="hidden"></div>
                <div class="star_4 ratings_stars @if($avgRate >= 4) ratings_over @endif"><input value="4" type="hidden"></div>
                <div class="star_5 ratings_stars @if($avgRate >= 5) ratings_over @endif"><input value="5" type="hidden"></div>
                <span class="rate-np">{{ $avgRate }}</span>
            </div>
        </div>
        <div class="color">(6 votes)</div>
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

{{-- <div class="media commnets">
    <a class="pull-left" href="#">
        <img class="media-object" src="{{ asset('frontend/images/blog/socials.png') }}" alt="">
    </a>
    <div class="media-body">
        <h4 class="media-heading">Annie Davis</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
            ea commodo consequat.</p>
        <div class="blog-socials">
            <ul>
                <li><a href=""><i class="fa fa-facebook"></i></a></li>
                <li><a href=""><i class="fa fa-twitter"></i></a></li>
                <li><a href=""><i class="fa fa-dribbble"></i></a></li>
                <li><a href=""><i class="fa fa-google-plus"></i></a></li>
            </ul>
            <a class="btn btn-primary" href="">Other Posts</a>
        </div>
    </div>
</div> --}}
<!--Comments-->
<div class="response-area">
    <h2>3 RESPONSES</h2>
    <ul class="media-list">
        <li class="media">

            <a class="pull-left" href="#">
                <img class="media-object" src="images/blog/man-two.jpg" alt="">
            </a>
            <div class="media-body">
                <ul class="sinlge-post-meta">
                    <li><i class="fa fa-user"></i>Janis Gallagher</li>
                    <li><i class="fa fa-clock-o"></i> 1:33 pm</li>
                    <li><i class="fa fa-calendar"></i> DEC 5, 2013</li>
                </ul>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat.</p>
                <a class="btn btn-primary" href=""><i class="fa fa-reply"></i>Replay</a>
            </div>
        </li>
        <li class="media second-media">
            <a class="pull-left" href="#">
                <img class="media-object" src="images/blog/man-three.jpg" alt="">
            </a>
            <div class="media-body">
                <ul class="sinlge-post-meta">
                    <li><i class="fa fa-user"></i>Janis Gallagher</li>
                    <li><i class="fa fa-clock-o"></i> 1:33 pm</li>
                    <li><i class="fa fa-calendar"></i> DEC 5, 2013</li>
                </ul>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat.</p>
                <a class="btn btn-primary" href=""><i class="fa fa-reply"></i>Replay</a>
            </div>
        </li>
        <li class="media second-media">
            <a class="pull-left" href="#">
                <img class="media-object" src="images/blog/man-three.jpg" alt="">
            </a>
            <div class="media-body">
                <ul class="sinlge-post-meta">
                    <li><i class="fa fa-user"></i>Janis Gallagher</li>
                    <li><i class="fa fa-clock-o"></i> 1:33 pm</li>
                    <li><i class="fa fa-calendar"></i> DEC 5, 2013</li>
                </ul>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat.</p>
                <a class="btn btn-primary" href=""><i class="fa fa-reply"></i>Replay</a>
            </div>
        </li>
        <li class="media second-media">
            <a class="pull-left" href="#">
                <img class="media-object" src="images/blog/man-three.jpg" alt="">
            </a>
            <div class="media-body">
                <ul class="sinlge-post-meta">
                    <li><i class="fa fa-user"></i>Janis Gallagher</li>
                    <li><i class="fa fa-clock-o"></i> 1:33 pm</li>
                    <li><i class="fa fa-calendar"></i> DEC 5, 2013</li>
                </ul>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat.</p>
                <a class="btn btn-primary" href=""><i class="fa fa-reply"></i>Replay</a>
            </div>
        </li>
        <li class="media">
            <a class="pull-left" href="#">
                <img class="media-object" src="images/blog/man-four.jpg" alt="">
            </a>
            <div class="media-body">
                <ul class="sinlge-post-meta">
                    <li><i class="fa fa-user"></i>Janis Gallagher</li>
                    <li><i class="fa fa-clock-o"></i> 1:33 pm</li>
                    <li><i class="fa fa-calendar"></i> DEC 5, 2013</li>
                </ul>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat.</p>
                <a class="btn btn-primary" href=""><i class="fa fa-reply"></i>Replay</a>
            </div>
        </li>
        <li class="media second-media">
            <a class="pull-left" href="#">
                <img class="media-object" src="images/blog/man-three.jpg" alt="">
            </a>
            <div class="media-body">
                <ul class="sinlge-post-meta">
                    <li><i class="fa fa-user"></i>Janis Gallagher</li>
                    <li><i class="fa fa-clock-o"></i> 1:33 pm</li>
                    <li><i class="fa fa-calendar"></i> DEC 5, 2013</li>
                </ul>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat.</p>
                <a class="btn btn-primary" href=""><i class="fa fa-reply"></i>Replay</a>
            </div>
        </li>
        <li class="media second-media">
            <a class="pull-left" href="#">
                <img class="media-object" src="images/blog/man-three.jpg" alt="">
            </a>
            <div class="media-body">
                <ul class="sinlge-post-meta">
                    <li><i class="fa fa-user"></i>Janis Gallagher</li>
                    <li><i class="fa fa-clock-o"></i> 1:33 pm</li>
                    <li><i class="fa fa-calendar"></i> DEC 5, 2013</li>
                </ul>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat.</p>
                <a class="btn btn-primary" href=""><i class="fa fa-reply"></i>Replay</a>
            </div>
        </li>
        <li class="media second-media">
            <a class="pull-left" href="#">
                <img class="media-object" src="images/blog/man-three.jpg" alt="">
            </a>
            <div class="media-body">
                <ul class="sinlge-post-meta">
                    <li><i class="fa fa-user"></i>Janis Gallagher</li>
                    <li><i class="fa fa-clock-o"></i> 1:33 pm</li>
                    <li><i class="fa fa-calendar"></i> DEC 5, 2013</li>
                </ul>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat.</p>
                <a class="btn btn-primary" href=""><i class="fa fa-reply"></i>Replay</a>
            </div>
        </li>
    </ul>
</div>
<!--/Response-area-->
<div class="replay-box">
    <div class="row">
        <div class="col-sm-12">
            <h2>Leave a replay</h2>

            <div class="text-area">
                <div class="blank-arrow">
                    <label>Your Name</label>
                </div>
                <span>*</span>
                <textarea name="message" rows="11"></textarea>
                <a class="btn btn-primary" href="">post comment</a>
            </div>
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
            var Values =  $(this).find("input").val();
            $('.rate-np').text(Values);
            if ($(this).hasClass('ratings_over')) {
                $('.ratings_stars').removeClass('ratings_over');
                $(this).prevAll().andSelf().addClass('ratings_over');
            } else {
                $(this).prevAll().andSelf().addClass('ratings_over');
            }

            $.ajax({
                type:'POST',
                url: '{{ route('blogs.ajaxBlog') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    rate: Values,
                    blog_id: '{{ $blog->id }}',
                    user_id: '{{ auth()->user()->id }}',
                },
                success:function(data){
                    console.log(data);
                },
                error: function(errors) {
                    if(errors.status == 401) {
                        alert('Please login to rate this blog')
                    }
                }
            });
        });
    });
</script>
@endpush
