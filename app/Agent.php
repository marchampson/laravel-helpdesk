<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{

    protected $table = "agents";

    protected $guarded = ['id'];

    public function logs() {
        return $this->hasMany('\App\Log');
    }

    public function team() {
        return $this->belongsTo('\App\Team');
    }
}
