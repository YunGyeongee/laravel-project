@extends('layout')
@section('content')
    <h1> 로 그 인 </h1>

    <div>
        <form>
            @csrf
            <label> EMAIL : </label> <input type="text" name="email"> <br>
            <label> PASSWORD : </label> <input type="text" name="password">
            <br><br>
            <button id="loginBtn">로그인</button>
        </form>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#loginBtn").click(function(){
                const email = $("input[name='email']").val();
                const pwd = $("input[name='password']").val();

                $.ajax({
                    url: '/api/user/login',
                    type: 'POST',
                    dataType : 'json',
                    data: {
                        _token : "{{ csrf_token() }}",
                        email: email,
                        password: pwd
                    },
                    success: function(data) {
                        const sendData = data.data.token.access_token;
                        localStorage.setItem('token', sendData);

                        window.location.replace('/boards');
                    }, error(){
                        alert("로그인 실패");
                    }
                });
            });
        });
    </script>


@endsection
