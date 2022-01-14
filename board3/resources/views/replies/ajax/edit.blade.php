<form align="center">
    @csrf
    <input type="hidden" name="reply_id" value="{{ $reply->id }}">
    <input type="hidden" name="board_id" value="{{ $reply->board_id }}">
    <textarea cols="50" rows="2" id="content" name="content">{{ $reply->content }}</textarea>
    <br><br>
    <input type="submit" id="updateBtn" value="수정">
</form>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $('#updateBtn').click(function() {
        const token = localStorage.getItem('token');
        const id = $("input[name='reply_id']").val();
        const bid = $("input[name='board_id']").val();
        const content = $("textarea[name='content']").val();

        $.ajax({
            url: '/api/user/replies/' + id,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Accept", "application/json");
                xhr.setRequestHeader("Authorization", "Bearer " + token);
            },
            data: {
                content: content
            },
            success: function(data) {
                // alert("댓글 수정 성공");
                location.href = '/boards/' + bid;
            }, error: function(request, status, error) {
                alert("댓글 수정 실패");
                alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
        });
    });
</script>
