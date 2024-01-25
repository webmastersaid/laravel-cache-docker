<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return Inertia::render('Post/Index', ['posts' => $posts]);
    }
    public function create()
    {
        return inertia('Post/Create');
    }
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        Post::create($data);
        return Redirect::route('post.index');
    }
    public function show($id)
    {
        $post = Post::find($id);
        $author = $post->user;
        $views = $post->views + 1;
        $post->update(['views' => $views]);
        return Inertia::render('Post/Show', ['post' => $post, 'author' => $author]);
    }
    public function edit($id)
    {
        $post = Post::find($id);
        return inertia('Post/Edit', ['post' => $post]);
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
}
