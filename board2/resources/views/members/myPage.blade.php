@extends('layout')
@section('content')
    
    <h2 style="padding-left:270px;"> 마이페이지 </h2>

    <a href="/main" style="padding-left:530px;"><button>메인으로</button></a>
    <br><br>

    
    <div class="board-table">
        <table border="1" style="width:600px;">
            <tr align="center">
                <td style="width:20%; height:40px;">회원번호</td>
                <td>{{ $member->id }}</td>
            </tr>
            <tr align="center">
                <td style="height:40px;">이름</td>
                <td>{{ $member->name }}</td>
            </tr>
            <tr align="center">
                <td style="height:40px;">비밀번호</td>
                <td>{{ $member->password }}</td>
            </tr>
            <tr align="center">
                <form method="POST" action="/members/{{$member->id}}">
                    @csrf
                    <td style="height:40px;">닉네임</td>
                    <td>
                        <input type="text" name="nickname" value="{{ $member->nickname }}">
                        <input type="submit" value="변경">
                    </td>
                </form>
            </tr>
        </table>
    </div>
    


@endsection