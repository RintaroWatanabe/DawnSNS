@extends('layouts.login')

@section('content')

<table class='page-header'>
    <tr>
      <th>Follow list</th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
    </tr>
    <tr>
      <td>
        <!-- 自分のフォローユーザー一覧表示 -->
        @foreach ($follows_lists as $follows_list)
          <ul><li><img src="/images/{{ $follows_list->images }}" alt=""></li></ul>
        @endforeach
      </td>
    </tr>
    @foreach ($follows as $follow)
    <tr>
      <td>{{ $follow->username }}</td>
      <td>{{ $follow->images }}</td>
      <td>{{ $follow->posts }}</td>
      <td>{{ $follow->created_at }}</td>
    </tr>
    @endforeach
</table>

@endsection
