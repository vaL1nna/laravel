<?php

namespace App\Http\Controllers\Admin;

use App\Nav;
use App\NavType;
use App\News;
use App\Product;
use Illuminate\Http\Request;

class NavController extends CommonController
{
    public function list(Request $request)
    {
        //接受参数
        $parent_id = $request->parent_id;
        $keyword = $request->keyword;

        //获取数据
        $data = Nav::with(['parent']);

        if (!empty($parent_id)) {
            $data = $data->where('parent_id', $parent_id);
        }

        if (isset($keyword)) {
            $data = $data->where(function ($query) use ($keyword){
                $query->where('nav_name', 'like', '%' . strtoupper($keyword) . '%');
            });
        }

        $total = $data->count();
        $data = $data->paginate(10);

        //获取所有导航分类信息
        $menu = Nav::where('parent_id', '0')->get();

        return view('Admin.nav.list', ['menu' => $menu, 'data' => $data, 'total' => $total, 'parent_id' => $parent_id, 'keyword' => $keyword]);

    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')){
            //接受参数
            $params = $request->only('nav_name', 'position', 'parent_id', 'type_id', 'keyword', 'title', 'description', 'url', 'nav_content');

            $data = Nav::create($params);
            if ($data) {
                return response()->json(['success' => $data]);
            }
        }
        //获取所有分类信息
        $menu = Nav::where('parent_id', '0')->get();

        //获取所有导航类型
        $navType = NavType::all();
        return view('Admin.nav.add', ['menu' => $menu, 'navType' => $navType]);
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $info = Nav::find($id);

        if ($request->isMethod('post')) {
            //接受参数
            $id = $request->id;
            $params = $request->only('nav_name', 'position', 'parent_id', 'type_id', 'keyword', 'title', 'description', 'url', 'nav_content');

            $nav = Nav::find($id)->update($params);
            return response()->json(['success' => $nav]);
        }
        //获取所有分类信息
        $menu = Nav::where('parent_id', '0')->get();

        //获取所有导航类型
        $navType = NavType::all();

        return view('Admin.nav.edit', ['menu' => $menu, 'info' => $info, 'navType' => $navType]);
    }

    public function del(Request $request)
    {
        $id = $request->id;
        $info = Nav::find($id);
        $type_id = $info->type_id;
        $parent_id = $info->parent_id;
        if ($parent_id == 0){
            //一级导航
            $children = Nav::where('parent_id', $id);

            if (!empty($children)) {
                return response()->json(['error' => '一级导航下存在子分类，请先删除其子分类及其子分类下的数据！']);
            }
        }else{
            //二级导航
            switch ($type_id) {
                //产品
                case '2':
                    $product = Product::where('menu_id', $id);
                    if (!empty($product)) {
                        return response()->json(['error' => '二级产品分类下存在产品信息，请先删除其下产品数据！']);
                    }
                    break;

                //新闻
                case '4':
                    $product = News::where('menu_id', $id);
                    if (!empty($product)) {
                        return response()->json(['error' => '二级新闻分类下存在新闻信息，请先删除其下新闻数据！']);
                    }
                    break;

                default:
                    # code...
                    break;
            }
        }

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
                $info = Nav::find($id);
                $type_id = $info->type_id;
                $parent_id = $info->parent_id;
                if ($parent_id == 0){
                    //一级导航
                    $children = Nav::where('parent_id', $id);
                    if (!empty($children)) {
                        return response()->json(['error' => '一级导航下存在自分类，请先删除其子分类及其子分类下的数据！']);
                    }
                }else{
                    //二级导航
                    switch ($type_id) {
                        //产品
                        case '2':
                            $product = Product::where('menu_id', $id);
                            if (!empty($product)) {
                                return response()->json(['error' => '二级产品分类下存在产品信息，请先删除其下产品数据！']);
                            }
                            break;

                        //新闻
                        case '4':
                            $product = News::where('menu_id', $id);
                            if (!empty($product)) {
                                return response()->json(['error' => '二级新闻分类下存在新闻信息，请先删除其下新闻数据！']);
                            }
                            break;

                        default:
                            # code...
                            break;
                    }
                }
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
