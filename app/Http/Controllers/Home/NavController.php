<?php

namespace App\Http\Controllers\Home;

use App\Nav;
use Illuminate\Http\Request;

class NavController extends CommonController
{
    public function header(Request $request)
    {
        $data = Nav::where('position', '0')->orWhere('position', '1')->get()->toArray();
        $data = $this->getTree($data, 0, 1);
        return response()->json($data);
    }

    public function footer(Request $request)
    {
        $data = Nav::where('position', '0')->orWhere('position', '2')->get()->toArray();
        $data = $this->getTree($data, 0, 1);
        return response()->json($data);
    }
}
