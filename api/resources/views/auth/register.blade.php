@extends('layout')
@section('content')
    <div>
        <h2> 회 원 가 입 </h2>
        <form>
            @csrf
            <p><label for="name">이름 : </label><input id="name" type="text" name="name"></p>
            <p><label for="eamil">이메일 : </label><input id="email" type="email" name="email"></p>
            <p><label for="password">비밀번호 : </label><input id="password" type="password" name="password"></p>
            <p><label for="text">닉네임 : </label><input id="nickname" type="text" name="nickname"></p>
            <button id="registerBtn">회원가입</button>
        </form>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#registerBtn').click(function(e){
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });

            $.ajax({
                url: "/members/store",
                method: 'post',
                data: {
                    name: $('#name').val(),
                    eamil: $('#eamil').val(),
                    password: $('#password').val()
                },
                success: function(){
                    console.log("통신성공");
                }, error() {
                    console.log("통신실패");
                }
                });
            });
        });
    </script>

@endsection