<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = "plans";

    protected $guarded = ['id'];

    public function teams() {
        return $this->hasMany('\App\Team');
    }
}
