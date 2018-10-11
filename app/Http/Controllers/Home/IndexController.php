<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Nav;
use App\News;
use App\Setting;

class IndexController extends Controller
{
    public function index()
    {
        //
        $header = Nav::with(['children'])->where('position', '0')->orWhere('position', '1')->get()->toArray();
//TODO
        $banner = '';

        $setting = Setting::find('1');
        if (!empty($setting)) {
            $setting = $setting->toArray();
        }

        $product = Nav::select('id', 'nav_name', 'nav_image')->where('type_id', '2')->where('parent_id', '!=', '0')->limit('6')->get()->toArray();

        $application = Nav::select('id', 'nav_name', 'nav_image')->where('type_id', '3')->where('parent_id', '!=', '0')->limit('6')->get()->toArray();

        $news = News::select('id', 'news_name')->orderBy('order_id')->limit('10')->get()->toArray();

        $data = ['header' => $header, 'setting' => $setting, 'product' => $product, 'application' => $application, 'news' => $news];
        return response()->json(['success' => 'true', 'err_code' => '', 'err_msg' => '', 'data' => $data]);
    }
}
