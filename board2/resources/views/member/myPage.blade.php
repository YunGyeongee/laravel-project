@extends('layout')
@section('content')
    
    <h2 style="padding-left:370px;"> 마이페이지 </h2>

    <a href="main" style="padding-left:730px;"><button>메인으로</button></a>
    <br><br>

    <div class="board-table">
        <table border="1" style="width:800px;">
            <tr align="center">
                <td style="width:20%; height:40px;">아이디</td>
                <td>1</td>
            </tr>
            <tr align="center">
                <td style="height:40px;">이름</td>
                <td>2</td>
            </tr>
            <tr align="center">
                <td style="height:40px;">비밀번호</td>
                <td>3</td>
            </tr>
            <tr align="center">
                <td style="height:40px;">닉네임</td>
                <td><input type="submit" name="nickname" value="변경"></td>
            </tr>
        </table>
    </div>


@endsection