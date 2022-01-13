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
            <button onclick="location.href='/boards'">목록</button>
            <button id="deleteBtn">삭제</button>
        </div>
        <br><br>
    </div>

    <div class="reply" style="width:800px;">
        <p>댓글 목록 </p>
        <form align="right">
            @csrf
            <input type="hidden" name="board_id" value="{{ $board->id }}">
            <input type="hidden" name="member_id" value="{{ $board->name }}">
            <input type="text" name="content" placeholder="댓글을 작성해주세요.">
            <input type="submit" id="replyBtn" valud="등록">
        </form>
        </p>
        <hr>
        <table border="1" style="width:800px;">
            <tr align="center">
                <td style="width:60%; height:40px;">댓글 내용</td>
                <td style="width:15%;">작성자</td>
                <td style="width:25%;">작성일</td>
            </tr>
            @foreach($replies as $reply)
                <tr align="center">
                    <td>
                        {{ $reply->content }}
                        <input type="hidden" name="reply_id" value="{{ $reply->id }}">
                        <input type="hidden" name="reply_content" value="{{ $reply->content }}">
                        <button id="reEditBtn">수정</button>
                        <button id="reDeleteBtn">삭제</button>
                    </td>
                    <td>{{ $reply->name }}</td>
                    <td>{{ $reply->created_at }}</td>
                </tr>
            @endforeach
        </table>
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
                        // alert('게시물이 성공적으로 수정되었습니다.');
                        location.href = '/boards/' + id + '/edit';
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
                    url: '/api/user/boards/' + id +'/destroy',
                    type:'post',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader("Accept", "application/json");
                        xhr.setRequestHeader("Authorization", "Bearer " + token);
                    },
                    success: function (data) {
                        // alert('게시물이 성공적으로 삭제되었습니다.');
                        location.href = '/boards';
                    }, error(data, request, status, error) {
                        console.log('deleteBtn 오류');
                        console.log(data.data);
                        console.log("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
                    }
                });
            });
        });

        $('#replyBtn').click(function() {
            const token = localStorage.getItem('token');
            const content = $('input[name=content]').val();
            const id = $('input[name=board_id]').val();

            $.ajax({
                url: '/api/user/boards/' + id + '/replies/store',
                type: 'post',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                },
                data:{
                    content: content
                },
                success: function (data) {
                    alert('댓글 작성 성공');
                    location.href = '/boards/' + id;
                }, error(data, request, status, error) {
                    alert('replyBtn 오류');
                    alert(data.data);
                    alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
                }
            });
        });

        $('#reEditBtn').click(function() {
            const token = localStorage.getItem('token');
            const content = $('input[name=reply_content]').val();
            const rid = $('input[name=reply_id]').val();
            const bid = $('input[name=board_id]').val();

            $.ajax({
                url: '/api/user/replies/' + rid + '/edit',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                },
                data:{
                    bid: bid,
                    content: content,
                },
                success: function (data) {
                    console.log(data.data);
                    location.href = '/boards';
                }, error(data, request, status, error) {
                    console.log('reEditBtn 에러');
                    console.log(data.data);
                    console.log("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
                }
            });
        });

        $('#reDeleteBtn').click(function() {
            const token = localStorage.getItem('token');
            const id = $('input[name=reply_id]').val();

            $.ajax({
                url: '/api/user/replies/' + id +'/destroy',
                type:'post',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                },
                success: function (data) {
                    console.log(data.data);
                    location.href = '/boards';
                }, error(data, request, status, error) {
                    console.log('reDeleteBtn 오류');
                    console.log(data.data);
                    console.log("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
                }
            });
        });
    </script>
@endsection
