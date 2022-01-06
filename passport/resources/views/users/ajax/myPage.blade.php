
        <table border="1" style="width:600px;">
            <tr align="center">
                <td style="width:20%; height:40px;">회원번호</td>
                <td><input type="text" name="id" value="{{$user->id}}" readonly></td>
            </tr>
            <tr align="center">
                <td style="height:40px;">이름</td>
                <td><input type="text" name="name" value="{{$user->name}}" readonly></td>
            </tr>
            <tr align="center">
                <td style="height:40px;">이메일</td>
                <td><input type="text" name="email" value="{{$user->email}}" readonly></td>
            </tr>
            <tr align="center">
                <td style="height:40px;">비밀번호</td>
                <td><input type="password" name="password" value="{{$user->password}}" readonly></td>
            </tr>
            <tr align="center">
                <form method="POST" action="/users/update">
                    @csrf
                    <td style="height:40px;">닉네임</td>
                    <td>
                        <input type="text" name="nickname" value="{{$user->nickname}}">
                        <input type="submit" value="변경">
                    </td>
                </form>
            </tr>
        </table>

