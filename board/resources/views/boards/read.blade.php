@extends('layout')
@section('content')
    <pre> 
        글 제목 : {{ $board -> title }}
        글 내용 : {{ $board -> content }}
    </pre>
@endsection