@extends('layout')
@section('content')
    <form action="/boards/store" method="POST">
        @csrf
        <label> * 글제목</label> 
        <p><input type="text" name="title" id="title"></p>
        <label> * 글내용</label>
        <p><textarea name="content" id="content" cols="50" rows="30"></textarea></p>
        <input type="submit" value="저장">
        <input type="reset" value="취소">
    </form>
@endsection