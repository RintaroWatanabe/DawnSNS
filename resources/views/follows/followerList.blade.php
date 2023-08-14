@extends('layouts.login')

@section('content')

<table class='page-header'>
    <tr>
      <th>Follower list</th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
    </tr>
    <tr>
      <td>
        <!-- 自分のフォロワー一覧表示 -->
        @foreach ($followers_lists as $followers_list)
          <a href='/users/{{ $followers_list->id }}/followProfile'>
           <img src="/images/{{ $followers_list->images }}" alt=""></a>
        @endforeach
      </td>
    </tr>
    @foreach ($followers as $follower)
    <tr>
      <td>{{ $follower->username }}</td>
      <td>{{ $follower->images }}</td>
      <td>{{ $follower->posts }}</td>
      <td>{{ $follower->created_at }}</td>
    </tr>
    @endforeach
</table>

@endsection
