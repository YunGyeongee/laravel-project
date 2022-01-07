<form>
    @csrf
    <table border="1" style="width:800px;">
        <tr align="center">
            <td style="width:30%; height:40px;">글제목</td>
            <td><input type="text" name="title"></td>
        </tr>
        <tr align="center">
            <td style="height:40px;">작성자</td>
            <td>ㅈㅅㅈ</td>
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
