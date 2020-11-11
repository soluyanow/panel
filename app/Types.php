<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Types extends Model
{
    protected $table = 'Types';

    protected $fillable = [
        'name',
        /*'active',*/
    ];

    protected $guarded = [];
}
