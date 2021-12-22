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
            <a href=""><button>수정</button></a> 
            <a href=""><button>삭제</button></a>
        </div>
    </div>
@endsection