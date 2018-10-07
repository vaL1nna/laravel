<?php

namespace App\Http\Controllers\Admin;

use App\Nav;
use App\NavType;
use Illuminate\Http\Request;

class NavController extends CommonController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $parentId = $request->parentId;
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

            //导航类型
            $type = NavType::all();

            //显示视图
            return view('Admin.nav.add', ['menu' => $menu, 'type' => $type]);
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

            //导航类型
            $type = NavType::all();

            return view('Admin.nav.edit', ['info' => $info, 'menu' => $menu, 'type' => $type]);
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
