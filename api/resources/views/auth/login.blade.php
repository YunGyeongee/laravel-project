@extends('layout')
@section('content')
    <h1> 로그인 </h1>

    <div>
        <form>
            @csrf
            <label> EMAIL : </label> <input type="text" name="email"> <br>
            <label> PASSWORD : </label> <input type="text" name="password">
            <br><br>
            <button type="submit" id="loginBtn">로그인</button>
        </form>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#loginBtn").click(function(e){

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                e.preventDefault();
                let email = $("input[name='email']").val();
                let pwd = $("input[name='password']").val();

                $.ajax({
                    url: "{{url('api/members/login')}}",
                    type: 'POST',
                    data: {
                        email: email,
                        password: pwd
                    },
                    success: function(data) {
                        // alert('통신 성공');
                        console.log(data);
                    }, error(){
                        alert('통신 오류');
                    }
                });
            });
        });
    </script>


@endsection