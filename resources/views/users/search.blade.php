<link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">

@extends('layouts.login')

@section('content')

<!-- ユーザー一覧の表示 -->

<!-- ユーザー検索ボックス -->
{{ Form::open(['url' => '/users/search']) }}
    <div class='form-group'>
        {{ Form::text('searchUsers', null, ['required', 'class' => 'form-control', 'placeholder' => 'ユーザー名で検索']) }}
        <button type='submit' class='btn btn-success pull-right'>検索(虫眼鏡マークにする)</button>
    </div>
{{ Form::close() }}


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
      <td>
        {{ Form::open(['url' => 'users/follow']) }}
        {!! Form::hidden("follow_id", $user->id) !!}
            <button type='submit' class='btn btn-success pull-right'>フォローする</button>
        {{ Form::close() }}
      </td>
      <td>
        {{ Form::open(['url' => 'users/unfollow']) }}
        {!! Form::hidden("follow_id", $user->id) !!}
        <button type='submit' class='btn btn-success pull-right'>フォローをはずす</button></td>
        {{ Form::close() }}
    </tr>
    @endforeach
  </table>

@endsection
