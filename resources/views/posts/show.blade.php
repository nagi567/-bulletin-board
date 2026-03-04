<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', sans-serif; background: #f5f5f5; color: #333; }
        header { background: #fff; padding: 20px 40px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); display: flex; justify-content: space-between; align-items: center; }
        header h1 { font-size: 22px; font-weight: 700; }
        .back { color: #333; text-decoration: none; font-size: 14px; }
        .back:hover { text-decoration: underline; }
        .container { max-width: 700px; margin: 40px auto; padding: 0 20px; }
        .card { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.07); margin-bottom: 24px; }
        .card img { width: 100%; max-height: 400px; object-fit: cover; }
        .card-body { padding: 24px; }
        .card-body h2 { font-size: 22px; margin-bottom: 8px; }
        .card-body p { font-size: 15px; color: #666; line-height: 1.6; margin-bottom: 16px; }
        .btn-group { display: flex; align-items: center; gap: 8px; }
        .like-btn { background: none; border: 1px solid #ddd; border-radius: 20px; padding: 6px 14px; cursor: pointer; font-size: 14px; }
        .delete-btn { background: none; border: 1px solid #ddd; border-radius: 20px; padding: 6px 14px; cursor: pointer; font-size: 14px; color: #e74c3c; }
        .edit-btn { display: inline-block; border: 1px solid #ddd; border-radius: 20px; padding: 6px 14px; font-size: 14px; color: #333; text-decoration: none; }
        .comments { background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 2px 12px rgba(0,0,0,0.07); margin-bottom: 24px; }
        .comments h3 { font-size: 18px; margin-bottom: 16px; }
        .comment { border-bottom: 1px solid #f0f0f0; padding: 12px 0; }
        .comment:last-child { border-bottom: none; }
        .comment-author { font-size: 13px; font-weight: 700; color: #333; margin-bottom: 4px; }
        .comment-body { font-size: 14px; color: #555; line-height: 1.6; }
        .comment-form { background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 2px 12px rgba(0,0,0,0.07); }
        .comment-form h3 { font-size: 18px; margin-bottom: 16px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px; color: #555; }
        input[type="text"], textarea { width: 100%; padding: 10px 14px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; outline: none; }
        input[type="text"]:focus, textarea:focus { border-color: #333; }
        textarea { height: 100px; resize: vertical; }
        .btn { background: #333; color: #fff; padding: 10px 24px; border: none; border-radius: 6px; font-size: 14px; cursor: pointer; }
        .btn:hover { background: #555; }
        .no-comments { color: #aaa; font-size: 14px; }
    </style>
</head>
<body>
    <header>
        <h1>🎨 お絵かき掲示板</h1>
        <a href="{{ route('posts.index') }}" class="back">← 一覧に戻る</a>
    </header>
    <div class="container">
        <div class="card">
            @if($post->image_path)
                <img src="{{ Storage::disk('s3')->url($post->image_path) }}" alt="画像">
            @endif
            <div class="card-body">
                <h2>{{ $post->title }}</h2>
                <p>{{ $post->description }}</p>
                <p style="font-size: 12px; color: #aaa; margin-top: 8px;">投稿者: {{ $post->user ? $post->user->name : '匿名' }}</p>
                <div class="btn-group">
                    <form action="{{ route('posts.like', $post) }}" method="POST">
                        @csrf
                        <button type="submit" class="like-btn">❤️ {{ $post->likes }}</button>
                    </form>
                    @auth
                        @if(auth()->id() === $post->user_id)
                        <form action="{{ route('posts.destroy', $post) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('本当に削除しますか？')" class="delete-btn">🗑️ 削除</button>
                        </form>
                        <a href="{{ route('posts.edit', $post) }}" class="edit-btn">✏️ 編集</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <div class="comments">
            <h3>💬 コメント ({{ $post->comments->count() }})</h3>
            @forelse($post->comments as $comment)
                <div class="comment">
                    <div class="comment-author">{{ $comment->author }}</div>
                    <div class="comment-body">{{ $comment->body }}</div>
                </div>
                @auth
                    @if(auth()->id() === $comment->user_id)
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('削除しますか？')" style="background: none; border: none; cursor: pointer; font-size: 12px; color: #aaa;">🗑️</button>
                        </form>
                    @endif
                @endauth
                </div>
            @empty
                <p class="no-comments">まだコメントはありません</p>
            @endforelse
        </div>

        <div class="comment-form">
            <h3>コメントを書く</h3>
            <form action="{{ route('comments.store', $post) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>名前（省略可）</label>
                    <input type="text" name="author" placeholder="匿名">
                </div>
                <div class="form-group">
                    <label>コメント</label>
                    <textarea name="body" placeholder="コメントを入力" required></textarea>
                </div>
                <button type="submit" class="btn">投稿する</button>
            </form>
        </div>
    </div>
</body>
</html>