<table border="1" style="width:600px;">
    <tr align="center">
        <td style="width:20%; height:40px;">회원번호</td>
        <td><input type="text" name="id" value="{{ $user->id }}" readonly></td>
    </tr>
    <tr align="center">
        <td style="height:40px;">이름</td>
        <td><input type="text" name="name" value="{{ $user->name }}" readonly></td>
    </tr>
    <tr align="center">
        <td style="height:40px;">이메일</td>
        <td><input type="text" name="email" value="{{ $user->email }}" readonly></td>
    </tr>
    <tr align="center">
        <form method="POST" action="/users/update">
            @csrf
            <td style="height:40px;">닉네임</td>
            <td>
                <input type="text" name="nickname" value="{{ $user->nickname }}">
                <input id="changeBtn" type="submit" value="변경">
            </td>
        </form>
    </tr>
</table>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $('#changeBtn').click(function() {

        const token = localStorage.getItem('token');
        const nickname = $("input[name='nickname']").val();

        $.ajax({
            url: '/api/user/myPage/update',
            type: 'POST',
            dataType : 'json',
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Accept", "application/json");
                xhr.setRequestHeader("Authorization", "Bearer " + token);
            },
            data: {
                nickname: nickname,
            },
            success: function(data) {
                alert("정보변경 성공");
                location.href = '/boards';
            }, error(request, status, error){
                alert("정보변경 실패");
                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
        });
    });
</script>

