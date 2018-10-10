<?php

namespace App\Http\Controllers\Admin;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends CommonController
{
    public function list()
    {
        //获取数据
        $data = Setting::all();

        $total = $data->count();
        $data = $data->paginate(10);

        return view('Admin.setting.list', ['data' => $data, 'total' => $total]);

    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $info = Setting::find($id);

        if ($request->isMethod('post')) {
            //接受参数
            $id = $request->id;
            $params = $request->only('name', 'contact_person', 'email', 'contact_number', 'telephone', 'fax', 'address', 'case_number', 'url', 'title', 'keyword', 'description');

            if ($request->hasFile('logo')) {
                $image = $request->file('logo');
                if ($image->isValid()) {
                    $ext = $image->getClientOriginalExtension();
                    $fileTypes = array('gif','png','jpg','jpeg');
                    if (!in_array($ext, $fileTypes)) {
                        return response()->json(['error' => '图片格式不正确']);
                    }
                    $path = $image->store('public');
                    $params['logo'] = str_replace('public', '/storage', $path);
                }
            }else{
                $params['logo'] = $info['logo'];
            }

            $setting = Setting::find($id)->update($params);
            return response()->json($setting);
        }

        //获取所有分类信息
        $menu = Nav::where('type_id', '2')->where('parent_id', '!=', '0')->orderBy('order_id')->get();


        return view('Admin.setting.edit', ['menu' => $menu, 'info' => $info]);
    }
}
