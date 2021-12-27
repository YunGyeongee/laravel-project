@extends('layout')
@section('content')
    <br>
    <h2 style="padding-left:350px;"> 게시글 수정 </h2>
    <br><br>
    
    <div class="board-table" style="width:800px;">
        <form action="/boards/{{$board->id}}" method="POST">
        @csrf
            <table border="1" style="width:800px;">
                <tr align="center">
                    <td style="width:30%; height:40px;">글제목</td>
                    <td><input type="text" name="title" value="{{ $board->title }}"></td>
                </tr>
                <tr align="center">
                    <td style="height:40px;">작성자</td>
                    <td>{{ $board->name }}</td>
                </tr>
                <tr align="center">
                    <td style="height:200px;">내용</td>
                    <td><textarea name="content" id="content" cols="50" rows="30">{{ $board->content }}</textarea></td>
                </tr>
            </table> <br>
            <div align="center">
                <input type="submit" value="저장">
                <input type="reset" value="취소">
            </div>
        </form>
    </div>
@endsection