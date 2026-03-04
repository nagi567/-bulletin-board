<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{  
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'latest');
    
        if ($sort === 'likes') {
            $posts = Post::orderBy('likes', 'desc')->paginate(6);
        } else {
            $posts = Post::latest()->paginate(6);
        }
    
        return view('posts.index', ['posts' => $posts, 'sort' => $sort]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    
    // 画像があるかチェック
      if ($request->hasFile('image')) {
        // 画像を public フォルダの中に保存
        $path = $request->file('image')->store('posts', 's3');
    } else {
        $path = null;
    }

    // データベースに保存（Post::create を使います）
    \App\Models\Post::create([
        'title' => $request->title,
        'description' => $request->description,
        'image_path' => $path,
        'user_id'=> auth()->id(),
    ]);

    // 保存したら一覧画面へ移動
    return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if ($request->hasFile('image')) {
        // 古い画像を削除
        if ($post->image_path) {
            \Storage::disk('s3')->delete($post->image_path);
        }
        $path = $request->file('image')->store('posts', 's3');
    } else {
        $path = $post->image_path;
    }

    $post->update([
        'title' => $request->title,
        'description' => $request->description,
        'image_path' => $path,
    ]);

    return redirect()->route('posts.show', $post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
          // 画像ファイルも削除
          if ($post->image_path) {
              \Storage::disk('s3')->delete($post->image_path);
          }
          $post->delete();
          return redirect()->route('posts.index');
    }
    
    public function like(Request $request, Post $post)
    {
    $cookieKey = 'liked_post_' . $post->id;

    if ($request->cookie($cookieKey)) {
        return redirect()->route('posts.index');
    }

    $post->increment('likes');

    return redirect()->route('posts.index')->cookie($cookieKey, true, 60 * 24 * 365);
    }
}
