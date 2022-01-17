@extends('layout')
@section('content')

    <br>
    <h2>회원 상세 정보</h2>
    <br><br>

    <div class="user-table" style="width: 1000px;">
        <table border="1" style="width: 1000px;">
            <tr align="center" style="height: 40px;">
                <th style="width: 40%;">회원 번호</th>
                <td>{{ $user->id }}</td>
            </tr>
            <tr align="center" style="height: 40px;">
                <th>회원 이름</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr align="center" style="height: 40px;">
                <th>회원 비밀번호</th>
                <td>{{ $user->password }}</td>
            </tr>
            <tr align="center" style="height: 40px;">
                <th>회원 닉네임</th>
                <td>{{ $user->nickname }}</td>
            </tr>
            <tr align="center" style="height: 40px;">
                <th>회원 상태</th>
                <td>{{ $user->status }}</td>
            </tr>
            <tr align="center" style="height: 40px;">
                <th>회원 가입일</th>
                <td>{{ $user->created_at }}</td>
            </tr>
        </table>
        <br>
        <div class="edit" align="right">
            <button id="editInfo">회원 강제 탈퇴</button>
        </div>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $('#editInfo').click(function () {
            const token = localStorage.getItem('token');
            const id =

            $.ajax({
                url: '/api/user/admin/destroy',
                type: 'post',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                },
                success: function (data) {
                    console.log(data.data);
                    location.reload('/admin/users');
                }, error(data, status) {
                    alert('강제탈퇴 실패');
                    alert(data.data);
                    alert(status);
                }
            });
        })
    </script>
@endsection
