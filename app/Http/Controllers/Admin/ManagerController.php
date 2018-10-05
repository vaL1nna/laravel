<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ManagerController extends Controller
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

    //管理员列表页
    public function list(Request $request)
    {
        if ($request->ajax()) {
            //获取所有数据
            $startDate = $request->startDate;
            $endDate = $request->endDate;
            $keyword = $request->keyword;

            //获取数据
            $data = Manager::query();

            if (isset($startDate) && isset($endDate)) {
                $data = $data->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
            }

            if (isset($keyword)) {
                $data = $data->where(function ($query) use ($keyword) {
                    $query->where('username', 'like', '%' . strtoupper($keyword) . '%');
                });
            }

            $paginate = $data->paginate(10);
            $data = $data->get()->toArray();

            return response()->json([
                'data' => $data,
                'paginate' => $paginate
            ]);

        }else{
            //获取所有数据
            $data = Manager::query();
            $total = $data->count();
            $data = $data->paginate(10);

            //分配数据到模版
            return view('Admin.manager.list', ['data' => $data, 'total' => $total]);
        }
    }

    //管理员添加页
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

    //管理员修改
    public function edit(Request $request)
    {
        $id = $request->mg_id;

        //获取数据
        $data = Manager::where('mg_id', $id)->first();

        if ($request->isMethod('get')) {
            //加载视图
            return view('Admin.manager.edit', ['data' => $data]);
        }elseif ($request->isMethod('post')) {
            //接受参数
            $params = $request->only('username', 'mg_sex', 'mg_phone', 'mg_email', 'mg_remark');
            $file = $request->file;

            if (empty($file)) {
                $file = $data['mg_pic'];
                $params['mg_pic'] = $file;
            }else{
                if ($file->isValid()) {
                    $path = $file->store('public');
                    $params['mg_pic'] = str_replace('public', '/storage', $path);
                }
            }

            $data = Manager::where('mg_id', $id)->update($params);
            if ($data) {
                return ['success' => true];
            }else{
                return ['success' => false];
            }
        }
    }
    
    //管理员删除
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

    //管理员批量删除
    public function batchDel(Request $request)
    {
        $ids = $request->ids;
        $errors = [];

        foreach ($ids as $id) {
            $rs = Manager::find($id)->delete();
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
