<!DOCTYPE html>
<html lang="ja">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>ログイン機能付きタスク管理サービス</title>
    </head>
    <body>
      @auth( 'admin' )
        <menu label="リンク">
          <a href="/admin/user/list">ユーザー一覧</a><br>
          管理画面機能 1<br>
          管理画面機能 2<br>
          管理画面機能 3<br>
          管理画面機能 4<br>      
          <a href="/admin/logout">ログアウト</a>
        </menu>
      @endauth
      @yield( 'contents' )
    </body>
</html>