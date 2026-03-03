<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>掲示板</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', sans-serif; background: #f5f5f5; color: #333; }
        header { background: #fff; padding: 20px 40px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); display: flex; justify-content: space-between; align-items: center; }
        header h1 { font-size: 22px; font-weight: 700; letter-spacing: 1px; }
        .btn { background: #333; color: #fff; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-size: 14px; transition: background 0.2s; }
        .btn:hover { background: #555; }
        .container { max-width: 900px; margin: 40px auto; padding: 0 20px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 24px; }
        .card { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.07); transition: transform 0.2s; }
        .card:hover { transform: translateY(-4px); }
        .card img { width: 100%; height: 200px; object-fit: cover; }
        .card-body { padding: 16px; }
        .card-body h3 { font-size: 16px; font-weight: 700; margin-bottom: 8px; }
        .card-body p { font-size: 14px; color: #666; line-height: 1.6; }
        .no-image { width: 100%; height: 200px; background: #eee; display: flex; align-items: center; justify-content: center; color: #aaa; font-size: 14px; }
        .pagination { display: flex; justify-content: center; gap: 8px; list-style: none; padding: 0; }
        .pagination li a, .pagination li span { display: inline-block; padding: 8px 14px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; color: #333; text-decoration: none; }
        .pagination li.active span { background: #333; color: #fff; border-color: #333; }
        .pagination li.disabled span { color: #aaa; }
    </style>
</head>
<body>
    <header>
        <h1><a href="{{ route('posts.index') }}" style="text-decoration: none; color: #333;">🎨 お絵かき掲示板</a></h1>
        <a href="{{ route('rules') }}" style="font-size: 13px; color: #aaa; text-decoration: none;">利用規約</a>
        <div style="display: flex; gap: 8px; align-items: center;">
           @auth
               <span style="font-size: 14px; color: #555;">{{ auth()->user()->name }}さん</span>
               <a href="{{ route('posts.create') }}" class="btn">+ 新しく投稿する</a>
               <form method="POST" action="{{ route('logout') }}">
                   @csrf
                   <button type="submit" style="background: none; border: 1px solid #ddd; border-radius: 6px; padding: 10px 20px; cursor: pointer; font-size: 14px; color: #333;">ログアウト</button>
               </form>
           @else
               <a href="{{ route('login') }}" style="background: none; border: 1px solid #ddd; border-radius: 6px; padding: 10px 20px; text-decoration: none; font-size: 14px; color: #333;">ログイン</a>
               <a href="{{ route('register') }}" class="btn">新規登録</a>
           @endauth
        </div>
    </header>
    <div class="container">
        <div style="display: flex; justify-content: flex-end; margin-bottom: 24px; gap: 8px;">
            <a href="{{ route('posts.index', ['sort' => 'latest']) }}" style="padding: 8px 16px; border: 1px solid #ddd; border-radius: 6px; text-decoration: none; font-size: 14px; color: #333; {{ $sort === 'latest' ? 'background: #333; color: #fff;' : 'background: #fff;' }}">
                🕒 新しい順
            </a>
            <a href="{{ route('posts.index', ['sort' => 'likes']) }}" style="padding: 8px 16px; border: 1px solid #ddd; border-radius: 6px; text-decoration: none; font-size: 14px; color: #333; {{ $sort === 'likes' ? 'background: #333; color: #fff;' : 'background: #fff;' }}">
                ❤️ いいね順
            </a>
        </div>
        <div class="grid">
            @foreach ($posts as $post)
            <div class="card">
                @if($post->image_path)
                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="画像">
                @else
                    <div class="no-image">画像なし</div>
                @endif
                <div class="card-body">
                    <h3><a href="{{ route('posts.show', $post) }}" style="text-decoration: none; color: #333;">{{ $post->title }}</a></h3>
                    <p>{{ $post->description }}</p>
                    <p style="font-size: 12px; color: #aaa; margin-top: 8px;">投稿者: {{ $post->user ? $post->user->name : '匿名' }}</p>
                    <form action="{{ route('posts.like', $post) }}" method="POST" style="margin-top: 12px;">
                        @csrf
                        <button type="submit" style="background: none; border: 1px solid #ddd; border-radius: 20px; padding: 6px 14px; cursor: pointer; font-size: 14px;">
                            ❤️ {{ $post->likes }}
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        <div style="margin-top: 32px; display: flex; justify-content: center;">
            {{ $posts->links('pagination::simple-bootstrap-4') }}
        </div>
    </div>
</body>
</html>