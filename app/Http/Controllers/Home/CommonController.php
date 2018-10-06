<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    public function getTree($data, $id, $lev)
    {
        static $list = [];
        foreach ($data as $key => $value) {
            if ($value['parent_id'] == $id) {
                $value['lev'] = $lev;
                $list[] = $value;
                $this->getTree($data, $value['id'], $lev+1);
            }
        }
        return $list;
    }
}
