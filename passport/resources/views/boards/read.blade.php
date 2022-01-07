@extends('layout')
@section('content')
    <br>
    <h2 style="padding-left:350px;"> 게시글 상세보기 </h2>
    <br><br>

    <div class="board-table" style="width:800px;">
        <table border="1" style="width:800px;">
            <tr align="center">
                <td style="width:30%; height:40px;">글제목</td>
                <td>{{ $board->title }}</td>
            </tr>
            <tr align="center">
                <td style="height:40px;">작성자</td>
                <td>{{ $board->name }}</td>
            </tr>
            <tr align="center">
                <td style="height:200px;">내용</td>
                <td><textarea name="content" id="content" cols="50" rows="30" readonly>{{ $board->content }}</textarea></td>
            </tr>
        </table> <br>
        <div align="center">
            <button id="editBtn">수정</button>
            <button onclick="location.href='/boards'">목록</button>
            <form style="display:inline;">
                @csrf
                <input type="hidden" name="board_id" value="{{$board->id}}">
                <button>삭제</button>
            </form>
        </div>
        <br><br>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#editBtn').click(function () {
                const token = localStorage.getItem('token');
                const id = $('input[name=board_id]').val();

                $.ajax({
                    url: '/api/user/boards/' + id + '/edit',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader("Accept", "application/json");
                        xhr.setRequestHeader("Authorization", "Bearer " + token);
                    },
                    success: function (data) {
                        alert('게시글 수정폼 성공');
                        location.href = '/boards/' + id + '/edit';
                    }, error(data, request, status, error) {
                        alert(data);
                        alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
                    }
                });
            });
        });
    </script>
@endsection
