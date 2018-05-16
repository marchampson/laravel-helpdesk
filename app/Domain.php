<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $table = "domains";

    protected $guarded = ['id'];

    public function teams() {
        return $this->belongsTo('\App\Team');
    }

    public function tickets() {
        return $this->hasMany('App\Ticket');
    }
}
