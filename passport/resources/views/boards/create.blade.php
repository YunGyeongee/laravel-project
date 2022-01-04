@extends('layout')
@section('content')
    <br>
    <h2 style="padding-left:350px;"> 게시글 작성 </h2>
    <br><br>

    <div class="board-table" style="width:800px;">
        <form>
            <table border="1" style="width:800px;">
                <tr align="center">
                    <td style="width:30%; height:40px;">글제목</td>
                    <td><input type="text" name="title"></td>
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
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#createBtn').click(function(e){

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                    }
                });

                e.preventDefault();
                let title = $("input[name='title']").val();
                let content = $("input[name='content']").val();

                $.ajax({
                    url: "/api/user/store",
                    method: 'post',
                    beforeSend : function (xhr) {
                        xhr.setRequestHeader("Accept", "application/json");
                        xhr.setRequestHeader("Authorization", "Bearer {{ session('api_token') }}");
                    },
                    data: {
                        _token : "{{ csrf_token() }}",
                        title: title,
                        content: content
                    },
                    success: function(){
                        alert('통신 성공');
                        // window.location.replace('/main');
                    }, error: function (request,status,error) {
                        console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                    }
                });
            });
        });
    </script>


@endsection
