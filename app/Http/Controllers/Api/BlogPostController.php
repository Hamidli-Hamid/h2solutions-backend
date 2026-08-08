<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogPostResource;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Cache;

class BlogPostController extends Controller
{
    public function index()
    {
        $posts = Cache::remember(
            'api.blog.' . app()->getLocale(),
            now()->addMinutes(15),
            fn () => BlogPost::published()
                ->with('author')
                ->orderByDesc('published_at')
                ->get()
        );

        return BlogPostResource::collection($posts);
    }

    public function show(string $slug)
    {
        $post = Cache::remember(
            "api.blog.{$slug}." . app()->getLocale(),
            now()->addMinutes(15),
            fn () => BlogPost::published()
                ->with('author')
                ->where('slug', $slug)
                ->firstOrFail()
        );

        return new BlogPostResource($post);
    }
}
