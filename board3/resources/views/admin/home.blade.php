@extends('layout')
@section('content')
    <h1> ADMIN HOME </h1>

    <div class="admin-table">
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            const token = localStorage.getItem('token');

            $.ajax({
                url: '/api/user/adminpage',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                },
                success: function (data) {
                    $(".admin-table").html(data.data.html);
                }, error: function (status) {
                    if (status === 401) {
                        alert('다시 로그인 해주세요.');
                        location.href = '/users';
                    }
                    alert('관리자 페이지 조회 실패');
                    location.href = '/boards';
                }
            });
        });
    </script>
@endsection
