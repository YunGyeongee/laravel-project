@extends('layout')
@section('content')
    <pre> 
        글 제목 : {{ $board -> title }}
        글 내용 : {{ $board -> content }}
    </pre>
    <a href="/boards/{{ $board->id }}/edit">수정</a>
    <a href="/boards">목록</a>
@endsection