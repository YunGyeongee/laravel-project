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
}
