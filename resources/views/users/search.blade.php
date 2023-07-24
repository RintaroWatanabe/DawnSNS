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
    </tr>
    @foreach ($users as $user)
    <tr>
      <td>{{ $user->username }}</td>
      <td>フォローボタン</td>
    </tr>
    @endforeach
  </table>

@endsection
