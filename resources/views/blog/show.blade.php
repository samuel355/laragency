@extends('layouts.app')

@section('title', $post->title.' - SOMA PROPERTIES')

@section('content')
<div class="container">
    <div class="breadcrumbs-list bl_flat">
        <a href="{{ route('home') }}">Home</a><a href="{{ route('blog.index') }}">Blog</a><span>{{ $post->title }}</span>
        <div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
    </div>
    <div class="main-content">
        <div class="boxed-container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="post-container">
                        <div class="boxed-content">
                            <div class="boxed-content-title"><h3>{{ $post->title }}</h3></div>
                            <div class="boxed-content-item">
                                <div class="blog-media">
                                    <img src="{{ asset($post->cover_path) }}" alt="{{ $post->title }}" style="width: 100%; border-radius: 20px;" loading="eager" fetchpriority="high" decoding="async">
                                </div>
                                <div class="text-block post-single_tb">
                                    <div class="post-card-details" style="margin: 20px 0;">
                                        <ul>
                                            <li><i class="fa-light fa-calendar-days"></i><span>{{ $post->published_at?->format('d M Y') }}</span></li>
                                            <li><i class="fa-light fa-tag"></i><span>{{ $post->category }}</span></li>
                                            @if($post->author)
                                                <li><i class="fa-light fa-user"></i><span>{{ $post->author->name }}</span></li>
                                            @endif
                                        </ul>
                                    </div>
                                    @foreach(explode("\n\n", $post->body) as $paragraph)
                                        <p>{{ $paragraph }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @if($post->author)
                        <!--boxed-content-->
                        <div class="boxed-content">
                            <div class="boxed-content-title"><h3>Written By</h3></div>
                            <div class="boxed-content-item" style="text-align: center;">
                                <img src="{{ asset($post->author->image_path) }}" alt="{{ $post->author->name }}" style="border-radius: 10px; height: 200px; width: 100%; object-fit: cover; margin-bottom: 14px;" loading="lazy" decoding="async">
                                <h4>{{ $post->author->name }}</h4>
                                <p>{{ $post->author->role }}</p>
                                <a class="commentssubmit commentssubmit_fw" href="{{ route('team.show', $post->author) }}">View Profile</a>
                            </div>
                        </div>
                        <!--boxed-content end-->
                    @endif

                    @if($related->isNotEmpty())
                        <!--boxed-content-->
                        <div class="boxed-content" style="margin-top: 20px;">
                            <div class="boxed-content-title"><h3>More in {{ $post->category }}</h3></div>
                            <div class="boxed-content-item bc-item_smal_pad">
                                <div class="footer-list footer-box">
                                    <ul>
                                        @foreach($related as $item)
                                            <li><a href="{{ route('blog.show', $item) }}">{{ $item->title }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--boxed-content end-->
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
