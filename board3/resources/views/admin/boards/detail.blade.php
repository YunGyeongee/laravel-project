@extends('layout')
@section('content')
    <br>
    <h2 style="padding-left:350px;"> 게시글 상세보기 </h2>
    <br><br>

    <div class="board-table" style="width:800px;">
        <table border="1" style="width:800px;">
            <input type="hidden" name="board_id" value="{{ $board->id }}">
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
            <button onclick="location.href='/admin/boards'">목록</button>
            <button id="deleteBtn">삭제</button>
        </div>
        <br><br>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $('#editBtn').click(function () {
            const token = localStorage.getItem('token');
            const id = $('input[name=board_id]').val();

            $.ajax({
                url: '/api/user/admin/boards/view/' + id + '/edit',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                },
                success: function (data) {
                    // alert('게시물이 성공적으로 수정되었습니다.');
                    console.log(data.data);
                    location.href = '/admin/boards/view/' + id + '/edit';
                }, error(data, request, status, error) {
                    console.log('editBtn 에러');
                    console.log(data.data);
                    console.log("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
                }
            });
        });

        $('#deleteBtn').click(function() {
            const token = localStorage.getItem('token');
            const id = $('input[name=board_id]').val();

            $.ajax({
                url: '/api/user/admin/boards/view/' + id +'/destroy',
                type:'post',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                },
                success: function (data) {
                    // alert('게시물이 성공적으로 삭제되었습니다.');
                    location.href = '/admin/boards';
                }, error(data, request, status, error) {
                    console.log('admin.deleteBtn 오류');
                    console.log(data.data);
                    console.log("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
                }
            });
        });
    </script>
@endsection
