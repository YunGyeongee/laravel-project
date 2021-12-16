@extends('layout')
@section('content')
    <div class="board">
        <pre> 
            글 제목 : {{ $board -> title }}
            글 내용 : {{ $board -> content }}
        </pre>
        <a href="/boards/{{ $board->id }}/edit"><button>수정</button></a>
        <a href="/boards"><button>목록</button></a>
        <a href="/boards/{{ $board->id }}"><button>삭제</button></a>
    </div>
    <br>

    <div class="Reply">
        <p>댓글 목록</p><br>
        @foreach($reply as $item)
            <div class="Reply-list">
                <p>익명</p>
                <div>{{ $item -> ReplyContent }}</div>
            </div>
        @endforeach

        <form method="POST" action="/reply/store">
            @csrf
            <input type="hidden" name="board_id" value="{{ $board->id }}">
            <textarea name="ReplyContent"></textarea>
            <input type="submit" value="작성">
        </form>
    </div>
@endsection