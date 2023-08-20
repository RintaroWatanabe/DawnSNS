@extends('layouts.login')

@section('content')

  <!-- 新規登録入力欄 -->
  <div class='container'>
    {{ Form::open(['url' => '/top']) }}
      <div class='form-group'>
        {{ Form::text('newPost', null, ['required', 'class' => 'form-control', 'placeholder' => '何をつぶやこうか...？']) }}
      <button type='submit' class='btn btn-success pull-right'>投稿する</button>
      </div>
    {{ Form::close() }}
  </div>


  <!-- 投稿一覧表示 -->
  <table class='page-header'>
    <tr>
      <th>投稿者</th>
      <th>投稿内容</th>
      <th></th>
      <th></th>
      <th></th>
    </tr>
    @foreach ($posts as $post)
    <tr>
      <td>{{ $post->username }}</td>
      <td>{{ $post->posts }}</td>
      <td>
        <!-- 投稿内容の更新ボタン -->
        {{ Form::open(['url' => 'posts/update']) }}
          <div class='form-group'>
            {{ Form::text('upPost', $post->posts, ['required', 'class' => 'form-control']) }}
            {!! Form::hidden("id", $post->id) !!}
          <button type='submit' class='btn btn-success pull-right'>更新</button>
          </div>
        {{ Form::close() }}
      </td>
      <!-- 投稿内容の削除ボタン -->
      <td><a class='btn btn-danger' href='/posts/{{ $post->id }}/delete' onclick="return confirm('こちらの投稿を削除してよろしいですか？')">削除</a></td>
      <td>{{ $post->created_at }}</td>
    </tr>
    @endforeach
  </table>

@endsection
