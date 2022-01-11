@extends('layout')
@section('content')
    <br>
    <h2 style="padding-left:350px;"> 댓글 수정 </h2>
    <br><br>

    <div id="reply-edit-table">
        <input type="hidden" name="reply_id" value="{{ $reply->id }}">
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            const token = localStorage.getItem('token');
            const id = $("input[name=reply_id]").val();

            $.ajax({
                url: '/api/user/replies/' + id + '/edit',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                },
                success: function (data) {
                    $(".reply-edit-table").html(data.data.html);
                }, error: function (status) {
                    alert('replies.edit 통신 실패');
                }
            });
        });
    </script>
@endsection


