@extends('layout')
@section('content')
    
    <h2 style="padding-left:270px;"> 마이페이지 </h2>

    <a href="{{route('main')}}" style="padding-left:530px;"><button>메인으로</button></a>
    <br><br>

    
    <div class="board-table">
        <table border="1" style="width:600px;">
            <tr align="center">
                <td style="width:20%; height:40px;">회원번호</td>
                <td><input type="text" name="id" value="{{Auth::user()->id}}" readonly></td>
            </tr>
            <tr align="center">
                <td style="height:40px;">이름</td>
                <td><input type="text" name="name" value="{{Auth::user()->name}}" readonly></td>
            </tr>
            <tr align="center">
                <td style="height:40px;">이메일</td>
                <td><input type="text" name="email" value="{{Auth::user()->email}}" readonly></td>
            </tr>
            <tr align="center">
                <td style="height:40px;">비밀번호</td>
                <td><input type="password" name="password" value="{{Auth::user()->password}}" readonly></td>
            </tr>
            <tr align="center">
                <form method="POST" action="/users/update">
                    @csrf
                    <td style="height:40px;">닉네임</td>
                    <td>
                        <input type="text" name="nickname" value="{{Auth::user()->nickname}}">
                        <input type="submit" value="변경">
                    </td>
                </form>
            </tr>
        </table>
    </div>
    


@endsection