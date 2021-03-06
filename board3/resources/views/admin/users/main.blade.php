@extends('layout')
@section('content')

    <h2> 회원 관리 목록 </h2>
    <button onclick="location.href='/admin'">이전으로</button>
    <br><br>

    <div class="user-table">
        <table border="1" style="width:1000px;">
            <tr align="center" style="height:40px;">
                <td>회원 번호</td>
                <td>회원 이름</td>
                <td>회원 가입일</td>
                <td>회원 상태</td>
                <td>회원정보 상세보기</td>
            </tr>
            @foreach($users as $user)
                <tr align="center">
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->created_at }}</td>
                    @if($user->status == 3)
                        <td>관리자</td>
                    @else
                        <td>회원</td>
                    @endif
                    <td><a href="/admin/users/view/{{ $user->id }}">회원 정보</a></td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
