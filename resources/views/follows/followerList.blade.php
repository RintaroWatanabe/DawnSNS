@extends('layouts.login')

@section('content')

<p>Follower list</p>
<!-- 自分のフォロワー一覧表示 -->
<div>
  @foreach ($followers_lists as $followers_list)
    <a href='/users/{{ $followers_list->id }}/followProfile'>
      <img src="/images/{{ $followers_list->images }}" alt=""></a>
  @endforeach
</div>

<!-- フォロワーの投稿内容を表示 -->
<table class='page-header'>
    <tr>
      <th></th>
      <th>投稿者</th>
      <th>投稿内容</th>
      <th></th>
    </tr>

    <!-- プロフィール画像、ユーザー名、投稿内容、投稿日時を表示 -->
    @foreach ($followers_posts as $followers_post)
    <tr>
      <td>
        <a href='/users/{{ $followers_post->id }}/followProfile'>
        <img src='/images/{{ $followers_post->images }}' alt=''></a>
      </td>
      <td>{{ $followers_post->username }}</td>
      <td>{{ $followers_post->posts }}</td>
      <td>{{ $followers_post->created_at }}</td>
    </tr>
    @endforeach
</table>

@endsection
