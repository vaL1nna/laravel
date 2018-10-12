<?php

namespace App\Http\Controllers\Admin;
use App\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ManagerController extends CommonController
{
    //登陆
    public function login(Request $request)
    {
        if ($request->isMethod('get')) {
            return view("Admin.login");
        }elseif ($request->isMethod('post')) {
            //数据处理
            //1.数据验证（用户名长度，是否为空）
            //第一种数据验证：（使用validate方法）
            /*$this->validate($request, [
                "username" => "required|string|min:1|max:5",
                "password" => "required|between:4,20",
                "captcha" => "required|size:5"
            ]);*/

            //第二种：使用validator门面
            $validator = Validator::make($request->all(), [
                "username" => "required|string|min:1|max:5",
                "password" => "required|between:4,20",
                "captcha" => "required|size:2"
            ]);
            if ($validator->fails()) {
                return redirect("/admin/login")->withErrors($validator)->withInput();
            }

            $username = $request->input('username');
            $password = $request->input('password');

            if (Auth::guard('admin')->attempt(['username' => $username, 'password' => $password])) {
                return redirect('/admin/index');
            }else{
                return redirect('/admin/login')->withErrors(['loginError' => '用户名或密码错误'])->withInput();
            }
        }
    }

    //登出
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }

    //管理员列表
    public function list(Request $request)
    {
        $keyword = $request->keyword;

        //获取数据
        $data = Manager::query();

        if (isset($keyword)) {
            $data = $data->where(function ($query) use ($keyword){
                $query->where('manager_name', 'like', '%' . strtoupper($keyword) . '%');
            });
        }

        $total = $data->count();
        $data = $data->paginate(10);

        return view('Admin.manager.list', ['data' => $data, 'total' => $total, 'keyword' => $keyword]);

    }

    //管理员添加
    public function add(Request $request)
    {
        if ($request->isMethod('post')){
            //接受参数
            $params = $request->only('username', 'password', 'mg_role_ids', 'mg_sex', 'mg_phone', 'mg_email', 'mg_remark');
            if ($request->hasFile('file')) {
                $image = $request->file('file');
                if ($image->isValid()) {
                    $ext = $image->getClientOriginalExtension();
                    $fileTypes = array('gif','png','jpg','jpeg');
                    if (!in_array($ext, $fileTypes)) {
                        return response()->json(['error' => '图片格式不正确']);
                    }
                    $path = $image->store('public');
                    $params['mg_pic'] = str_replace('public', '/storage', $path);
                }
            }

            $manager = Manager::create($params);
            if($manager) {
                return response()->json(['success' => $manager]);
            }
        }

        return view('Admin.manager.add');


    }

    //管理员编辑
    public function edit(Request $request)
    {
        $id = $request->mg_id;
        $info = Manager::find($id);

        if ($request->isMethod('post')) {
            //接受参数
            $id = $request->id;
            $params = $request->only('username', 'mg_role_ids', 'mg_sex', 'mg_phone', 'mg_email', 'mg_remark');

            if ($request->hasFile('file')) {
                $image = $request->file('file');
                if ($image->isValid()) {
                    $ext = $image->getClientOriginalExtension();
                    $fileTypes = array('gif','png','jpg','jpeg');
                    if (!in_array($ext, $fileTypes)) {
                        return response()->json(['error' => '图片格式不正确']);
                    }
                    $path = $image->store('public');
                    $params['mg_pic'] = str_replace('public', '/storage', $path);
                }
            }else{
                $params['mg_pic'] = $info['mg_pic'];
            }

            $manager = Manager::find($id)->update($params);
            return response()->json(['success' => $manager]);
        }

        return view('Admin.manager.edit', ['info' => $info]);
    }

    //管理员删除
    public function del(Request $request)
    {
        $id = $request->id;
        if ($id == 1) {
            return response()->json(['error' => '超级管理员不能被删除！']);
        }
        $rs = Manager::find($id)->delete();

        if ($rs === false) {
            return response()->json(['success' => false]);
        }else{
            return response()->json(['success' => true]);
        }

    }

    //管理员批量更新
    public function batchUpdate(Request $request)
    {
        //接受参数
        $ids = $request->ids;
        $errors = [];

        if (is_array($ids)) {
            foreach ($ids as $id) {
                $order_id = 'order_id' . $id;
                $order_id = $request->input($order_id);
                $rs = Manager::find($id)->update(['order_id' => $order_id]);
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

    //管理员批量删除
    public function batchDel(Request $request)
    {
        //接受参数
        $ids = $request->ids;
        $errors = [];

        if (in_array('1', $ids)) {
            return response()->json(['error' => '超级管理员不能被删除！']);
        }
        if (is_array($ids)) {
            foreach ($ids as $id) {
                $rs = Manager::find($id)->delete();
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
