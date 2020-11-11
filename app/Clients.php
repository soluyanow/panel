<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $table = 'Clients';

    protected $fillable = [
        'name',
        'active',
        'period_update',
        'period_execute',
        'period_copy',
        'period_update_measure',
        'period_execute_measure',
        'period_copy_measure',
        'period_copy_type',
        'period_execute_type',
        'period_update_type'
    ];

    protected $guarded = [];
}
