<?php

namespace App\Http\Controllers\Admin;

use App\Nav;
use App\News;
use Illuminate\Http\Request;

class NewsController extends CommonController
{
    public function list(Request $request)
    {
        if ($request->isMethod('post')) {
            //接受参数
            $menu_id = $request->menu_id;
            $keyword = $request->keyword;

            //获取数据
            $data = Nav::with('children');

            if (isset($parentId)) {
                $data = $data->where('id', $parentId);
            }

            if (isset($keyword)) {
                $data = $data->where(function ($query) use ($keyword) {
                    $query->where('nav_name', 'like', '%' . strtoupper($keyword) . '%');
                });
            }

            $data = $data->first()->toArray();
            $paginate = count($data['children']) + 1;

            return response()->json([
                'data' => $data,
                'paginate' => $paginate
            ]);
        }
        //获取所有数据
        $data = News::with('parent');
        $total = $data->count();
        $data = $data->paginate(10);

        //获取所有新闻分类信息
        $menu = Nav::where('type_id', '3')->orderBy('order_id')->get();
        return view('Admin.news.list', ['menu' => $menu, 'data' => $data, 'total' => $total]);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')){
            //接受参数
            $params = $request->only('menu_id', 'order_id', 'news_name', 'news_content', 'keyword', 'title', 'description', 'url');

            $data = News::create($params);
            $data->order_id = $data->id;
            $data->save();
        }
        //获取所有分类信息
        $menu = Nav::where('type_id', 4)->orderBy('order_id')->get();

        return view('Admin.news.add', ['menu' => $menu]);


    }

    public function edit(Request $request)
    {
        if ($request->isMethod('post')) {
            //接受参数
            $id = $request->id;
            $params = $request->only('menu_id', 'order_id', 'news_name', 'news_content', 'keyword', 'title', 'description', 'url');

            $data = News::find($id)->update($params);
        }
        $id = $request->id;
        $data = News::find('id', $id);

        //获取所有分类信息
        $menu = Nav::where('type_id', 4)->orderBy('order_id')->get();


        return view('Admin.news.add', ['menu' => $menu, 'data' => $data]);

    }
}
