<form>
@csrf
    <input type="hidden" name="category_id" value="{{ $category->id }}">
    <table border="1" style="width:800px;">
        <tr align="center">
            <td style="width:30%; height:40px;">카테고리 이름</td>
            <td><input type="text" name="name" value="{{ $category->name }}"></td>
        </tr>
    </table> <br>
    <div align="center">
        <input type="submit" id="updateBtn" value="카테고리 변경저장">
        <input type="submit" id="destroyBtn" value="카테고리 비활성화">
    </div>
</form>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
      $('#updateBtn').click(function() {
          const token = localStorage.getItem('token');
          const id = $("input[name=category_id]").val();
          const name = $("input[name='name']").val();

          $.ajax({
              url: '/api/user/admin/categories/view/' + id,
              type: 'POST',
              dataType : 'json',
              beforeSend: function (xhr) {
                  xhr.setRequestHeader("Accept", "application/json");
                  xhr.setRequestHeader("Authorization", "Bearer " + token);
              },
              data: {
                  name: name,
              },
              success: function(data) {
                  // alert("게시글 수정 성공");
                  location.href = '/admin/categories';
              }, error(request, status, error){
                  alert("게시판 수정 실패");
                  alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
              }
          });
      });

      $('#destroyBtn').click(function() {
          const token = localStorage.getItem('token');
          const id = $("input[name=category_id]").val();

          $.ajax({
              url: '/api/user/admin/categories/view/' + id +'/destroy',
              type:'post',
              beforeSend: function (xhr) {
                  xhr.setRequestHeader("Accept", "application/json");
                  xhr.setRequestHeader("Authorization", "Bearer " + token);
              },
              success: function (data) {
                  // alert('게시물이 성공적으로 삭제되었습니다.');
                  location.href = '/admin/categories';
              }, error(data, request, status, error) {
                  console.log('admin.destroyBtn 오류');
                  console.log(data.data);
                  console.log("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
              }
          });
      })

</script>
