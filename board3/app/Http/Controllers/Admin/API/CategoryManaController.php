<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Controller;
use App\Models\board;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CategoryManaController extends Controller
{
    /**
     * 관리자 - 카테고리 생성폼
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $data = [];
        $data['html'] = view('admin.categories.ajax.create', $data)->render();

        return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
    }

    /**
     * 관리자 - 카테고리 생성 후 저장
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $valid = validator($request->only('name'),[
            'name' => 'required|string|max:20',
        ]);

        if ($valid->fails()) {
            return response()->json([
                'error' => $valid->errors()->all()
            ], Response::HTTP_BAD_REQUEST );
        }
        $data = request()->only('name');

        $category = Category::create([
           'name' => $data['name'],
        ]);

        return response()->json(['success' => true, 'alert' => '', 'data' => $category], 200);
    }

    /**
     * 관리자 - 카테고리 수정폼
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Category $category)
    {
        $category_id = $category->id;
        $category = category::select('id', 'name', 'status')
            ->where('id', $category_id)
            ->first();

        if (!$category) {
            echo '존재하지 않는 카테고리';
        }

        $data = [];
        $data['category'] = $category;
        $data['html'] = view('admin.categories.ajax.edit', $data)->render();

        return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
    }

    /**
     * 관리자 - 카테고리 수정 후 저장
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function update(Request $request, Category $category)
    {
        $valid = validator($request->only('name'),[
            'name' => 'required|string|max:20',
        ]);

        if ($valid->fails()) {
            return response()->json([
                'error' => $valid->errors()->all()
            ], Response::HTTP_BAD_REQUEST );
        }

        $category_id = $category->id;
        $category = category::select('id', 'name', 'status')
            ->where('id', $category_id)
            ->first();

        $name = request('name');

        if (!$category) {
            echo '존재하지 않는 카테고리';
        } else {
            $category = DB::table('categories')
                ->where('id', $category_id)
                ->update(['name' => $name]);

            $data = [];
            $data['category'] = $category;

            return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
        }
    }

    /**
     * 관리자 - 카테고리 삭제
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function destroy(Category $category)
    {
        $category_id = $category->id;
        $category = category::select('status')
            ->where('id', $category_id)
            ->first();

        if (!$category) {
            return '존재하지 않는 게시글 입니다.';
        } else if ($category->status == 0) {
            return '이미 삭제된 게시글 입니다.';
        } else {
            $result = Category::where('id', $category_id)->update(['status' => 0]);

            if ($result == 0) {
                $data = [];
                $data['category'] = $category;

                return response()->json(['success' => true, 'alert' => '', 'data' => $data], 200);
            } else {
                return '오류가 발생하였습니다.';
            }
        }
    }
}
