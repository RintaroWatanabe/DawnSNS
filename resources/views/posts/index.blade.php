@extends('layouts.login')

@section('content')

  <!-- 新規登録入力欄 -->
  <div class='container'>
    {{ Form::open(['url' => '/top']) }}
      <div class='form-group new-post'>
        {{ Form::text('newPost', null, ['required', 'class' => 'form-control', 'placeholder' => '何をつぶやこうか...？']) }}
        <!-- 150文字以上入力されたらエラーメッセージを表示 -->
        @error('newPost')
        {{$message}}
        @enderror
      <button type='submit' class='btn btn-success pull-right'>投稿する</button>
      </div>
    {{ Form::close() }}
  </div>


  <!-- 投稿一覧表示 -->
  <table class='page-header table-space'>
    <tr>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
    </tr>
    @foreach ($posts as $post)
    <tr>
      <td class="post"><img src="storage//images/{{ $post->images}}" alt=""></td>
      <td class="post">{{ $post->username }}</td>
      <td class="post">{{ $post->posts }}</td>
      <td class="post">
        <!-- 投稿内容の編集ボタン -->
        <!-- 自分の投稿のみ編集ボタンを表示させる -->
        @if($post->user_id == $user_id)
        {{ Form::open(['url' => 'posts/update']) }}
          <div class='post form-group up-post'>
            {{ Form::text('upPost', $post->posts, ['required', 'class' => 'form-control']) }}
            <!-- 150文字以上入力されたらエラーメッセージを表示 -->
            @error('upPost')
            {{$message}}
            @enderror
            <!-- 自分のidを一緒に送る -->
            {!! Form::hidden("id", $post->id) !!}
          <button type='submit' class='post btn btn-success pull-right'> <img src="storage//images/edit.png" alt="編集ボタン"> </button>
          </div>
        {{ Form::close() }}
        @endif
      </td>
      <!-- 投稿内容の削除ボタン -->
      <td class="post">
        <!-- 自分の投稿のみ削除ボタンを表示させる -->
        @if($post->user_id == $user_id)
          {{ Form::open(['url' => '/posts/delete', 'onsubmit' => 'return confirmDelete();']) }}
          <!-- 自分のidを一緒に送る -->
          {!! Form::hidden("id", $post->id) !!}
          <button type='submit' class='btn btn-success pull-right'> <img src="storage//images/trash.png" alt="削除ボタン"> </button>
          {{ Form::close() }}
        @endif
      </td>
      <td class="post">{{ $post->created_at }}</td>
    </tr>
    @endforeach
  </table>

  <script>
    function confirmDelete() {
        return confirm("この投稿を削除してよろしいですか？");
    }
  </script>

@endsection
