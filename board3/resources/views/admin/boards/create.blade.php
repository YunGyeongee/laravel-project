@extends('layout')
@section('content')
    <br>
    <h2 style="padding-left:350px;"> 게시글 작성 </h2>
    <br><br>

    <div class="create-table" style="width:800px;">
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            const token = localStorage.getItem('token');

            $.ajax({
                url: '/api/user/admin/boards/create',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                },
                success: function (data) {
                    $(".create-table").html(data.data.html);
                }, error : function (status) {
                    if (status === 401) {
                        alert('로그인 후 글작성이 가능합니다.');
                        location.href = '/users'
                    }
                    console.log('boards.create 통신 실패');
                }
            });
        });
    </script>


@endsection
