<?php

namespace App\Http\Controllers\Admin;

use App\Nav;
use Illuminate\Http\Request;

class NavController extends CommonController
{
    public function index(Request $request)
    {
        //获取所有数据
        $data = Nav::with('parent');

        $total = $data->count();
        $data = $data->paginate(10);

        //获取所有分类
        $menu = Nav::where('parent_id', '0')->get()->toArray();
        $menu = $this->getTree($menu, 0, 1);

        //分配数据到模版
        return view('Admin.nav.list', ['data' => $data, 'total' => $total, 'menu' => $menu]);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('get')) {
            //获取所有分类
            $menu = Nav::where('parent_id', '0')->get()->toArray();
            $menu = $this->getTree($menu, 0, 1);

            //显示视图
            return view('Admin.nav.add', ['menu' => $menu]);
        }elseif ($request->isMethod('post')) {
            $params = $request->all();

            $nav = Nav::create($params);
            $id = $nav->id;
            Nav::where('id', $id)->update(
                ['order_id' => $id]
            );

            if ($nav) {
                return ['success' => true];
            }else{
                return ['success' => false];
            }
        }
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $info = Nav::where('id', $id)->first();
        if ($request->isMethod('get')) {
            //获取所有分类
            $menu = Nav::where('parent_id', '0')->get()->toArray();
            $menu = $this->getTree($menu, 0, 1);

            return view('Admin.nav.edit', ['info' => $info, 'menu' => $menu]);
        }elseif ($request->isMethod('post')) {
            $id = $request->id;
            $params = $request->only('nav_name', 'position', 'url', 'keyword', 'title', 'description', 'parent_id', 'nav_content');

            $nav = Nav::where('id', $id)->update($params);

            if ($nav) {
                return ['success' => true];
            }else{
                return ['success' => false];
            }
        }
    }

    public function del(Request $request)
    {
        $id = $request->input('id');
        $rs = Nav::find($id)->delete();

        if ($rs === false) {
            return ['success' => false];
        }else{
            return ['success' => true];
        }
    }

    public function batchDel(Request $request)
    {
        $ids = $request->ids;
        $errors = [];

        foreach ($ids as $id) {
            $rs = Nav::find($id)->delete();
            if ($rs === false) {
                $errors[] = $id;
            }
        }

        if (!empty($errors)) {
            return ['success' => false];
        }else{
            return ['success' => true];
        }
    }
}
