<?php

namespace App\Services;

use App\Models\Post;

class PostService
{
    // create post
    public function createPost($request)
    {
        $user = auth()->user();

        $post = Post::create([
            'user_id' => $user->id,
            'post' => $request->post
        ]);

        if ($request->hasFile('image')) {
            $post->addMedia($request->image)
                ->toMediaCollection('post-images');
        }

        return $post;
    }

    // list all post
    public function listPost()
    {
        return Post::all();
    }
}