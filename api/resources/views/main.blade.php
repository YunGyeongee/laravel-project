@extends('layout')
@section('content')
    
    <h2> 게시글 목록 </h2>
    <a href=""><button>마이페이지</button></a>
    <a href=""><button>로그아웃</button></a>
    <a href="" style="padding-left:780px;"><button>글쓰기</button></a>
    
    <br><br>

    <div class="board-table">
        <table border="1" style="width:1000px;">
            <tr align="center" style="height:40px;">
                <td style="width:15%">글번호</td>
                <td>글제목</td>
                <td style="width:25%">작성일</td>
            </tr>
            @($boards as $board)
            <tr align="center">
                <td>{{ $board->id }}</td>
                <td><a href="">{{ $board->title }}</a></td>
                <td>{{ $board->created_at }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <br><br>

@endsection