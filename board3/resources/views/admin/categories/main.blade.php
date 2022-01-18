@extends('layout')
@section('content')
    <h2> 게시판 관리 목록 </h2>
    <button onclick="location.href='/admin'">이전으로</button>

    <a style="padding-left:620px;"><button id="createBtn">카테고리 생성</button></a>
    <br><br>

    <div class="category-table" style="width: 800px;">
        <table border="1" style="width:800px;">
            <tr align="center" style="height:40px;">
                <td style="width: 15%">카테고리 번호</td>
                <td>카테고리 이름</td>
                <td style="width: 30%">카테고리 생성일</td>
                <td style="width: 15%">카테고리 상태</td>
            </tr>
            @foreach($categories as $category)
                <tr align="center">
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->created_at }}</td>
                    <td>{{ $category->status }}</td>
                </tr>
            @endforeach
        </table>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $('#createBtn').click(function () {
            const token = localStorage.getItem('token');
            $.ajax({
                url: '/api/user/admin/categories/create',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                },
                success: function (data) {
                    console.log(data.data.html);
                    location.href = '/admin/categories/create';
                }, error : function (status) {
                    if (status === 401) {
                        alert('로그인 후 글작성이 가능합니다.');
                        location.href = '/users'
                    }
                    alert('카테고리 생성 통신 실패');
                }
            });
        });
    </script>
@endsection
