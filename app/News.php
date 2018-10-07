<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = "news";

    protected $fillable = [
        'id',
        'menu_id',
        'order_id',
        'news_name',
        'news_content',
        'keyword',
        'title',
        'description',
        'url',
    ];

    public function parent()
    {
        return $this->hasOne('App\Nav', 'id', 'menu_id');
    }
}
