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
      <td></td>
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
