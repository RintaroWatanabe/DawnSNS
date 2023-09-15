@extends('layouts.login')

@section('content')

<p class='follow-list-text'>Follow list</p>
<!-- 自分のフォローユーザーのアイコンを一覧で表示 -->
<div>
  @foreach ($follows_lists as $follows_list)
    <a href='/users/{{ $follows_list->id }}/followProfile'>
      <img class='profile-img' src="/storage/images/{{ $follows_list->images }}" alt=""></a>
  @endforeach
</div>

<hr>

<table class='page-header  table-space'>
    <tr>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
    </tr>

    <!-- プロフィール画像、ユーザー名、投稿内容、投稿日時を表示 -->
    @foreach ($follows_posts as $follows_post)
      <tr>
        <td class='post'>
          <a href='/users/{{ $follows_post->id }}/followProfile'>
          <img class='profile-img' src="/storage/images/{{ $follows_post->images }}" alt=""></a>
        </td>
        <td class='post'>{{ $follows_post->username }}</td>
        <td class='post'>{{ $follows_post->posts }}</td>
        <td class='post post-time'>{{ $follows_post->created_at }}</td>
      </tr>
    @endforeach
</table>

@endsection
