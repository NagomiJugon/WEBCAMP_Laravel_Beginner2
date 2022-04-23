<!DOCTYPE html>
<html lang="ja">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>