@extends('layout')
@section('content')
    <h2>Board Index</h2>
    
    @foreach ($boards as $item)
        <li><a href="/boards/{{$item->id}}">{{ $item->title }} </a></li>
    @endforeach
    <a href="/boards/create"><button>μ κΈ μμ±</button></a>
@endsection