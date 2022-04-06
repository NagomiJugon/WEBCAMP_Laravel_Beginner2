@extends( 'test.layout' )

{{-- メインコンテンツ --}}
@section( 'contents' )
      email:{{ $datum[ 'email' ] }}<br>
      password:{{ $datum[ 'password' ] }}<br>
@endsection( 'contents' )