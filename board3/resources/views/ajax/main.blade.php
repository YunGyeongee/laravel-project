<table border="1" style="width:1000px;">
    <tr align="center" style="height:40px;">
        <td style="width:15%">글번호</td>
        <td>글제목</td>
        <td style="width:25%">작성일</td>
    </tr>
    @foreach($boards as $board)
    <tr align="center">
        <td>{{ $board->id }}</td>
        <td><a href="/boards/view/{{ $board->id }}">{{ $board->title }}</a></td>
        <td>{{ $board->created_at }}</td>
    </tr>
    @endforeach
</table>
