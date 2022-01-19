@extends('layout')
@section('content')
    <h1> 로 그 인 </h1>

    <div>
        <form onsubmit="return false;">
            @csrf
            <label> EMAIL : </label> <input type="text" name="email"> <br>
            <label> PASSWORD : </label> <input type="text" name="password">
            <br><br>
            <button id="loginBtn">로그인</button>
        </form>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $("#loginBtn").click(function(){
            const token = localStorage.getItem('token');
            const email = $("input[name='email']").val();
            const pwd = $("input[name='password']").val();

            $.ajax({
                url: '/api/user/login',
                type: 'POST',
                dataType : 'json',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                },
                data: {
                    _token : "{{ csrf_token() }}",
                    email: email,
                    password: pwd
                },
                success: function(data) {
                    if (data.success) {
                        const sendData = data.data.token.access_token;
                        localStorage.setItem('token', sendData);

                        window.location.replace('/boards');
                    } else {
                        alert(data.alert);
                        window.location.reload();
                    }
                }, error(){
                    alert("로그인 실패");
                    return false;
                }
            });
        });
    </script>
@endsection
