@extends( 'admin.layout' )

{{-- メインコンテンツ --}}
@section( 'contents' )
    <h1>ユーザー一覧</h1>
    <table border="1">
      <tr>
        <th>ユーザーID</th>
        <th>ユーザー名</th>
        <th>タスク件数</th>
      </tr>
      @foreach ( $users as $user )
      <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->task_num }}</td>
      </tr>
      @endforeach
    </table>
@endsection( 'contents' )