<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreCacheRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateCacheRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return inertia('Post/Index', compact('posts'));
    }
    public function create()
    {
        $key = 'post_create_cache_by_user_' . auth()->id();
        $cache = Cache::get($key);
        return inertia('Post/Create', compact('cache'));
    }
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        Post::create($data);
        $key = 'post_create_cache_by_user_' . auth()->id();
        if(Cache::has($key)) {
            Cache::forget($key);
        }
        return Redirect::route('post.index');
    }
    public function show($id)
    {
        $post = Post::find($id);
        $author = $post->user;
        $views = $post->views + 1;
        $post->update(['views' => $views]);
        return inertia('Post/Show', compact('post', 'author'));
    }
    public function edit($id)
    {
        $post = Post::find($id);
        $key = 'post_' . $post->id . '_edit_cache_by_user_' . auth()->id();
        $cache = Cache::get($key);
        return inertia('Post/Edit', compact('post', 'cache'));
    }
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $post = Post::find($id);
        $post->update($data);
        return Redirect::route('post.show', ['id' => $id]);
    }
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->user()->dissociate();
        $post->delete();
        return Redirect::route('post.index');
    }
    public function storeCache(StoreCacheRequest $request)
    {
        $data = $request->validated();
        $key = 'post_create_cache_by_user_' . auth()->id();
        Cache::put($key, $data);
    }
}
