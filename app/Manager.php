<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manager extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
    use Authenticatable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = "manager";
    protected $primaryKey = "mg_id";
    protected $fillable = [
        'username',
        'password',
        'mg_role_ids',
        'mg_sex',
        'mg_phone',
        'mg_email',
        'mg_remark'
    ];
}
