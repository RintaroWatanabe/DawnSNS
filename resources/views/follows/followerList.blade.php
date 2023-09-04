@extends('layouts.login')

@section('content')

<p class='follow-list-text'>Follower list</p>
<!-- 自分のフォロワー一覧表示 -->
<div>
  @foreach ($followers_lists as $followers_list)
    <a href='/users/{{ $followers_list->id }}/followProfile'>
      <img class='profile-img' src="/storage/images/{{ $followers_list->images }}" alt=""></a>
  @endforeach
</div>

<hr>

<!-- フォロワーの投稿内容を表示 -->
<table class='page-header table-space'>
    <tr>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
    </tr>

    <!-- プロフィール画像、ユーザー名、投稿内容、投稿日時を表示 -->
    @foreach ($followers_posts as $followers_post)
    <tr>
      <td class='post'>
        <a href='/users/{{ $followers_post->id }}/followProfile'>
        <img class='profile-img' src='/storage/images/{{ $followers_post->images }}' alt=''></a>
      </td>
      <td class='post'>{{ $followers_post->username }}</td>
      <td class='post'>{{ $followers_post->posts }}</td>
      <td class='post post-time'>{{ $followers_post->created_at }}</td>
    </tr>
    @endforeach
</table>

@endsection
