<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nav extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = "nav";

    protected $fillable = [
        'id',
        'parent_id',
        'order_id',
        'type_id',
        'nav_name',
        'nav_content',
        'nav_image',
        'position',
        'keyword',
        'title',
        'description',
        'url',
    ];

    public function parent()
    {
        return $this->hasOne('App\Nav', 'id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Nav', 'parent_id', 'id');
    }
}
