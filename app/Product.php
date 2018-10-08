<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = "product";

    protected $fillable = [
        'id',
        'menu_id',
        'order_id',
        'product_name',
        'product_content',
        'product_file',
        'product_image',
        'is_show',
        'product_attribute1',
        'product_attribute2',
        'product_attribute3',
        'product_attribute4',
        'product_attribute5',
        'product_attribute6',
        'product_attribute7',
        'product_attribute8',
        'product_attribute9',
        'product_attribute10',
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
