@extends('layouts.app')

@section('title', 'Blog - SOMA PROPERTIES')

@section('content')
<!--section-->
<div class="section hero-section hero-section_sin">
    <div class="hero-section-wrap">
        <div class="hero-section-wrap-item">
            <div class="container">
                <div class="hero-section-container">
                    <div class="hero-section-title">
                        <h2>Blog &amp; Guides</h2>
                        <h5>Buying guides, land documentation, and market trends from the SOMA advisory team.</h5>
                    </div>
                </div>
            </div>
            <div class="bg-wrap bg-hero bg-parallax-wrap-gradien fs-wrapper">
                <div class="bg" data-bg="{{ asset('light/images/bg/9.jpg') }}"></div>
            </div>
        </div>
    </div>
</div>
<!--section-end-->

<div class="container">
    <div class="breadcrumbs-list bl_flat">
        <a href="{{ route('home') }}">Home</a> <span>Blog</span>
        <div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
    </div>
    <div class="main-content">
        <div class="boxed-container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="post-container">
                        <div class="post-items">
                            @foreach($posts as $post)
                                <!-- post-item-->
                                <div class="post-item">
                                    <div class="post-item_wrap">
                                        <div class="post-item_media">
                                            <a href="{{ route('blog.show', $post) }}"><img src="{{ asset($post->cover_path) }}" alt="{{ $post->title }}" loading="lazy" decoding="async"></a>
                                            <ul class="post_header_cat"><li><a href="{{ route('blog.index', ['category' => $post->category]) }}" class="cat-opt">{{ $post->category }}</a></li></ul>
                                        </div>
                                        <div class="post-item_content">
                                            <h3><a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a></h3>
                                            <p>{{ $post->excerpt }}</p>
                                            <div class="post-card-details">
                                                <ul>
                                                    <li><i class="fa-light fa-calendar-days"></i><span>{{ $post->published_at?->format('d M Y') }}</span></li>
                                                    @if($post->author)
                                                        <li><i class="fa-light fa-user"></i><span>{{ $post->author->name }}</span></li>
                                                    @endif
                                                </ul>
                                            </div>
                                            <a href="{{ route('blog.show', $post) }}" class="post-card_link">View Details <i class="fa-solid fa-caret-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- post-item end-->
                            @endforeach
                        </div>
                        <div class="pagination-wrap">{{ $posts->links() }}</div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!--boxed-content-->
                    <div class="boxed-content">
                        <div class="boxed-content-title"><h3>Categories</h3></div>
                        <div class="boxed-content-item bc-item_smal_pad">
                            <div class="category-widget">
                                <ul class="cat-item">
                                    <li><a href="{{ route('blog.index') }}">All Posts</a></li>
                                    @foreach($categories as $category)
                                        <li><a href="{{ route('blog.index', ['category' => $category]) }}">{{ $category }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--boxed-content end-->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
