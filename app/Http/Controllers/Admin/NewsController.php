<?php

namespace App\Http\Controllers\Admin;

use App\Nav;
use App\News;
use Illuminate\Http\Request;

class NewsController extends CommonController
{
    public function list(Request $request)
    {
        //接受参数
        $menu_id = $request->menu_id;
        $keyword = $request->keyword;

        //获取数据
        $data = News::with(['parent']);

        if (!empty($menu_id)) {
            $data = $data->where('menu_id', $menu_id);
        }

        if (isset($keyword)) {
            $data = $data->where(function ($query) use ($keyword){
                $query->where('news_name', 'like', '%' . strtoupper($keyword) . '%');
            });
        }

        $total = $data->count();
        $data = $data->orderBy('order_id')->paginate(10);

        //获取所有新闻分类信息
        $menu = Nav::where('type_id', '4')->where('parent_id', '!=', '0')->orderBy('order_id')->get();

        return view('Admin.news.list', ['menu' => $menu, 'data' => $data, 'total' => $total, 'menu_id' => $menu_id, 'keyword' => $keyword]);

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
        $menu = Nav::where('type_id', '4')->where('parent_id', '!=', '0')->orderBy('order_id')->get();

        return view('Admin.news.add', ['menu' => $menu]);


    }

    public function edit(Request $request)
    {
        if ($request->isMethod('post')) {
            //接受参数
            $id = $request->id;
            $params = $request->only('menu_id', 'order_id', 'news_name', 'news_content', 'keyword', 'title', 'description', 'url');

            $news = News::find($id)->update($params);
            return response()->json($news);
        }
        $id = $request->id;
        $info = News::find($id);

        //获取所有分类信息
        $menu = Nav::where('type_id', '4')->where('parent_id', '!=', '0')->orderBy('order_id')->get();

        return view('Admin.news.edit', ['menu' => $menu, 'info' => $info]);
    }

    public function del(Request $request)
    {
        $id = $request->id;
        $rs = News::find($id)->delete();

        if ($rs === false) {
            return ['success' => false];
        }else{
            return ['success' => true];
        }

    }

    public function batchUpdate(Request $request)
    {
        //接受参数
        $ids = $request->ids;
        $errors = [];

        if (is_array($ids)) {
            foreach ($ids as $id) {
                $order_id = 'order_id' . $id;
                $order_id = $request->input($order_id);
                $rs = News::find($id)->update(['order_id' => $order_id]);
                if ($rs === false) {
                    $errors[] = $id;
                }
            }
        }

        if (!empty($errors)) {
            return ['success' => false];
        }else{
            return ['success' => true];
        }
    }

    public function batchDel(Request $request)
    {
        //接受参数
        $ids = $request->ids;
        $errors = [];

        if (is_array($ids)) {
            foreach ($ids as $id) {
                $rs = News::find($id)->delete();
                if ($rs === false) {
                    $errors[] = $id;
                }
            }
        }

        if (!empty($errors)) {
            return ['success' => false];
        }else{
            return ['success' => true];
        }
    }
}
