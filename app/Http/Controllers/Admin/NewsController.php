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

            if ($request->hasFile('news_image')) {
                $image = $request->file('news_image');
                if ($image->isValid()) {
                    $ext = $image->getClientOriginalExtension();
                    $fileTypes = array('gif','png','jpg','jpeg');
                    if (!in_array($ext, $fileTypes)) {
                        return response()->json(['error' => '图片格式不正确']);
                    }
                    $path = $image->store('public');
                    $params['news_image'] = str_replace('public', '/storage', $path);
                }
            }

            $params['order_id'] = '99999';
            $data = News::create($params);
            if ($data) {
                return response()->json(['success' => $data]);
            }
        }
        //获取所有分类信息
        $menu = Nav::where('type_id', '4')->where('parent_id', '!=', '0')->orderBy('order_id')->get();

        return view('Admin.news.add', ['menu' => $menu]);


    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $info = News::find($id);

        if ($request->isMethod('post')) {
            //接受参数
            $id = $request->id;
            $params = $request->only('menu_id', 'order_id', 'news_name', 'news_content', 'keyword', 'title', 'description', 'url');

            if ($request->hasFile('news_image')) {
                $image = $request->file('news_image');
                if ($image->isValid()) {
                    $ext = $image->getClientOriginalExtension();
                    $fileTypes = array('gif','png','jpg','jpeg');
                    if (!in_array($ext, $fileTypes)) {
                        return response()->json(['error' => '图片格式不正确']);
                    }
                    $path = $image->store('public');
                    $params['news_image'] = str_replace('public', '/storage', $path);
                }
            }else{
                $params['news_image'] = $info['news_image'];
            }

            $news = News::find($id)->update($params);
            return response()->json(['success' => $news]);
        }

        //获取所有分类信息
        $menu = Nav::where('type_id', '4')->where('parent_id', '!=', '0')->orderBy('order_id')->get();

        return view('Admin.news.edit', ['menu' => $menu, 'info' => $info]);
    }

    public function del(Request $request)
    {
        $id = $request->id;
        $rs = News::find($id)->delete();

        if ($rs === false) {
            return response()->json(['success' => false]);
        }else{
            return response()->json(['success' => true]);
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
            return response()->json(['success' => false]);
        }else{
            return response()->json(['success' => true]);
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
            return response()->json(['success' => false]);
        }else{
            return response()->json(['success' => true]);
        }
    }
}
