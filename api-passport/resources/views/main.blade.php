@extends('layout')
@section('content')

    <h2> 게시글 목록 </h2>
    <a href="/myPage"><button>마이페이지</button></a>
    <button id="logoutBtn">로그아웃</button>
    <a href="/boards/create" style="padding-left:780px;"><button>글쓰기</button></a>

    <br><br>

    <div class="board-table">
        <table border="1" style="width:1000px;">
            <tr align="center" style="height:40px;">
                <td style="width:15%">글번호</td>
                <td>글제목</td>
                <td style="width:25%">작성일</td>
            </tr>
{{--            @foreach($boards as $board)--}}
            <tr align="center">
                <td>12</td>
                <td><a href="">ㅈㅁ</a></td>
                <td>2021-12-30</td>
            </tr>
{{--            @endforeach--}}
        </table>
    </div>
    <br><br>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#logoutBtn').click(function(e){

                e.preventDefault();
                $.ajax({
                    url:'/api/user/logout',
                    type: 'post',
                    success:function(){
                        window.location.replace('/');
                    }, error () {
                        alert('ajax 통신 실패');
                    }
                });
            })
        })



    </script>

@endsection
