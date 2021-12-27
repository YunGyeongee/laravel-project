@extends('layout')
@section('content')
    <h1> 로그인 </h1>

    <div>
        <form action="/auth/login" method="POST">
            @csrf
            <label> EMAIL : </label> <input type="text" name="email"> <br>
            <label> PASSWORD : </label> <input type="text" name="password">
            <br><br>
            <input type="submit" value="로그인">
        </form>
    </div>

@endsection