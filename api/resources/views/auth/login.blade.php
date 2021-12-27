@extends('layout')
@section('content')
    <h1> 로그인 </h1>

    <div>
        <label> EMAIL : </label> <input type="text" name="email"> <br>
        <label> PASSWORD : </label> <input type="text" name="password">
        <br><br>
        <button onclick="login();">로그인</button>
    </div>

    <script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    
        $.ajax({
            type = "post",
            url = "api/members/login",
            contentType : "application/json",
            data : json,
            success : function() {
                alert('통신 성공');
            }, error : function() {
                alert('통신 실패');
            }
        });
    </script>

@endsection