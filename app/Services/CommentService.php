<?php

namespace App\Services;

use App\Models\Comment;

class CommentService
{
    // make comment
    public function makeComment($post, $request)
    {
        $user = auth()->user();

        return Comment::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'comment' => $request->comment
        ]);
    }
}