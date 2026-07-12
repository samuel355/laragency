<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $query = BlogPost::query()
            ->select(['id', 'title', 'slug', 'category', 'excerpt', 'cover_path', 'team_member_id', 'published_at'])
            ->with('author:id,name,slug')
            ->where('is_published', true);

        if ($request->filled('category')) {
            $query->where('category', $request->string('category'));
        }

        return view('blog.index', [
            'posts' => $query->latest('published_at')->paginate(9)->withQueryString(),
            'categories' => Cache::remember('blog.categories', now()->addMinutes(30), function () {
                return BlogPost::where('is_published', true)
                    ->select('category')
                    ->distinct()
                    ->orderBy('category')
                    ->pluck('category');
            }),
        ]);
    }

    public function show(BlogPost $post): View
    {
        abort_unless($post->is_published, 404);

        $post->load('author:id,name,slug,image_path,role,bio');

        return view('blog.show', [
            'post' => $post,
            'related' => BlogPost::where('is_published', true)
                ->where('id', '!=', $post->id)
                ->where('category', $post->category)
                ->limit(3)
                ->get(),
        ]);
    }
}
