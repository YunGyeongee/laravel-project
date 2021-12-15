@extends('layout')
@section('content')
    <h2>Board Index</h2>
    @foreach ($boards as $item)
        <li><a href="/boards/{{$item->id}}"> TITLE : {{ $item->title }} </a></li>
    @endforeach
    <br>
    <a href="/boards/create"><button>새 글 작성</button></a>
@endsection