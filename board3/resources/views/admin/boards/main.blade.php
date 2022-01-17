@extends('layout')
@section('content')

    <h2> 게시글 관리 목록 </h2>
    <button onclick="location.href='/admin'">이전으로</button>
    <button id="writeBtn">글작성</button>
    <br><br>

    <div class="user-table">
        <table border="1" style="width:1000px;">
            <tr align="center" style="height:40px;">
                <td>게시글 번호</td>
                <td style="width: 45%;">게시글 제목</td>
                <td>작성자</td>
                <td>게시글 상태</td>
                <td>게시글 상세보기</td>
            </tr>
            @foreach($boards as $board)
                <tr align="center">
                    <td>{{ $board->id }}</td>
                    <td>{{ $board->title }}</td>
                    <td>{{ $board->name }}</td>
                    <td>{{ $board->status }}</td>
                    <td><a href="/admin/boards/view/{{ $board->id }}">게시물 정보</a></td>
                </tr>
            @endforeach
        </table>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $('#writeBtn').click(function () {
            const token = localStorage.getItem('token');
            $.ajax({
                url: '/api/user/admin/boards/create',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                },
                success: function (data) {
                    console.log(data.data.html);
                    location.href = '/admin/boards/create';
                }, error : function (status) {
                    if (status === 401) {
                        alert('로그인 후 글작성이 가능합니다.');
                        location.href = '/users'
                    }
                    alert('글쓰기폼 통신 실패');
                }
            });
        });
    </script>
@endsection
