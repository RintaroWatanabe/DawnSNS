@extends('layouts.login')

@section('content')

<!-- ユーザー一覧の表示 -->

<!-- ユーザー検索ボックス -->
{{ Form::open(['url' => '/users/search']) }}
    <div class='form-group'>
        {{ Form::text('searchUsers', null, ['required', 'class' => 'form-control', 'placeholder' => 'ユーザー名で検索']) }}
        <button type='submit' class='btn btn-success pull-right'>検索</button>
    </div>
{{ Form::close() }}

@if(isset($word))
<p>検索ワード：{{ $word }}</p>
@endif


<!-- ユーザー一覧の表示 -->
<table class='page-header'>
    <tr>
      <th></th>
      <th></th>
      <th></th>
    </tr>
    @foreach ($users as $user)
    <tr>
      <td>{{ $user->username }}</td>
      <!-- 自分の欄にはフォローボタンを表示させない -->
      @if($user->id == $user_id)
          @continue
      @endif

      <!-- フォローボタンの表示 -->
      <td>
      <!-- 配列$follow_id_listsにidが存在しない＝フォローしていない場合はフォローするボタンを表示 -->
      @if(!in_array($user->id, $follow_id_lists))
        {{ Form::open(['url' => 'users/follow']) }}
        {!! Form::hidden("follow_id", $user->id) !!}
        <button type='submit' class='btn btn-success pull-right'>フォローする</button>
        {{ Form::close() }}
      @else   <!-- フォローしているユーザーにはフォローをはずすボタンを表示 -->
        {{ Form::open(['url' => 'users/unfollow']) }}
        {!! Form::hidden("follow_id", $user->id) !!}
        <button type='submit' class='btn btn-success pull-right'>フォローをはずす</button>
        {{ Form::close() }}
      @endif
      </td>
    </tr>

    @endforeach
  </table>

@endsection
