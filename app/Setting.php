<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = "setting";

    protected $fillable = [
        'web_name',
        'web_logo',
        'web_contacts',
        'web_email',
        'web_tel',
        'web_phone',
        'web_fax',
        'web_addr',
        'web_icp',
        'web_share',
        'web_copyright',
        'web_qrcode',
        'is_online',
        'qq_account1',
        'qq_name1',
        'qq_account2',
        'qq_name2',
        'qq_account3',
        'qq_name3',
        'keyword',
        'title',
        'description',
        'url',
    ];

    public function banner()
    {
        return $this->hasMany('App\Banner', 'setting_id', 'id');
    }
}
