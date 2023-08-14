@extends('layouts.login')

@section('content')

<table class='page-header'>
  <!-- ユーザーのプロフィール表示 -->
    <tr>
      <th>アイコン</th>
      <th>名前</th>
      <th>Bio</th>
      <th></th>
    </tr>
    <tr>
      <td><img src="/images/{{ $users -> images }}" alt=""></td>
      <td>{{ $users->username }}</td>
      <td>{{ $users->bio }}</td>
      <td>フォローボタン</td>
    </tr>
  </table>

  <!-- ユーザーの投稿一覧 -->
  <div>
    <ul>
      @foreach ($posts as $post)
        <li>
        <img src="/images/{{ $post -> images }}" alt="">
        {{ $post-> username}}
        {{ $post-> posts}}
        </li>
      @endforeach
    </ul>
  </div>


@endsection
