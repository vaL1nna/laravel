<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
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
                echo "认证成功";
            }else{
                echo "认证失败";
            }
        }
    }
}
