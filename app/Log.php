<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = "logs";

    protected $guarded = ['id'];

    public function ticket() {
        return $this->belongsTo('\App\Ticket');
    }

    public function agent() {
        return $this->belongsTo('\App\Agent');
    }
}
