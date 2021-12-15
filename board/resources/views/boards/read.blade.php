@extends('layout')
@section('content')
    <pre> 
        글 제목 : {{ $board -> title }}
        글 내용 : {{ $board -> content }}
    </pre>
    <a href="/boards/{{ $board->id }}/edit"><button>수정</button></a>
    <a href="/boards"><button>목록</button></a>
    <form style="display:inline;" action="/boards/{{ $board->id }}" method="POST">
        @csrf
        @method('DELETE')
    <button>삭제</button>
    </form>
@endsection