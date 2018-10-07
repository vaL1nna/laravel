<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NavType extends Model
{
    protected $table = "nav_type";

    protected $fillable = [
        'id',
        'name'
    ];
}
