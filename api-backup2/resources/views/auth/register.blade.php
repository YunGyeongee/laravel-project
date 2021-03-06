@extends('layout')
@section('content')
    <div>
        <h2> 회 원 가 입 </h2>
        <form>
            @csrf
            <label for="name">이름 : </label><input id="name" type="text" name="name">
            <label for="eamil">이메일 : </label><input id="email" type="email" name="email">
            <label for="password">비밀번호 : </label><input id="password" type="password" name="password">
            <button id="joinBtn">회원가입</button>
        </form>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#joinBtn').click(function(e){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });

            e.preventDefault();
            let name = $("input[name='name']").val();
            let email = $("input[name='email']").val();
            let password = $("input[name='password']").val();

            $.ajax({
                url: "/api/members/store",
                method: 'post',
                data: {
                    name: name,
                    email: email,
                    password: password
                },
                success: function(){
                    console.log("통신 성공");
                }, error() {
                    console.log("통신 실패");
                }
                });
            });
        });
    </script>

@endsection