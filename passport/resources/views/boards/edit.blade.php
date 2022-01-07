@extends('layout')
@section('content')
    <br>
    <h2 style="padding-left:350px;"> 게시글 수정 </h2>
    <br><br>

    <div class="edit-table" style="width:800px;">
        <input type="hidden" name="board_id" value="{{ $board->id }}">
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            const token = localStorage.getItem('token');
            const id = $("input[name=board_id]").val();

            $.ajax({
                url: '/api/user/boards/' + id + '/edit',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                },
                success: function (data) {
                    $(".edit-table").html(data.data.html);
                }, error: function (status) {
                    alert('boards.edit 통신 실패');
                }
            });
        });
    </script>
@endsection
