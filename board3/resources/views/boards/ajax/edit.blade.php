<form>
@csrf
    <input type="hidden" name="board_id" value="{{ $board->id }}">
    <table border="1" style="width:800px;">
        <tr align="center">
            <td style="width:30%; height:40px;">글제목</td>
            <td><input type="text" name="title" value="{{ $board->title }}"></td>
        </tr>
        <tr align="center">
            <td style="height:40px;">작성자</td>
            <td>{{ $board->name }}</td>
        </tr>
        <tr align="center">
            <td style="height:200px;">내용</td>
            <td><textarea name="content" id="content" cols="50" rows="30">{{ $board->content }}</textarea></td>
        </tr>
    </table> <br>
    <div align="center">
        <input type="submit" id="updateBtn" value="저장">
        <input type="reset" id="reBtn" value="취소">
    </div>
</form>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $('#reBtn').click(function(){
        location.href = '/boards';
    });

    $('#updateBtn').click(function() {

        const id = $("input[name=board_id]").val();
        const token = localStorage.getItem('token');
        const title = $("input[name='title']").val();
        const content = $("textarea[name='content']").val();

        $.ajax({
            url: '/api/user/boards/view/' + id,
            type: 'POST',
            dataType : 'json',
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Accept", "application/json");
                xhr.setRequestHeader("Authorization", "Bearer " + token);
            },
            data: {
                title: title,
                content: content,
            },
            success: function(data) {
                // alert("게시글 수정 성공");
                location.href = '/boards/view/' + id ;
            }, error(request, status, error){
                alert("게시글 수정 실패");
                alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
        });
    });
</script>
