<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApplicationController extends Controller
{
    public function list(Request $request)
    {
        //接受参数
        $keyword = $request->keyword;

        //获取数据
        $data = Nav::where('parent_id' != '0')->where('type_id', '3');

        if (isset($keyword)) {
            $data = $data->where(function ($query) use ($keyword){
                $query->where('nav_name', 'like', '%' . strtoupper($keyword) . '%');
            });
        }

        $total = $data->count();
        $data = $data->orderBy('order_id')->paginate(10);

        return view('Admin.application.list', ['data' => $data, 'total' => $total, 'keyword' => $keyword]);

    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')){
            //接受参数
            $params = $request->only('menu_id', 'order_id', 'nav_name', 'nav_content', 'keyword', 'title', 'description', 'url', 'is_show', 'nav_attribute1', 'nav_attribute2', 'nav_attribute3', 'nav_attribute4', 'nav_attribute5', 'nav_attribute6', 'nav_attribute7', 'nav_attribute8', 'nav_attribute9', 'nav_attribute10');

            $data = Nav::create($params);
            $data->order_id = $data->id;
            $result = $data->save();
            if ($result) {
                return response()->json($result);
            }
        }
        //获取所有分类信息
        $menu = Nav::where('type_id', '2')->where('parent_id', '!=', '0')->orderBy('order_id')->get();

        return view('Admin.nav.add', ['menu' => $menu]);


    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $info = Nav::find($id);

        if ($request->isMethod('post')) {
            //接受参数
            $id = $request->id;
            $params = $request->only('menu_id', 'order_id', 'nav_name', 'nav_content', 'keyword', 'title', 'description', 'url', 'nav_image', 'nav_file', 'is_show', 'nav_attribute1', 'nav_attribute2', 'nav_attribute3', 'nav_attribute4', 'nav_attribute5', 'nav_attribute6', 'nav_attribute7', 'nav_attribute8', 'nav_attribute9', 'nav_attribute10');

            if ($request->hasFile('nav_image')) {
                $image = $request->file('nav_image');
                if ($image->isValid()) {
                    $ext = $image->getClientOriginalExtension();
                    $fileTypes = array('gif','png','jpg','jpeg');
                    if (!in_array($ext, $fileTypes)) {
                        return response()->json(['error' => '图片格式不正确']);
                    }
                    $path = $image->store('public');
                    $params['nav_image'] = str_replace('public', '/storage', $path);
                }
            }else{
                $params['nav_image'] = $info['nav_image'];
            }

            if ($request->hasFile('nav_file')) {
                $file = $request->file('nav_file');
                if ($file->isValid()) {
                    /*$fileName = $file->getClientOriginalName();
                    $fileName = explode('.', $fileName)[0] . '_' . date('ymd');*/
                    $ext = $file->getClientOriginalExtension();
                    if ($ext != 'pdf') {
                        return response()->json(['error' => '上传的pdf格式不正确']);
                    }
                    $path = $file->store('public');
                    $params['nav_file'] = str_replace('public', '/storage', $path);
                }
            }else{
                $params['nav_file'] = $info['nav_file'];
            }

            $nav = Nav::find($id)->update($params);
            return response()->json($nav);
        }

        //获取所有分类信息
        $menu = Nav::where('type_id', '2')->where('parent_id', '!=', '0')->orderBy('order_id')->get();


        return view('Admin.nav.edit', ['menu' => $menu, 'info' => $info]);
    }

    public function del(Request $request)
    {
        $id = $request->id;
        $rs = Nav::find($id)->delete();

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
                $rs = Nav::find($id)->update(['order_id' => $order_id]);
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
                $rs = Nav::find($id)->delete();
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
