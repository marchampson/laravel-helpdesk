<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = "teams";

    protected $guarded = ['id'];

    public function domains() {
        return $this->hasMany('\App\Domain');
    }

    public function agents() {
        return $this->hasMany('\App\Agent');
    }

    public function plans() {
        return $this->belongsTo('\App\Plan');
    }
}
