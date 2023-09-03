@extends('layouts.login')

@section('content')

  <!-- 新規登録入力欄 -->
  <div class='container'>
    {{ Form::open(['url' => '/top']) }}
      <div class='form-group new-post'>
        <img class='profile-img' src="storage/images/{{ Auth::user()->images }}" alt="">
        {{ Form::textarea('newPost', null, ['required', 'class' => 'form-control', 'cols'=> 75, 'rows' => 3, 'placeholder' => '何をつぶやこうか...？']) }}
        <!-- 150文字以上入力されたらエラーメッセージを表示 -->
        @error('newPost')
        {{$message}}
        @enderror
      <button type='submit' class='btn btn-success pull-right post-btn'>
        <img src="storage/images/post.png" alt=""></button>
      </div>
    {{ Form::close() }}
  </div>

  <hr size=3 noshade>

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
      <td class="post"><img class='profile-img' src="storage//images/{{ $post->images}}" alt=""></td>
      <td class="post">{{ $post->username }}</td>
      <td class="post">{{ $post->posts }}</td>
      <td class="post">
        <!-- 投稿内容の編集ボタン -->
        <!-- 自分の投稿のみ編集ボタンを表示させる -->
        @if($post->user_id == $user_id)

        <!-- 編集ボタン -->
        <img src="storage/images/edit.png" alt="編集ボタン" data-target='modal-edit'>

        <!-- 編集ボタンを押した時のモーダル -->
        <div class='post form-group up-post' id='modal-edit'>
        {{ Form::open(['url' => 'posts/update']) }}
            {{ Form::text('upPost', $post->posts, ['required', 'class' => 'form-control-edit']) }}
            <!-- 150文字以上入力されたらエラーメッセージを表示 -->
            @error('upPost')
            {{$message}}
            @enderror
            <!-- 自分のidを一緒に送る -->
            {!! Form::hidden("id", $post->id) !!}
            <!-- 鉛筆マークの編集ボタン -->
          <button type='submit' class='post btn btn-success pull-right post-btn'>
            <img src="storage/images/edit.png" alt="編集ボタン">
          </button>
        {{ Form::close() }}
        </div>
        @endif
      </td>

      <!-- 投稿内容の削除ボタン -->
      <td class="post">
        <!-- 自分の投稿のみ削除ボタンを表示させる -->
        @if($post->user_id == $user_id)
          {{ Form::open(['url' => '/posts/delete', 'onsubmit' => 'return confirmDelete();']) }}
          <!-- 自分のidを一緒に送る -->
          {!! Form::hidden("id", $post->id) !!}
          <button type='submit' class='btn btn-success pull-right post-btn delete-btn'>
            <img src="storage/images/trash.png" alt="削除ボタン">
            <img src="storage/images/trash_h.png" alt="削除ボタン">
          </button>
          {{ Form::close() }}
        @endif
      </td>
      <td class="post">{{ $post->created_at }}</td>
    </tr>
    @endforeach
  </table>

  <!-- 投稿の削除前に確認 -->
  <script>
    function confirmDelete() {
        return confirm("この投稿を削除してよろしいですか？");
    }
  </script>

@endsection
