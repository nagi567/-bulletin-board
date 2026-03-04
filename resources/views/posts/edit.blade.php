<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿を編集</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', sans-serif; background: #f5f5f5; color: #333; }
        header { background: #fff; padding: 20px 40px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); display: flex; justify-content: space-between; align-items: center; }
        header h1 { font-size: 22px; font-weight: 700; letter-spacing: 1px; }
        .back { color: #333; text-decoration: none; font-size: 14px; }
        .back:hover { text-decoration: underline; }
        .container { max-width: 600px; margin: 40px auto; padding: 0 20px; }
        .card { background: #fff; border-radius: 12px; padding: 32px; box-shadow: 0 2px 12px rgba(0,0,0,0.07); }
        .card h2 { font-size: 20px; margin-bottom: 24px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px; color: #555; }
        input[type="text"], textarea { width: 100%; padding: 10px 14px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; outline: none; transition: border 0.2s; }
        input[type="text"]:focus, textarea:focus { border-color: #333; }
        textarea { height: 120px; resize: vertical; }
        input[type="file"] { font-size: 14px; }
        .current-image { margin-bottom: 10px; }
        .current-image img { width: 100%; max-height: 200px; object-fit: cover; border-radius: 6px; }
        .btn { background: #333; color: #fff; padding: 12px 28px; border: none; border-radius: 6px; font-size: 15px; cursor: pointer; transition: background 0.2s; }
        .btn:hover { background: #555; }
    </style>
</head>
<body>
    <header>
        <h1>🎨 お絵かき掲示板</h1>
        <a href="{{ route('posts.show', $post) }}" class="back">← 詳細に戻る</a>
    </header>
    <div class="container">
        <div class="card">
            <h2>投稿を編集する</h2>
            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>タイトル</label>
                    <input type="text" name="title" value="{{ $post->title }}" required>
                </div>
                <div class="form-group">
                    <label>説明</label>
                    <textarea name="description">{{ $post->description }}</textarea>
                </div>
                <div class="form-group">
                    <label>画像</label>
                    @if($post->image_path)
                        <div class="current-image">
                            <img src="{{ Storage::disk('s3')->url($post->image_path) }}" alt="現在の画像">
                        </div>
                    @endif
                    <input type="file" name="image">
                    <small style="color: #aaa;">変更しない場合は空のままでOK</small>
                </div>
                <button type="submit" class="btn">更新する</button>
            </form>
        </div>
    </div>
</body>
</html>