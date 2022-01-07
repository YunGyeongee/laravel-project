@extends('layout')
@section('content')
    <br>
    <h2 style="padding-left:350px;"> 게시글 작성 </h2>
    <br><br>

    <div class="create-table" style="width:800px;">
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            const token = localStorage.getItem('token');

            $.ajax({
                url: '/'
            });
        });
    </script>


@endsection
