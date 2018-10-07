<?php

namespace App\Http\Controllers\Admin;

use App\Nav;
use App\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends CommonController
{
    public function list(Request $request)
    {

        $data = News::with('parent');
        $total = $data->count();
        $data = $data->paginate(10);

        //获取所有新闻分类信息
        $menu = Nav::where('type_id', '3')->orderBy('order_id')->get();
        return view('Admin.news.list', ['menu' => $menu, 'data' => $data, 'total' => $total]);
    }
}
