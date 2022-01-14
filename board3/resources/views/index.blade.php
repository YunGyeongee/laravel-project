@extends('layout')
@section('content')
    <h1> INDEX </h1>

    <div>
        <button onclick="location.href='/users'">로그인</button>
        <button onclick="location.href='/users/register'">회원가입</button>
    </div>

@endsection
