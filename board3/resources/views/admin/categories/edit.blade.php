@extends('layout')
@section('content')
    <br>
    <h2 style="padding-left:350px;"> 카테고리 수정 </h2>
    <br><br>

    <div class="edit-table" style="width:800px;">
        <input type="hidden" name="category_id" value="{{ $category->id }}">
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            const token = localStorage.getItem('token');
            const id = $("input[name=category_id]").val();

            $.ajax({
                url: '/api/user/admin/categories/view/' + id + '/edit',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Accept", "application/json");
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                },
                success: function (data) {
                    $(".edit-table").html(data.data.html);
                }, error: function (status) {
                    alert('categories.edit 통신 실패');
                }
            });
        });
    </script>
@endsection
