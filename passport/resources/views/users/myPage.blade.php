@extends('layout')
@section('content')

    <h2 style="padding-left:270px;"> 마이페이지 </h2>

    <a href="{{route('main')}}" style="padding-left:530px;"><button>메인으로</button></a>
    <br><br>

    <div class="board-table">
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            const token = localStorage.getItem('token');

            $.ajax({
                url: '/api/user/myPage',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                },

                success: function (data) {
                    $(".board-table").html(data.data.html);
                }, error: function (request, status, error) {
                    if (status === 401) {
                        alert('다시 로그인 해주세요.');
                        location.href = '/users';
                    }
                    alert('마이페이지 조회 실패');
                    console.log("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);

                }
            });
        });
    </script>

@endsection
