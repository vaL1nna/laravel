<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    public function list(Request $request)
    {
        $keyword = $request->keyword;
        //获取数据
        $data = Banner::query();

        if (!empty($keyword)) {
            $data = $data->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . strtoupper($keyword) . '%');
            });
        }

        $total = $data->count();
        $data = $data->paginate(10);

        return view('Admin.banner.list', ['data' => $data, 'total' => $total]);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')){
            //接受参数
            $params = $request->only('name', 'url', 'is_show');
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                if ($image->isValid()) {
                    $ext = $image->getClientOriginalExtension();
                    $fileTypes = array('gif','png','jpg','jpeg');
                    if (!in_array($ext, $fileTypes)) {
                        return response()->json(['error' => '图片格式不正确']);
                    }
                    $path = $image->store('public');
                    $params['image'] = str_replace('public', '/storage', $path);
                }
            }else{
                return response()->json(['error' => '广告图片必须上传！']);
            }
            $params['setting_id'] = '1';
            $data = Banner::create($params);

            if ($data) {
                return response()->json(['success' => $data]);
            }
        }

        return view('Admin.banner.add');
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $info = Banner::find($id);

        if ($request->isMethod('post')) {
            //接受参数
            $id = $request->id;
            $params = $request->only('name', 'url', 'is_show');

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                if ($image->isValid()) {
                    $ext = $image->getClientOriginalExtension();
                    $fileTypes = array('gif','png','jpg','jpeg');
                    if (!in_array($ext, $fileTypes)) {
                        return response()->json(['error' => '图片格式不正确']);
                    }
                    $path = $image->store('public');
                    $params['image'] = str_replace('public', '/storage', $path);
                }
            }else{
                if (!empty($info['image'])) {
                    $params['image'] = $info['image'];
                }else{
                    return response()->json(['error' => '广告图片必须上传！']);
                }
            }

            $banner = Banner::find($id)->update($params);
            return response()->json(['success' => $banner]);
        }

        return view('Admin.banner.edit', ['info' => $info]);
    }

    public function del(Request $request)
    {
        $id = $request->id;
        $rs = Banner::find($id)->delete();

        if ($rs === false) {
            return response()->json(['success' => false]);
        }else{
            return response()->json(['success' => true]);
        }
    }

    /*public function batchUpdate(Request $request)
    {
        //接受参数
        $ids = $request->ids;
        $errors = [];

        if (is_array($ids)) {
            foreach ($ids as $id) {
                $order_id = 'order_id' . $id;
                $order_id = $request->input($order_id);
                $rs = Banner::find($id)->update(['order_id' => $order_id]);
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
    }*/

    public function batchDel(Request $request)
    {
        //接受参数
        $ids = $request->ids;
        $errors = [];

        if (is_array($ids)) {
            foreach ($ids as $id) {
                $rs = Banner::find($id)->delete();
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
