@extends('frontend.layouts.app')
@section('content')
<div class="blog-post-area">
    <h2 class="title text-center">Latest From our Blog</h2>
    @foreach ($blogs as $blog)
    @php
            $avgRate = round(
                \App\Models\Rate::where('blog_id', $blog->id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->avg('rate')
        );
    @endphp
    <div class="single-blog-post">
        <h3>{{ $blog->title }}</h3>
        <div class="post-meta">
            <ul>
                <li><i class="fa fa-user"></i> Admin</li>
                <li><i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($blog->created_at)->format('h:i a') }}</li>
                <li><i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($blog->created_at)->format('M d, Y') }}</li>
            </ul>
            <span>
                @for ($i=1;$i<=5;$i++)
                    @if($avgRate)
                        @if($i <= $avgRate)
                            <i class="fa fa-star"></i>
                        @else
                            <i class="fa fa-star-o"></i>
                        @endif
                    @else
                        <i class="fa fa-star-o"></i>
                    @endif
                @endfor
            </span>
        </div>
        <a href="{{ route('blogs.show', ['id' => $blog->id]) }}">
            <img src="{{ $blog->image_src }}" alt="{{ $blog->title }}" width="200" height="400">
        </a>
        <div>
            {!! Str::limit(strip_tags($blog->content), 320, ' ...')  !!}
        </div>
        <a  class="btn btn-primary" href="{{ route('blogs.show', ['id' => $blog->id]) }}">Read More</a>
    </div>
    @endforeach

    <div class="pagination-area">
        {{-- <ul class="pagination">
            <li><a href="" class="active">1</a></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href=""><i class="fa fa-angle-double-right"></i></a></li>
        </ul> --}}
        {{ $blogs->links('frontend.pagination.default') }}
    </div>
</div>






@endsection
