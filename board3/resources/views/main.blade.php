@extends('layout')
@section('content')

    <h2> 게시글 목록 </h2>

    <button id="myPageBtn">마이페이지</button>
    <button id="logoutBtn">로그아웃</button>
    <button id="adminHomeBtn">관리자 페이지</button>

    <a style="padding-left:670px;"><button id="writeBtn">글쓰기</button></a>
    <br><br>

    <div class="board-table">
    </div>
    <br><br>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        const token = localStorage.getItem('token');

        $(document).ready(function() {
            $.ajax({
                url: '/api/user/boards',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                },
                success: function (data) {
                    $(".board-table").html(data.data.html);
                }, error: function (status) {
                    if (status === 401) {
                        alert('다시 로그인 해주세요.');
                        location.href = '/users';
                    }
                    alert('메인페이지 조회 실패');
                }
            });
        });

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
                    // window.location.replace('/');
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
                url: '/api/user/adminPage',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                },
                success: function (data) {
                    location.href = '/admin'
                }, error : function (data, status) {
                    if (status === 401) {
                        alert('로그인 후 이용해주세요.');
                    }
                    alert('관리자페이지 오류');
                    console.log(data.data);
                    // location.href = '/boards';
                }
            });
        });
    </script>
@endsection
