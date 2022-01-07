<form>
    @csrf
    <table border="1" style="width:800px;">
        <tr align="center">
            <td style="width:30%; height:40px;">글제목</td>
            <td><input type="text" name="title"></td>
        </tr>
        <tr align="center">
            <td style="height:40px;">작성자</td>
            <td>{{ $user->name }}</td>
        </tr>
        <tr align="center">
            <td style="height:200px;">내용</td>
            <td><textarea name="content" id="content" cols="50" rows="30"></textarea></td>
        </tr>
    </table> <br>
    <div align="center">
        <button id="createBtn">작성하기</button>
    </div>
</form>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $('#createBtn').click(function(){
       const token = localStorage.getItem('token');

       $.ajax({
           url: '/api/user/boards/store',
           type: 'post',
           dataType : 'json',
           beforeSend: function (xhr) {
               xhr.setRequestHeader("Accept", "application/json");
               xhr.setRequestHeader("Authorization", "Bearer " + token);
           },
           success: function (data) {
               alert(data);
           }, error(status, request, error) {
               alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
           }
       });
    });
</script>
