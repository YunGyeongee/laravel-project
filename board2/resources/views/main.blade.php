@extends('layout')
@section('content')
    
    <h2> 게시글 목록 </h2>

    @foreach($members as $member)
    <a href="/members/{{$member->id}}"><button>마이페이지</button></a>
    <a href="/logout"><button>로그아웃</button></a>
    
    <a href="" style="padding-left:780px;"><button>글쓰기</button></a>
    <br><br>

    <div class="board-table">
        <table border="1" style="width:1000px;">
            <tr align="center" style="height:40px;">
                <td style="width:15%">글번호</td>
                <td>글제목</td>
                <td style="width:25%">작성자</td>
            </tr>
            <tr align="center">
                <td>1</td>
                <td>2</td>
                <td>3</td>
            </tr>
        </table>
    </div>
    @endforeach
    


@endsection