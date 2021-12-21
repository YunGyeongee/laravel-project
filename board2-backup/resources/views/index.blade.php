@extends('layout')
@section('content')
    <h1> 로그인 </h1>

    <div>
        <form action="/login" method="POST">
            @csrf
            <label> ID : </label> <input type="text" name="id"> <br>
            <label> PASSWORD : </label> <input type="text" name="password">
            <br><br>
            <input type="submit" value="로그인">
            <input type="button" value="회원가입" onclick="">
        </form>
    </div>

@endsection