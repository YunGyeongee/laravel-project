@extends('layout')
@section('content')
    <div>
        <h2> 회 원 가 입 </h2>
        <form method="POST" action="/register">
            @csrf
            <p><label for="name">이름 : </label><input id="name" type="text" name="name"></p>
            <p><label for="eamil">이메일 : </label><input id="email" type="email" name="email"></p>
            <p><label for="password">비밀번호 : </label><input id="password" type="password" name="password"></p>
            <input type="submit" value="회원가입">
        </form>
    </div>
@endsection