<?php

namespace App;

use App\Statuses as StatusesList;
use Illuminate\Database\Eloquent\Model;

class Statuses extends Model
{
    protected $table = 'Statuses';

    protected $fillable = ['name', 'identity'];
    protected $guarded = [];

    public function index()
    {
        return view('statuses')->with('statuses', StatusesList::all());
    }

}
