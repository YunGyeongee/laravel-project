@extends('layout')
@section('content')
    <br>
    <h2 style="padding-left:350px;"> 게시글 상세보기 </h2>
    <br><br>
    
    <div class="board-table" style="width:800px;">
        <table border="1" style="width:800px;">
            <tr align="center">
                <td style="width:30%; height:40px;">글제목</td>
                <td>{{ $board->title }}</td>
            </tr>
            <tr align="center">
                <td style="height:40px;">작성자</td>
                <td>{{ $board->name }}</td>
            </tr>
            <tr align="center">
                <td style="height:200px;">내용</td>
                <td><textarea name="content" id="content" cols="50" rows="30" readonly>{{ $board->content }}</textarea></td>
            </tr>
        </table> <br>
        <div align="center">
            <a href="/boards/{{$board->id}}/edit"><button>수정</button></a> 
            <a href="/boards"><button>목록</button></a>
            <form style="display:inline;" action="/boards/{{ $board->id }}" method="POST">
                @csrf
                <input type="hidden" name="board_id" value="{{$board->id}}">
                <button>삭제</button>
            </form>
        </div>
        <br><br>

        <div class="reply">
            <p>
                댓글 목록
                <form action="/replies/store" method="post" align="right">
                @csrf
                    <input type="hidden" name="board_id" value="{{ $board->id }}">
                    <input type="text" name="content" placeholder="댓글을 작성해주세요.">
                    <input type="submit" valud="등록">
                </form>
            </p> 
            <hr>
                <table border="1" style="width:800px;">
                    <tr align="center">
                        <td style="width:60%; height:40px;">댓글 내용</td>
                        <td style="width:15%;">작성자</td>
                        <td style="width:25%;">작성일</td>
                    </tr>
                    @foreach($replies as $reply)
                    <tr align="center">
                        <td>{{ $reply->content }}</td>
                        <td>{{ $reply->name }}</td>
                        <td>{{ $reply->created_at }}</td>
                    </tr>
                    @endforeach
                </table>    
            <br>

            <br>
        </div>
    </div>
@endsection