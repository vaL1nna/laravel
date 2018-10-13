<?php

namespace App\Http\Controllers\Admin;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends CommonController
{
    public function system(Request $request)
    {
        $info = Setting::find('1');

        if ($request->isMethod('post')) {
            //接受参数
            $params = $request->only('web_name', 'web_contacts', 'web_email', 'web_tel', 'web_phone', 'web_fax', 'web_addr', 'web_icp', 'web_share', 'web_map', 'web_copyright',  'url', 'title', 'keyword', 'description');

            if ($request->hasFile('web_logo')) {
                $image = $request->file('web_logo');
                if ($image->isValid()) {
                    $ext = $image->getClientOriginalExtension();
                    $fileTypes = array('gif','png','jpg','jpeg');
                    if (!in_array($ext, $fileTypes)) {
                        return response()->json(['error' => '图片格式不正确']);
                    }
                    $path = $image->store('public');
                    $params['web_logo'] = str_replace('public', '/storage', $path);
                }
            }else{
                $params['web_logo'] = $info['web_logo'];
            }

            $setting = Setting::find('1')->update($params);
            return response()->json(['success' => $setting]);
        }

        return view('Admin.setting.system', ['info' => $info]);
    }

    public function service(Request $request)
    {
        $info = Setting::find('1');

        if ($request->isMethod('post')) {
            //接受参数
            $params = $request->only('qq_account1', 'qq_name1', 'qq_account2', 'qq_name2', 'qq_account3', 'qq_name3', 'is_online');

            if ($request->hasFile('web_qrcode')) {
                $image = $request->file('web_qrcode');
                if ($image->isValid()) {
                    $ext = $image->getClientOriginalExtension();
                    $fileTypes = array('gif','png','jpg','jpeg');
                    if (!in_array($ext, $fileTypes)) {
                        return response()->json(['error' => '图片格式不正确']);
                    }
                    $path = $image->store('public');
                    $params['web_qrcode'] = str_replace('public', '/storage', $path);
                }
            }else{
                $params['web_qrcode'] = $info['web_qrcode'];
            }

            $setting = Setting::find('1')->update($params);
            return response()->json(['success' => $setting]);
        }

        return view('Admin.setting.service', ['info' => $info]);
    }
}
