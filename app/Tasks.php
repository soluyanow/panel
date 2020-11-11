<?php

namespace App;

use App\Clients;
use App\Statuses;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $table = 'tasks';

    protected $fillable = ['prev', 'source', 'statuses_id', 'clients_id', 'types_id', 'updated_at'];
    protected $guarded = [];

    public function clients()
    {
        return $this->belongsTo(Clients::class);
    }

    public function statuses()
    {
        return $this->belongsTo(Statuses::class);
    }
}
