@extends('layouts.login')

@section('content')
<h2>機能を実装していきましょう。</h2>

  <!-- 新規登録入力欄 -->
  <div class='container'>
    {{ Form::open(['url' => '/top']) }}
      <div class='form-group'>
        {{ Form::text('newPost', null, ['required', 'class' => 'form-control', 'placeholder' => '何をつぶやこうか...？']) }}
      </div>
      <button type='submit' class='btn btn-success pull-right'>投稿する</button>
    {{ Form::close() }}
  </div>

  <!-- 投稿一覧表示 -->
  <table class='page-header'>
    <tr>
      <th>投稿内容</th>
      <th></th>
    </tr>
    @foreach ($posts as $post)
    <tr>
      <td>{{ $post->username }}</td>
      <td>{{ $post->posts }}</td>
      <td></td>
      <td><a class='btn btn-danger' href=''>削除</a></td>
    </tr>
    @endforeach
  </table>

@endsection
