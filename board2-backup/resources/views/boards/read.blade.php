@extends('layout')
@section('content')
    <br>
    <div class="board-table">
        <table border="1" style="width:800px;">
            <tr align="center" style="height:40px;">
                <td style="width:20%">글제목</td>
                <td>{{ $board->title }}</td>
            </tr>
            <tr align="center" style="height:300px;">
                <td>글내용</td>
                <td>{{ $board->content}}</td>
            </tr>
        </table> <br>
        <div style="padding-left:700px;">
            <a href=""><button>수정</button></a> 
            <a href=""><button>삭제</button></a>
        </div>

        <br>
        <p> * 댓글 목록 </p>
        <form action="" method="post" style="padding-left:580px;">
            <input type="text" name="content" placeholder="댓글을 입력하세요.">
            <input type="submit" value="작성">
        </form>
        <table border="1" style="width:800px;">
            <tr align="center" style="height:35px;">
                <td style="width:10%">댓글번호</td>
                <td>댓글 내용</td>
                <td style="width:20%">작성자</td>
            </tr>

            <tr align="center" style="height:35px;">
                <td style="width:20%">123</td>
                <td>sdf</td>
                <td>김부각</td>
            </tr>
        </table>

    </div>
    <br><br>

@endsection