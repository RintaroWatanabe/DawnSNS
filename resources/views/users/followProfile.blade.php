@extends('layouts.login')

@section('content')

<table class='page-header'>
  <!-- ユーザーのプロフィール表示 -->
    <tr>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
    </tr>
    <tr>
      <td><img src="/storage/images/{{ $users -> images }}" alt=""></td>
      <td>{{ $users->username }}</td>
      <td>{{ $users->bio }}</td>
      <td>
        <!-- 配列$follow_id_listsにidが存在しない＝フォローしていない場合はフォローするボタンを表示 -->
        @if(!in_array($users->id, $follow_id_lists))
          {{ Form::open(['url' => 'users/profile-follow']) }}
          {!! Form::hidden("follow_id", $users->id) !!}
              <button type='submit' class='btn btn-success pull-right'>フォローする</button>
          {{ Form::close() }}
        @else   <!-- フォローしているユーザーにはフォローをはずすボタンを表示 -->
          {{ Form::open(['url' => 'users/profile-unfollow']) }}
          {!! Form::hidden("follow_id", $users->id) !!}
          <button type='submit' class='btn btn-success pull-right'>フォローをはずす</button>
          {{ Form::close() }}
        @endif
      </td>
    </tr>
  </table>

  <!-- ユーザーの投稿一覧 -->
  <div>
    <ul>
      @foreach ($posts as $post)
        <li>
        <img src="storage//images/{{ $post -> images }}" alt="">
        {{ $post-> username}}
        {{ $post-> posts}}
        </li>
      @endforeach
    </ul>
  </div>


@endsection
