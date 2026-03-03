<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', sans-serif; background: #f5f5f5; color: #333; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .card { background: #fff; border-radius: 12px; padding: 40px; box-shadow: 0 2px 12px rgba(0,0,0,0.07); width: 100%; max-width: 400px; }
        .card h1 { font-size: 24px; font-weight: 700; margin-bottom: 8px; text-align: center; }
        .card p { font-size: 14px; color: #aaa; text-align: center; margin-bottom: 32px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px; color: #555; }
        input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 10px 14px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; outline: none; transition: border 0.2s; }
        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus { border-color: #333; }
        .btn { width: 100%; background: #333; color: #fff; padding: 12px; border: none; border-radius: 6px; font-size: 15px; cursor: pointer; transition: background 0.2s; margin-top: 8px; }
        .btn:hover { background: #555; }
        .links { text-align: center; margin-top: 20px; font-size: 14px; }
        .links a { color: #333; }
        .error { color: #e74c3c; font-size: 13px; margin-top: 4px; }
    </style>
</head>
<body>
    <div class="card">
        <h1>🎨 お絵かき掲示板</h1>
        <p>アカウントを作成してください</p>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label>名前</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus>
                @error('name')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>メールアドレス</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
                @error('email')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>パスワード</label>
                <input type="password" name="password" required>
                @error('password')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>パスワード（確認）</label>
                <input type="password" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn">登録する</button>
        </form>
        <div class="links">
            <a href="{{ route('login') }}">すでにアカウントをお持ちの方</a>
        </div>
    </div>
</body>
</html>