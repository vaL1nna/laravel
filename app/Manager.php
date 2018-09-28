<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
    use Authenticatable;
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
