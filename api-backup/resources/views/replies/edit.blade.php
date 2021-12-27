@extends('layout')
@section('content')
    <form action="/replies/{{ $reply->id }}" method="POST">
        @csrf
        <input type="hidden" name="reply_id" value="{{ $reply->id }}">
        <label> * 댓글 내용</label><br><br>
        <textarea cols="50" rows="2" id="content" name="content">{{$reply->content}}</textarea>
        <input type="submit" value="수정">
    </form>
@endsection