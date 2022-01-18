<form>
    @csrf
    <table border="1" style="width:800px;">
        <tr align="center">
            <td style="width:30%; height:40px;">카테고리 이름</td>
            <td><input type="text" name="name"></td>
        </tr>
    </table> <br>
    <div align="center">
        <button id="createBtn">생성하기</button>
    </div>
</form>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $('#createBtn').click(function(){
       const token = localStorage.getItem('token');
       const name = $('input[name="name"]').val();

       $.ajax({
           url: '/api/user/admin/categories/store',
           type: 'post',
           dataType : 'json',
           beforeSend: function (xhr) {
               xhr.setRequestHeader("Accept", "application/json");
               xhr.setRequestHeader("Authorization", "Bearer " + token);
           },
           data: {
               token: token,
               name: name,
           },
           success: function (data) {
               // alert('게시물이 성공적으로 등록되었습니다.');
               location.href = '/admin/categories';
           }, error(status, request, error) {
               alert(data.data);
               console.log('admin.categories.ajax.create 통신 실패');
               alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
           }
       });
    });
</script>
