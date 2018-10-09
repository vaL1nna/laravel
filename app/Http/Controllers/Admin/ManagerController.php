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
            $params = $request->only('menu_id', 'order_id', 'manager_name', 'manager_content', 'keyword', 'title', 'description', 'url', 'is_show', 'manager_attribute1', 'manager_attribute2', 'manager_attribute3', 'manager_attribute4', 'manager_attribute5', 'manager_attribute6', 'manager_attribute7', 'manager_attribute8', 'manager_attribute9', 'manager_attribute10');
            if ($request->hasFile('manager_image')) {
                $image = $request->file('manager_image');
                if ($image->isValid()) {
                    $ext = $image->getClientOriginalExtension();
                    $fileTypes = array('gif','png','jpg','jpeg');
                    if (!in_array($ext, $fileTypes)) {
                        return response()->json(['error' => '图片格式不正确']);
                    }
                    $path = $image->store('public');
                    $params['manager_image'] = str_replace('public', '/storage', $path);
                }
            }

            if ($request->hasFile('manager_file')) {
                $file = $request->file('manager_file');
                if ($file->isValid()) {
                    /*$fileName = $file->getClientOriginalName();
                    $fileName = explode('.', $fileName)[0] . '_' . date('ymd');*/
                    $ext = $file->getClientOriginalExtension();
                    if ($ext != 'pdf') {
                        return response()->json(['error' => '上传的pdf格式不正确']);
                    }
                    $path = $file->store('public');
                    $params['manager_file'] = str_replace('public', '/storage', $path);
                }
            }

            $data = Manager::create($params);
            $data->order_id = $data->id;
            $data->save();
        }
        //获取所有分类信息
        $menu = Nav::where('type_id', '2')->where('parent_id', '!=', '0')->orderBy('order_id')->get();

        return view('Admin.manager.add', ['menu' => $menu]);


    }

    //管理员编辑
    public function edit(Request $request)
    {
        $id = $request->id;
        $info = Manager::find($id);

        if ($request->isMethod('post')) {
            //接受参数
            $id = $request->id;
            $params = $request->only('menu_id', 'order_id', 'manager_name', 'manager_content', 'keyword', 'title', 'description', 'url', 'manager_image', 'manager_file', 'is_show', 'manager_attribute1', 'manager_attribute2', 'manager_attribute3', 'manager_attribute4', 'manager_attribute5', 'manager_attribute6', 'manager_attribute7', 'manager_attribute8', 'manager_attribute9', 'manager_attribute10');

            if ($request->hasFile('manager_image')) {
                $image = $request->file('manager_image');
                if ($image->isValid()) {
                    $ext = $image->getClientOriginalExtension();
                    $fileTypes = array('gif','png','jpg','jpeg');
                    if (!in_array($ext, $fileTypes)) {
                        return response()->json(['error' => '图片格式不正确']);
                    }
                    $path = $image->store('public');
                    $params['manager_image'] = str_replace('public', '/storage', $path);
                }
            }else{
                $params['manager_image'] = $info['manager_image'];
            }

            if ($request->hasFile('manager_file')) {
                $file = $request->file('manager_file');
                if ($file->isValid()) {
                    /*$fileName = $file->getClientOriginalName();
                    $fileName = explode('.', $fileName)[0] . '_' . date('ymd');*/
                    $ext = $file->getClientOriginalExtension();
                    if ($ext != 'pdf') {
                        return response()->json(['error' => '上传的pdf格式不正确']);
                    }
                    $path = $file->store('public');
                    $params['manager_file'] = str_replace('public', '/storage', $path);
                }
            }else{
                $params['manager_file'] = $info['manager_file'];
            }

            Manager::find($id)->update($params);
        }

        //获取所有分类信息
        $menu = Nav::where('type_id', '2')->where('parent_id', '!=', '0')->orderBy('order_id')->get();


        return view('Admin.manager.edit', ['menu' => $menu, 'info' => $info]);
    }

    //管理员删除
    public function del(Request $request)
    {
        $id = $request->id;
        $rs = Manager::find($id)->delete();

        if ($rs === false) {
            return ['success' => false];
        }else{
            return ['success' => true];
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
            return ['success' => false];
        }else{
            return ['success' => true];
        }
    }

    //管理员批量删除
    public function batchDel(Request $request)
    {
        //接受参数
        $ids = $request->ids;
        $errors = [];

        if (is_array($ids)) {
            foreach ($ids as $id) {
                $rs = Manager::find($id)->delete();
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
