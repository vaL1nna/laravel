<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use App\Nav;
use Illuminate\Http\Request;

class ProductController extends CommonController
{
    public function list(Request $request)
    {
        //接受参数
        $menu_id = $request->menu_id;
        $keyword = $request->keyword;

        //获取数据
        $data = Product::with(['parent']);

        if (!empty($menu_id)) {
            $data = $data->where('menu_id', $menu_id);
        }

        if (isset($keyword)) {
            $data = $data->where(function ($query) use ($keyword){
                $query->where('product_name', 'like', '%' . strtoupper($keyword) . '%');
            });
        }

        $total = $data->count();
        $data = $data->orderBy('order_id')->paginate(10);

        //获取所有产品分类信息
        $menu = Nav::where('type_id', '2')->where('parent_id', '!=', '0')->orderBy('order_id')->get();

        return view('Admin.product.list', ['menu' => $menu, 'data' => $data, 'total' => $total, 'menu_id' => $menu_id, 'keyword' => $keyword]);

    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')){
            //接受参数
            $params = $request->only('menu_id', 'order_id', 'product_name', 'product_content', 'keyword', 'title', 'description', 'url', 'is_show', 'product_attribute1', 'product_attribute2', 'product_attribute3', 'product_attribute4', 'product_attribute5', 'product_attribute6', 'product_attribute7', 'product_attribute8', 'product_attribute9', 'product_attribute10');
            if ($request->hasFile('product_image')) {
                $image = $request->file('product_image');
                if ($image->isValid()) {
                    $ext = $image->getClientOriginalExtension();
                    $fileTypes = array('gif','png','jpg','jpeg');
                    if (!in_array($ext, $fileTypes)) {
                        return response()->json(['error' => '图片格式不正确']);
                    }
                    $path = $image->store('public');
                    $params['product_image'] = str_replace('public', '/storage', $path);
                }
            }

            if ($request->hasFile('product_file')) {
                $file = $request->file('product_file');
                if ($file->isValid()) {
                    /*$fileName = $file->getClientOriginalName();
                    $fileName = explode('.', $fileName)[0] . '_' . date('ymd');*/
                    $ext = $file->getClientOriginalExtension();
                    if ($ext != 'pdf') {
                        return response()->json(['error' => '上传的pdf格式不正确']);
                    }
                    $path = $file->store('public');
                    $params['product_file'] = str_replace('public', '/storage', $path);
                }
            }

            $data = Product::create($params);
            $data->order_id = $data->id;
            $data->save();
        }
        //获取所有分类信息
        $menu = Nav::where('type_id', '2')->where('parent_id', '!=', '0')->orderBy('order_id')->get();

        return view('Admin.product.add', ['menu' => $menu]);


    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $info = Product::find($id);

        if ($request->isMethod('post')) {
            //接受参数
            $id = $request->id;
            $params = $request->only('menu_id', 'order_id', 'product_name', 'product_content', 'keyword', 'title', 'description', 'url', 'product_image', 'product_file', 'is_show', 'product_attribute1', 'product_attribute2', 'product_attribute3', 'product_attribute4', 'product_attribute5', 'product_attribute6', 'product_attribute7', 'product_attribute8', 'product_attribute9', 'product_attribute10');

            if ($request->hasFile('product_image')) {
                $image = $request->file('product_image');
                if ($image->isValid()) {
                    $ext = $image->getClientOriginalExtension();
                    $fileTypes = array('gif','png','jpg','jpeg');
                    if (!in_array($ext, $fileTypes)) {
                        return response()->json(['error' => '图片格式不正确']);
                    }
                    $path = $image->store('public');
                    $params['product_image'] = str_replace('public', '/storage', $path);
                }
            }else{
                $params['product_image'] = $info['product_image'];
            }

            if ($request->hasFile('product_file')) {
                $file = $request->file('product_file');
                if ($file->isValid()) {
                    /*$fileName = $file->getClientOriginalName();
                    $fileName = explode('.', $fileName)[0] . '_' . date('ymd');*/
                    $ext = $file->getClientOriginalExtension();
                    if ($ext != 'pdf') {
                        return response()->json(['error' => '上传的pdf格式不正确']);
                    }
                    $path = $file->store('public');
                    $params['product_file'] = str_replace('public', '/storage', $path);
                }
            }else{
                $params['product_file'] = $info['product_file'];
            }

            $product = Product::find($id)->update($params);
            return response()->json($product);
        }

        //获取所有分类信息
        $menu = Nav::where('type_id', '2')->where('parent_id', '!=', '0')->orderBy('order_id')->get();


        return view('Admin.product.edit', ['menu' => $menu, 'info' => $info]);
    }

    public function del(Request $request)
    {
        $id = $request->id;
        $rs = Product::find($id)->delete();

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
                $rs = Product::find($id)->update(['order_id' => $order_id]);
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
                $rs = Product::find($id)->delete();
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
