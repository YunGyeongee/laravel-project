@extends('layout')
@section('content')
    <form action="/boards/{{ $board->id }}" method="POST">
        @csrf
        @method('PUT')
        <label> * 글제목</label> 
        <p><input type="text" name="title" id="title" value="{{$board->title}}"></p>
        <label> * 글내용</label>
        <p><textarea name="content" id="content" cols="50" rows="30">{{$board->content}}</textarea></p>
        <input type="submit" value="수정">
        <input type="reset" value="취소">
    </form>
@endsection