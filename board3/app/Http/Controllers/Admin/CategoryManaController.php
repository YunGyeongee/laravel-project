<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryManaController extends Controller
{
    /**
     * 관리자 - 게시판 관리
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $categories = Category::select('id', 'name', 'status', 'created_at')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.categories.main', compact('categories'));
    }

    /**
     * 관리자 - 카테고리 생성폼
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.categories.create');
    }
}
