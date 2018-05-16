<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = "tickets";

    protected $guarded = ['id'];

    public function domain()
    {
        return $this->belongsTo('\App\Domain');
    }

    public function logs()
    {
        return $this->hasMany('\App\Logs');
    }

}
