<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        Comment::create([
            'post_id' => $post->id,
            'author' => $request->author ?? '匿名',
            'body' => $request->body,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('posts.show', $post);
    }
    public function destroy(Comment $comment)
    {
        $post = $comment->post;
    
        if (auth()->id() === $comment->user_id) {
            $comment->delete();
        }
    
    return redirect()->route('posts.show', $post);
    }
}
