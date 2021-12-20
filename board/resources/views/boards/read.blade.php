@extends('layout')
@section('content')
    <div class="board">
        <pre> 
            글 제목 : {{ $board -> title }}
            글 내용 : {{ $board -> content }}
        </pre>
        <a href="/boards/{{ $board->id }}/edit"><button>수정</button></a>
        <a href="/boards"><button>목록</button></a>
        <form style="display:inline;" action="/boards/{{ $board->id }}" method="POST">
        <input type="hidden" name="board_id" value="{{ $board->id }}">
            @csrf
            @method('DELETE')
        <button>삭제</button>
        </form>
    </div>
    <br>

    <div class="Reply">
        <p>댓글 목록</p><br>
        @foreach($reply as $item)
            <div class="Reply-list">
                <p>
                    익명 | {{ $item -> content }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                    <a href="/replies/{{$item->id}}/edit"><button>수정</button></a>&nbsp;
                    <a href="/boards/reply/destroy?id={{$item->id}}"><button><input type="hidden" name="r_board_id" value="{{ $board->id }}">삭제</button></a>
                </p> 
            </div>
        @endforeach

        <form method="POST" action="/boards/reply">
            @csrf
            <input type="hidden" name="board_id" value="{{ $board->id }}">
            <textarea cols="50" rows="2" name="content"></textarea>
            <input type="submit" value="작성">
        </form>
    </div>
@endsection