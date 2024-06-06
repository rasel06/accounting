<?php

namespace App\Http\Controllers;

use App\Events\NewPost;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Jobs\SyncMedia;
use App\Models\Post;
use App\Notification\ReviewNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::all();



        return view('post.index', compact('posts'));
    }

    public function create(Request $request): Response
    {
        return view('post.create');
    }

    public function store(PostStoreRequest $request): Response
    {
        $post = Post::create($request->validated());

        Notification::send($post->author, new ReviewNotification($post));

        SyncMedia::dispatch($post);

        NewPost::dispatch($post);

        $request->session()->flash('post.title', $post->title);

        return redirect()->route('post.index');
    }

    public function show(Request $request, Post $post): Response
    {
        return view('post.show', compact('post'));
    }

    public function edit(Request $request, Post $post): Response
    {
        return view('post.edit', compact('post'));
    }

    public function update(PostUpdateRequest $request, Post $post): Response
    {
        $post->update($request->validated());

        $request->session()->flash('post.id', $post->id);

        return redirect()->route('post.index');
    }

    public function destroy(Request $request, Post $post): Response
    {
        $post->delete();

        return redirect()->route('post.index');
    }
}
