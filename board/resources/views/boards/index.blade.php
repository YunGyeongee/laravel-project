@extends('layout')
@section('content')
    <h2>Board Index</h2>
    @foreach ($boards as $item)
        <li> TITLE : {{ $item->title }}</li>
    @endforeach
@endsection