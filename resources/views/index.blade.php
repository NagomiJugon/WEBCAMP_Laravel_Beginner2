@extends( 'layout' )

{{-- メインコンテンツ --}}
@section( 'contents' )
      <h1>ログイン</h1>
      @if ( session( 'front.user_register_success' ) == true )
            ユーザーを登録しました<br>
      @endif
      @if ( session( 'front.user_register_failure' ) == true )
            ユーザーの登録に失敗しました<br>
      @endif
      @if ( $errors->any() )
            <div>
            @foreach ( $errors->all() as $error )
                  {{ $error }}<br>
            @endforeach
            </div>
      @endif
      <form action="/login" method="post">
            @csrf
          email: <input name="email" value="{{ old( 'email' ) }}"><br>
          パスワード: <input name="password" type="password"><br>
          <button>ログインする</button>
      </form>
      <a href="/user/index" method="get">会員登録</a>
@endsection( 'contents' )