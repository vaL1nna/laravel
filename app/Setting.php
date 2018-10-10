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
        'name',
        'logo',
        'contact_person',
        'email',
        'contact_number',
        'telephone',
        'fax',
        'address',
        'case_number',
        'keyword',
        'title',
        'description',
        'url',
    ];
}
