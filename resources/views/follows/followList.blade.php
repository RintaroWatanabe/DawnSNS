@extends('layouts.login')

@section('content')

<table class='page-header'>
    <tr>
      <th>Follow list</th>
      <th></th>
      <th></th>
      <th></th>
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
