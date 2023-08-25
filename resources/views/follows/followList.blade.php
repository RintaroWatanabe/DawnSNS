@extends('layouts.login')

@section('content')

<p>Follow list</p>
<!-- 自分のフォローユーザーのアイコンを一覧で表示 -->
<div>
  @foreach ($follows_lists as $follows_list)
    <a href='/users/{{ $follows_list->id }}/followProfile'>
      <img src="/storage/images/{{ $follows_list->images }}" alt=""></a>
  @endforeach
</div>

<table class='page-header'>
    <tr>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
    </tr>

    <!-- プロフィール画像、ユーザー名、投稿内容、投稿日時を表示 -->
    @foreach ($follows_posts as $follows_post)
    <tr>
      <td>
        <a href='/users/{{ $follows_post->id }}/followProfile'>
        <img src="/storage/images/{{ $follows_post->images }}" alt=""></a>
      </td>
      <td>{{ $follows_post->username }}</td>
      <td>{{ $follows_post->posts }}</td>
      <td>{{ $follows_post->created_at }}</td>
    </tr>
    @endforeach
</table>

@endsection
