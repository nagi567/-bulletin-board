<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>利用規約</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', sans-serif; background: #f5f5f5; color: #333; }
        header { background: #fff; padding: 20px 40px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); display: flex; justify-content: space-between; align-items: center; }
        header h1 { font-size: 22px; font-weight: 700; }
        .back { color: #333; text-decoration: none; font-size: 14px; }
        .back:hover { text-decoration: underline; }
        .container { max-width: 700px; margin: 40px auto; padding: 0 20px; }
        .card { background: #fff; border-radius: 12px; padding: 40px; box-shadow: 0 2px 12px rgba(0,0,0,0.07); }
        .card h2 { font-size: 22px; font-weight: 700; margin-bottom: 24px; }
        .rule { border-bottom: 1px solid #f0f0f0; padding: 20px 0; }
        .rule:last-child { border-bottom: none; }
        .rule h3 { font-size: 16px; font-weight: 700; margin-bottom: 8px; }
        .rule p { font-size: 14px; color: #666; line-height: 1.6; }
        .badge { display: inline-block; background: #333; color: #fff; font-size: 11px; padding: 2px 8px; border-radius: 4px; margin-right: 8px; }
    </style>
</head>
<body>
    <header>
        <h1>🎨 お絵かき掲示板</h1>
        <a href="{{ route('posts.index') }}" class="back">← 一覧に戻る</a>
    </header>
    <div class="container">
        <div class="card">
            <h2>📋 利用規約</h2>
            <div class="rule">
                <h3><span class="badge">Rule 1</span>著作権について</h3>
                <p>著作権のある画像の無断投稿は禁止です。自分で描いたオリジナルの作品のみ投稿してください。</p>
            </div>
            <div class="rule">
                <h3><span class="badge">Rule 2</span>誹謗中傷の禁止</h3>
                <p>他のユーザーへの誹謗中傷、差別的な発言、嫌がらせ行為は固く禁止します。</p>
            </div>
            <div class="rule">
                <h3><span class="badge">Rule 3</span>商用利用の禁止</h3>
                <p>本サービスを商業目的で利用することは禁止です。</p>
            </div>
            <div class="rule">
                <h3><span class="badge">Rule 4</span>生成AIの禁止</h3>
                <p>AIによって生成された画像の投稿は禁止です。手描きのオリジナル作品のみ投稿してください。</p>
            </div>
            <div class="rule">
                <h3><span class="badge">Rule 5</span>楽しく使おう！</h3>
                <p>ルールを守って、みんなで楽しくお絵かきを共有しよう！😊</p>
            </div>
        </div>
    </div>
</body>
</html>