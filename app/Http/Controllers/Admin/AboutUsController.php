<?php

namespace App\Http\Controllers\Admin;

use App\Nav;
use Illuminate\Http\Request;


class AboutUsController extends CommonController
{
    public function list(Request $request)
    {
        //接受参数
        $keyword = $request->keyword;

        //获取数据
        $data = Nav::where('parent_id', '!=',  '0')->where('type_id', '6');

        if (isset($keyword)) {
            $data = $data->where(function ($query) use ($keyword){
                $query->where('nav_name', 'like', '%' . strtoupper($keyword) . '%');
            });
        }

        $total = $data->count();
        $data = $data->orderBy('order_id')->paginate(10);

        return view('Admin.aboutUs.list', ['data' => $data, 'total' => $total, 'keyword' => $keyword]);

    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')){
            //接受参数
            $params = $request->only('nav_name', 'position', 'keyword', 'title', 'description', 'url', 'nav_content');

            //获取父类id
            $parent = Nav::where('parent_id', '0')->where('type_id', '6')->first();
            if (empty($parent)) {
                return response()->json(['error' => '请先添加相应导航']);
            }
            $params['parent_id'] = $parent->id;
            $params['type_id'] = $parent->type_id;
            $data = Nav::create($params);
            $data->order_id = $data->id;
            $result = $data->save();
            if ($result) {
                return response()->json(['success' => $result]);
            }
        }

        return view('Admin.aboutUs.add');
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $info = Nav::find($id);

        if ($request->isMethod('post')) {
            //接受参数
            $id = $request->id;
            $params = $request->only('nav_name', 'position', 'keyword', 'title', 'description', 'url', 'nav_content');

            $nav = Nav::find($id)->update($params);
            return response()->json(['success' => $nav]);
        }

        return view('Admin.aboutUs.edit', ['info' => $info]);
    }

    public function del(Request $request)
    {
        $id = $request->id;
        $rs = Nav::find($id)->delete();

        if ($rs === false) {
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
                $rs = Nav::find($id)->delete();
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
