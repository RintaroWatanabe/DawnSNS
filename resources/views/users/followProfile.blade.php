@extends('layouts.login')

@section('content')

<table class='page-header table-space'>
  <!-- ユーザーのプロフィール表示 -->
    <tr>
      <th></th>
      <th>Name</th>
      <th align='left'>Bio</th>
      <th></th>
    </tr>
    <tr>
      <td class='profile-post'><img class='profile-img' src="/storage/images/{{ $users -> images }}" alt=""></td>
      <td class='profile-post'>{{ $users->username }}</td>
      <td class='profile-post'>{{ $users->bio }}</td>
      <td class='profile-post'>
        <!-- 配列$follow_id_listsにidが存在しない＝フォローしていない場合はフォローするボタンを表示 -->
        @if(!in_array($users->id, $follow_id_lists))
          {{ Form::open(['url' => 'users/profile-follow']) }}
          {!! Form::hidden("follow_id", $users->id) !!}
              <button type='submit' class='btn btn-success pull-right follow'>フォローする</button>
          {{ Form::close() }}
        @else   <!-- フォローしているユーザーにはフォローをはずすボタンを表示 -->
          {{ Form::open(['url' => 'users/profile-unfollow']) }}
          {!! Form::hidden("follow_id", $users->id) !!}
          <button type='submit' class='btn btn-success pull-right unfollow'>フォローをはずす</button>
          {{ Form::close() }}
        @endif
      </td>
    </tr>
  </table>

  <!-- 境界線 -->
  <hr>

  <!-- ユーザーの投稿一覧 -->
  <table class='page-header table-space'>
    <tr>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
    </tr>

    @foreach ($posts as $post)
    <tr>
      <td class='post'><img class='profile-img' src="/storage/images/{{ $post -> images }}" alt=""></td>
      <td class='post'>{{ $post-> username}}</td>
      <td class='post'>{{ $post-> posts}}</td>
      <td class='post post-time'>{{ $post-> created_at}}</td>
    </tr>
    @endforeach
  </table>


@endsection
