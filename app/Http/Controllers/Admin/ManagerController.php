<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ManagerController extends Controller
{
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

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }

    public function list()
    {
        //获取所有数据
        $data = Manager::paginate(10);

        //分配数据到模版
        return view('Admin.manager.list', ['data' => $data]);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('get')) {
            //显示视图
            return view('Admin.manager.add');
        }elseif ($request->isMethod('post')) {
            //数据处理
            $manager = Manager::create($request->all());
            $manager->password = bcrypt($request->input('password'));

            $file = $request->file('file');
            if ($file->isValid()) {
                $path = $file->store('public');
                $manager->mg_pic = str_replace('public', '/storage', $path);
            }

            //保存到数据库
            if ($manager->save()) {
                return ['success' => true];
            }else{
                return ['success' => false];
            }
        }
    }

    public function del(Request $request)
    {
        $id = $request->input('mg_id');
        $rs = Manager::find($id)->delete();

        if ($rs === false) {
            return ['success' => false];
        }else{
            return ['success' => true];
        }
    }
}
