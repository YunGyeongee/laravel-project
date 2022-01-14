@extends('layout')
@section('content')

    <h2> 게시글 목록 </h2>

    <button id="myPageBtn">마이페이지</button>
    <button id="logoutBtn">로그아웃</button>
    <button id="adminHomeBtn">관리자 페이지</button>

    <a style="padding-left:670px;"><button id="writeBtn">글쓰기</button></a>

    <br><br>

    <div class="board-table">
        <table border="1" style="width:1000px;">
            <tr align="center" style="height:40px;">
                <td style="width:15%">글번호</td>
                <td>글제목</td>
                <td style="width:25%">작성일</td>
            </tr>
            @foreach($boards as $board)
            <tr align="center">
                <td>{{ $board->id }}</td>
                <td><a href="/boards/{{ $board->id }}">{{ $board->title }}</a></td>
                <td>{{ $board->created_at }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <br><br>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            const token = localStorage.getItem('token');

            $('#logoutBtn').click(function (e) {
                $.ajax({
                    url: '/api/user/logout',
                    type: 'post',
                    dataType : 'json',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader("Accept", "application/json");
                        xhr.setRequestHeader("Authorization", "Bearer " + token);
                    },
                    success: function (data) {
                        console.log(data.data);
                        window.location.replace('/');
                    }, error() {
                        alert('로그아웃 실패');
                    }
                });
            })

            $('#myPageBtn').click(function () {
                $.ajax({
                    url: '/api/user/myPage',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader("Accept", "application/json");
                        xhr.setRequestHeader("Authorization", "Bearer " + token);
                    },
                    success: function (data) {
                        location.href = '/users/mypage';
                    }, error: function (status, request, error) {
                        if (status === 401) {
                            location.href = '/users';
                        }
                        alert('마이페이지 조회 실패');
                    }
                });
            });

            $('#writeBtn').click(function () {
               $.ajax({
                   url: '/api/user/boards/create',
                   beforeSend: function (xhr) {
                       xhr.setRequestHeader("Accept", "application/json");
                       xhr.setRequestHeader("Authorization", "Bearer " + token);
                   },
                   success: function (data) {
                       console.log(data.data.html);
                       location.href = '/boards/create';
                   }, error : function (status) {
                       if (status === 401) {
                           alert('로그인 후 글작성이 가능합니다.');
                           location.href = '/users'
                       }
                       alert('글쓰기폼 통신 실패');
                   }
               });
            });

            $('#adminHomeBtn').click(function () {
                $.ajax({
                    url: '/api/user/adminpage',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader("Accept", "application/json");
                        xhr.setRequestHeader("Authorization", "Bearer " + token);
                    },
                    success: function (data) {
                        location.href = '/admin'
                    }, error : function (status) {
                        if (status === 401) {
                            alert('로그인 후 이용해주세요.');
                        }
                        alert('관리자만 볼 수 있는 페이지 입니다.');
                        location.href = '/boards';
                    }
                });
            });
        });
    </script>
@endsection
