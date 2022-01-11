<form>
    @csrf
    <label> * 댓글 내용</label><br><br>
    <textarea cols="50" rows="2" id="content" name="content">{{$reply->content}}</textarea>
    <input type="submit" id="updateBtn" value="수정">
</form>

